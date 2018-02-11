<?php
namespace WebTorque\SilverstripeHelpers\Tests\Blocks;

use SilverStripe\Dev\SapphireTest;
use WebTorque\SilverstripeHelpers\Tests\Mocks\DummyPage;
use WebTorque\SilverstripeHelpers\Blocks\AutoPublishElementalExtension;


class AutoPublishElementalBlocksExtensionTest extends SapphireTest
{

    protected static $fixture_file = 'AutoPublishElementalBlocksExtensionTest.yml';

    /**
     * Make sure AutoPublishElementalFields default to `ElementalArea`.
     */
    public function testAutoPublishElementalFields() {
        DummyPage::add_extension('WebTorque\\SilverstripeHelpers\\Tests\\Blocks\\AutoPublishElementalExtension');
        $config = DummyPage::config();

        // Make sure AutoPublishElementalFields defaults to `['ElementalArea']`
        $config->set('auto_publish_elemental_fields', null);
        $dummy = new DummyPage();
        $fields = $dummy->getAutoPublishElementalFields();
        $this->assertEquals($fields, ['ElementalArea']);

        $config->set('auto_publish_elemental_fields', []);
        $dummy = new DummyPage();
        $fields = $dummy->getAutoPublishElementalFields();
        $this->assertEquals($fields, ['ElementalArea']);

        // Make sure that any AutoPublishElementalFields string gets wrapped in an array.
        $config->set('auto_publish_elemental_fields', 'AlternativeElementalName');
        $dummy = new DummyPage();
        $fields = $dummy->getAutoPublishElementalFields();
        $this->assertEquals($fields, ['AlternativeElementalName']);

        // Make sure that AutoPublishElementalFields handles array properly.
        $config->set('auto_publish_elemental_fields', ['elementalOne', 'elementalTwo']);
        $fields = $dummy->getAutoPublishElementalFields();
        $this->assertEquals($fields, ['elementalOne', 'elementalTwo']);
    }

    /**
     * Make sure AutoPublishElementalFields default to `ElementalArea`.
     */
    public function testAutoPublishElementalDisable() {
        DummyPage::add_extension('WebTorque\\SilverstripeHelpers\\Tests\\Blocks\\AutoPublishElementalExtension');
        $config = DummyPage::config();

        // Make sure AutoPublishElementalDisable defaults to false
        $config->set('auto_publish_elemental_fields', null);
        $dummy = new DummyPage();
        $this->assertFalse($dummy->getAutoPublishElementalDisable());

        // Make sure AutoPublishElementalDisable returns true when the flag is set.
        $config->set('auto_publish_elemental_disable', true);
        $dummy = new DummyPage();
        $this->assertTrue($dummy->getAutoPublishElementalDisable());
    }
}
