<?php

namespace Umanit\SeoBundle\Runtime;

use Umanit\SeoBundle\Doctrine\Annotation\Route;

/**
 * Class CurrentSeoEntity
 *
 * Represents the currently requested
 * Seo @Route() entity on the current route.
 *
 * @author Arthur Guigand <aguigand@umanit.fr>
 */
class CurrentSeoEntity
{
    /** @var */
    private $value;

    public function get()
    {
        return $this->value;
    }

    public function set($value)
    {
        $this->value = $value;
    }
}
