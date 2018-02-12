<?php
namespace WebTorque\SilverstripeHelpers\Tests\Blocks;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Versioned\Versioned;
use WebTorque\SilverstripeHelpers\Tests\Mocks\DummyPage;
use WebTorque\SilverstripeHelpers\Tests\Mocks\DummyElement;
use WebTorque\SilverstripeHelpers\Blocks\AutoPublishElementalExtension;
use DNADesign\Elemental\Models\ElementalArea;

class AutoPublishElementalBlocksExtensionTest extends SapphireTest
{
    protected static $fixture_file = 'AutoPublishElementalBlocksExtensionTest.yml';

    /**
     * Make sure AutoPublishElementalFields default to `ElementalArea`.
     */
    public function testAutoPublishElementalFields()
    {
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
    public function testAutoPublishElementalDisable()
    {
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

    public function testOnAfterPublish()
    {
        // Make sure all our object are fully saved to the DB
        $this->objFromFixture(DummyElement::class, 'element1')->write();
        $this->objFromFixture(DummyElement::class, 'element2')->write();
        $this->objFromFixture(ElementalArea::class, 'area1')->write();
        $page = $this->objFromFixture(DummyPage::class, 'page1')->write();
        $page = $this->objFromFixture(DummyPage::class, 'page1');

        // Make sure our element has a published version
        $block = $this->objFromFixture(DummyElement::class, 'element1');
        $block->copyVersionToStage(Versioned::DRAFT, Versioned::LIVE, false);
        $blockV1 = $block->Version;

        // Create a new version of our Elemental block
        $block->TestValue = "New updated value";
        $block->write();
        $blockV2 = $block->Version;
        $this->assertEquals($blockV1, $blockV2-1, 'When writting a block it should create a new version');

        // Make sure we Live and Stage Versions differ
        $this->assertTrue($block->stagesDiffer(), 'The live block and staged block should be different.');

        // Publish the parent page
        $page = $this->objFromFixture(DummyPage::class, 'page1');
        var_dump(ElementalArea::singleton()->baseTable());
        $page->copyVersionToStage(Versioned::DRAFT, Versioned::LIVE, false);

        // Publishing the Parent page should have published the blocks underneat it
        var_dump(ElementalArea::get()->Count());
        die();

        $live = Versioned::get_versionnumber_by_stage(DummyElement::class, 'Live', $block->ID);
        $draft = Versioned::get_versionnumber_by_stage(DummyElement::class, 'Stage', $block->ID);
        $this->assertEquals($live, $draft, "The Elemental block should have been published with its parent page.");

        //     $thirdVersion = Versioned::get_latest_version(VersionedTest\TestObject::class, $page1->ID)->Version;
    //     $liveVersion = Versioned::get_versionnumber_by_stage(VersionedTest\TestObject::class, 'Live', $page1->ID);
    //     $stageVersion = Versioned::get_versionnumber_by_stage(VersionedTest\TestObject::class, 'Stage', $page1->ID);
    //
    //
    //     $dummy = $this->objFromFixture(DummyPage::class, 'page1');
    //     $dummy->Content = 'orig';
    //     $dummy->write();
    //
    //     $firstVersion = $page1->Version;
    //     $page1->copyVersionToStage(Versioned::DRAFT, Versioned::LIVE, false);
    //     $this->assertEquals(
    //         $firstVersion,
    //         $page1->Version,
    //         'publish() with $createNewVersion=FALSE does not create a new version'
    //     );
    }
}
