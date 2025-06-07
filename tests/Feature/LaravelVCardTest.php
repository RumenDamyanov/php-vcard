<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Illuminate\Container\Container;
use Rumenx\PhpVcard\Laravel\VCardServiceProvider;
use Rumenx\PhpVcard\VCard;

it('can resolve VCard via Laravel container', function () {
    $container = new Container();
    $provider = new VCardServiceProvider($container);
    $provider->register();
    $vcard = $container->make(VCard::class);
    expect($vcard)->toBeInstanceOf(VCard::class);
    $vcard->addName('Arya', 'Stark');
    expect($vcard->toString())->toContain('FN:Arya Stark');
});

it('VCard is a singleton in Laravel container', function () {
    $container = new Container();
    $provider = new VCardServiceProvider($container);
    $provider->register();
    $vcard1 = $container->make(VCard::class);
    $vcard2 = $container->make(VCard::class);
    expect($vcard1)->toBe($vcard2);
});

it('VCardServiceProvider provides VCard class', function () {
    $container = new Container();
    $provider = new VCardServiceProvider($container);
    expect($provider->provides())->toBe([VCard::class]);
});
