<?php

namespace Umanit\SeoBundle\Doctrine\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\RequestStack;
use Umanit\SeoBundle\Exception\NotSeoRouteEntityException;
use Umanit\SeoBundle\Routing\Canonical;
use Umanit\SeoBundle\Runtime\CurrentSeoEntity;

/**
 * Class CurrentEntityResolver
 *
 * Matches each entity loaded against the current
 * request to resolve the requested Seo entity.
 *
 * @author Arthur Guigand <aguigand@umanit.fr>
 */
class CurrentEntityResolver implements EventSubscriber
{
    /** @var CurrentSeoEntity */
    private $currentSeoEntity;

    /** @var Canonical */
    private $canonical;

    /** @var RequestStack */
    private $requestStack;

    /**
     * CurrentEntityResolver constructor.
     *
     * @param CurrentSeoEntity $currentSeoEntity
     * @param Canonical        $canonical
     * @param RequestStack     $requestStack
     */
    public function __construct(CurrentSeoEntity $currentSeoEntity, Canonical $canonical, RequestStack $requestStack)
    {
        $this->currentSeoEntity = $currentSeoEntity;
        $this->canonical        = $canonical;
        $this->requestStack     = $requestStack;
    }

    /**
     * @return array|string[]
     */
    public function getSubscribedEvents()
    {
        return [Events::postLoad];
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args): void
    {
        $request = $this->requestStack->getCurrentRequest();
        if (null === $request) {
            return;
        }

        $entity = $args->getEntity();
        try {
            if (null === $this->currentSeoEntity->get() && $this->canonical->path($entity) === $request->getPathInfo()) {
                $this->currentSeoEntity->set($entity);
            }
        } catch (NotSeoRouteEntityException $e) {
            // Do nothing
        }
    }
}
