<?php

namespace Rumenx\PhpVcard\Laravel;

use Illuminate\Support\ServiceProvider;
use Rumenx\PhpVcard\VCard;

class VCardServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(VCard::class, function ($app) {
            return new VCard();
        });
    }

    public function provides()
    {
        return [VCard::class];
    }
}
