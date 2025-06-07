<?php

// Feature test for the VCardFacade in Laravel integration.
// Verifies that static calls are forwarded to the VCard instance.

use Rumenx\PhpVcard\Laravel\VCardFacade;
use Rumenx\PhpVcard\VCard;

it('VCardFacade forwards static calls to VCard', function () {
    // Manually bind VCard to the Facade root for this test
    VCardFacade::swap(new VCard());
    VCardFacade::addName('Arya', 'Stark');
    VCardFacade::addEmail('arya@example.com');
    $content = VCardFacade::toString();
    expect($content)->toContain('FN:Arya Stark');
    expect($content)->toContain('EMAIL:arya@example.com');
});
