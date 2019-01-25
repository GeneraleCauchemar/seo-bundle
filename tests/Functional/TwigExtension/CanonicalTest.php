<?php

namespace Umanit\SeoBundle\Tests\functional\TwigExtension;

use AppTestBundle\Entity\SeoPage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Client;
use Umanit\SeoBundle\Tests\WebTestCase;

/**
 * Class CanonicalTest
 *
 * @author Arthur Guigand <aguigand@umanit.fr>
 */
class CanonicalTest extends WebTestCase
{
    /** @var Client */
    private $client;
    /** @var EntityManagerInterface */
    private $em;

    public function setUp()
    {
        $kernel       = self::bootKernel();
        $this->client = $kernel->getContainer()->get('test.client');
        $this->em     =
            $kernel
                ->getContainer()
                ->get('doctrine')
                ->getManager()
        ;

    }

    public function tearDown()
    {
        $this->client = null;
    }

    public function testCanonicalWithoutParameters()
    {
        $page = (new SeoPage())->setSlug('test-canonical');
        $this->em->persist($page);
        $this->em->flush();
        $this->em->refresh($page);
        $this->em->clear();

        $this->client->request('GET', '/page/test-canonical');

        $this->assertEquals($this->client->getResponse()->getContent(), '<link rel="canonical" href="http://localhost/page/test-canonical"/>
'); // Keep the line break like this
    }

    public function testCanonicalWithParameters()
    {
        $page = (new SeoPage())->setSlug('test-canonical-params');
        $this->em->persist($page);
        $this->em->flush();
        $this->em->refresh($page);
        $this->em->clear();

        $this->em->clear();
        $this->client->request('GET', '/test/canonical/with/parameters/test-canonical-params');

        $this->assertEquals($this->client->getResponse()->getContent(), '<link rel="canonical" href="http://localhost/page/test-canonical-params"/>
'); // Keep the line break like this
    }
}