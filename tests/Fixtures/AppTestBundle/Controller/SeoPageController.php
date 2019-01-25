<?php

namespace AppTestBundle\Controller;

use AppTestBundle\Entity\SeoPage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeoPageController extends AbstractController
{
    /**
     * @Route("/page/{slug}", name="app_test_page_show")
     * @param string $slug
     *
     * @return Response
     */
    public function show(string $slug)
    {
        $page = $this->getDoctrine()->getRepository(SeoPage::class)->findOneBy(['slug' => $slug]);
        if (null === $page) {
            throw $this->createNotFoundException();
        }

        return $this->render('@AppTestBundle/seo_page/show.html.twig', [
            'page' => $page,
        ]);
    }

    /**
     * @Route("/test/canonical/with/parameters/{slug}", name="app_test_canonical_w_params")
     * @param string $slug
     *
     * @return Response
     */
    public function testCanonicalWithParams(string $slug)
    {
        $page = $this->getDoctrine()->getRepository(SeoPage::class)->findOneBy(['slug' => $slug]);
        if (null === $page) {
            throw $this->createNotFoundException();
        }

        return $this->render('@AppTestBundle/seo_page/show_canonical_with_params.html.twig', [
            'page' => $page,
        ]);
    }
}
