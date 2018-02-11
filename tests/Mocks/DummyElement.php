<?php
namespace WebTorque\SilverstripeHelpers\Tests\Mocks;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Versioned\Versioned;

/**
 * Fake Elemental Block type.
 */
class DummyElement extends BaseElement
{
    private static $db = [
        'TestValue' => 'Text'
    ];

    public function i18n_singular_name()
    {
        return 'A test element';
    }

    // private static $extensions = [
    //     Versioned::class
    // ];
}
