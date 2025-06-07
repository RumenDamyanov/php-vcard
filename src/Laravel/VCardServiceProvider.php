<?php

namespace Rumenx\PhpVcard\Laravel;

use Illuminate\Support\ServiceProvider;
use Rumenx\PhpVcard\VCard;

/**
 * Laravel Service Provider for the VCard package.
 *
 * Registers the VCard class as a singleton in the Laravel service container,
 * enabling dependency injection and facade usage.
 */
class VCardServiceProvider extends ServiceProvider
{
    /**
     * Register the VCard singleton in the container.
     */
    public function register()
    {
        $this->app->singleton(VCard::class, function ($app) {
            return new VCard();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [VCard::class];
    }
}
