<?php

namespace Rumenx\PhpVcard\Laravel;

use Illuminate\Support\Facades\Facade;

class VCardFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Rumenx\PhpVcard\VCard::class;
    }
}
