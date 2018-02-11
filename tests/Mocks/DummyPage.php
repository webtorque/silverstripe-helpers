<?php
namespace WebTorque\SilverstripeHelpers\Tests\Mocks;

use DNADesign\Elemental\Extensions\ElementalPageExtension;
use SilverStripe\CMS\Model\SiteTree;
use WebTorque\SilverstripeHelpers\Blocks\AutoPublishElementalExtension;


/**
 * Dummy page that gets our AutoPublishElementalExtension applied to it for testing purposes
 */
class DummyPage extends \Page {

    // private static $table_name = 'DummyPage';

    private static $extensions = [
        ElementalPageExtension::class,
        AutoPublishElementalExtension::class,
    ];

}
