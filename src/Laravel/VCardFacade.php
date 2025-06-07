<?php

namespace Rumenx\PhpVcard\Laravel;

use Illuminate\Support\Facades\Facade;

/**
 * Facade for the VCard class.
 *
 * Allows static-like access to VCard methods via the Laravel facade system.
 */
class VCardFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Rumenx\PhpVcard\VCard::class;
    }
}
