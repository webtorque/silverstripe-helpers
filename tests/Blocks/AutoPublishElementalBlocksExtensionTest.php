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

    /**
     * Make sure child blocks are published after their parent page is published
     */
    public function testOnAfterPublish()
    {
        // Make sure our element has a published version
        $block = $this->objFromFixture(DummyElement::class, 'element1');
        $block->copyVersionToStage(Versioned::DRAFT, Versioned::LIVE, false);
        $blockV1 = $block->Version;

        // Create a new version of our Elemental block
        $block->TestValue = "New updated value";
        $block->write();
        $blockV2 = $block->Version;
        $this->assertEquals($blockV1, $blockV2-1, 'When writting a block it should create a new version');

        // Make sure Live and Stage Versions differ
        $this->assertTrue($block->stagesDiffer(), 'The live block and staged block should be different.');

        // Make a change to the page without publishing
        $page = $this->objFromFixture(DummyPage::class, 'page1');
        $page->Title = 'Brand new title';
        $page->write();

        // The child block should still be unpublished
        $live = Versioned::get_versionnumber_by_stage(DummyElement::class, 'Live', $block->ID);
        $draft = Versioned::get_versionnumber_by_stage(DummyElement::class, 'Stage', $block->ID);
        $this->assertNotEquals($live, $draft, "The Elemental block should still be unpulishedwith when its parent page gets a standard write.");

        // Publish the parent page
        $page->copyVersionToStage(Versioned::DRAFT, Versioned::LIVE, false);

        // Make sure the page is published
        $live = Versioned::get_versionnumber_by_stage(DummyPage::class, 'Live', $page->ID);
        $draft = Versioned::get_versionnumber_by_stage(DummyPage::class, 'Stage', $page->ID);
        $this->assertEquals($live, $draft, "The Dummy Page block should have been published with its parent page.");

        // Publishing the Parent page should have published the blocks underneat it
        $live = Versioned::get_versionnumber_by_stage(DummyElement::class, 'Live', $block->ID);
        $draft = Versioned::get_versionnumber_by_stage(DummyElement::class, 'Stage', $block->ID);
        $this->assertEquals($live, $draft, "The Elemental block should have been published with its parent page.");
    }

    /**
     * If auto_publish_elemental_disable is disable, no auto publish should occur.
     */
    public function testOnAfterPublishWithDisableAutoPublishing()
    {
        // Disable auto publishing
        DummyPage::config()->set('auto_publish_elemental_disable', true);

        // Make sure our element has a published version
        $block = $this->objFromFixture(DummyElement::class, 'element1');
        $block->copyVersionToStage(Versioned::DRAFT, Versioned::LIVE, false);
        $blockV1 = $block->Version;

        // Create a new version of our Elemental block
        $block->TestValue = "New updated value";
        $block->write();
        $blockV2 = $block->Version;
        $this->assertEquals($blockV1, $blockV2-1, 'When writting a block it should create a new version');

        // Make sure Live and Stage Versions differ
        $this->assertTrue($block->stagesDiffer(), 'The live block and staged block should be different.');

        // Make a change to the page without publishing
        $page = $this->objFromFixture(DummyPage::class, 'page1');
        $page->Title = 'Brand new title';
        $page->write();

        // The child block should still be unpublished
        $live = Versioned::get_versionnumber_by_stage(DummyElement::class, 'Live', $block->ID);
        $draft = Versioned::get_versionnumber_by_stage(DummyElement::class, 'Stage', $block->ID);
        $this->assertNotEquals($live, $draft, "The Elemental block should still be unpulishedwith when its parent page gets a standard write.");

        // Publish the parent page
        $page->copyVersionToStage(Versioned::DRAFT, Versioned::LIVE, false);

        // Make sure the page is published
        $live = Versioned::get_versionnumber_by_stage(DummyPage::class, 'Live', $page->ID);
        $draft = Versioned::get_versionnumber_by_stage(DummyPage::class, 'Stage', $page->ID);
        $this->assertEquals($live, $draft, "The Dummy Page block should have been published with its parent page.");

        // Publishing the Parent page should have published the blocks underneat it
        $live = Versioned::get_versionnumber_by_stage(DummyElement::class, 'Live', $block->ID);
        $draft = Versioned::get_versionnumber_by_stage(DummyElement::class, 'Stage', $block->ID);
        $this->assertNotEquals($live, $draft, "The Elemental block should not have been published with its parent page because auto publishing is disable.");
    }
}
