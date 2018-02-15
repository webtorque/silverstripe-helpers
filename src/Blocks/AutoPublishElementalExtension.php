<?php

namespace WebTorque\SilverstripeHelpers\Blocks;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Versioned\Versioned;
use DNADesign\Elemental\Models\ElementalArea;
use WebTorque\SilverstripeHelpers\Tests\Mocks\DummyPage;
use WebTorque\SilverstripeHelpers\Tests\Mocks\DummyElement;

/**
 * Extends a SiteTree to auto publish all its elemental blocks when the it's published.
 *
 * You can define the following flag on your class to control this behavior:
 * * `auto_publish_elemental_disable`: Allows you to disable the auto publishing feature in child classes. Default to
 * `false`.
 *
 */
class AutoPublishElementalExtension extends DataExtension
{

    /**
     * [onAfterWrite description]
     */
    public function onAfterVersionedPublish($fromStage, $toStage, $createNewVersion): void
    {
        if ($toStage != Versioned::LIVE  || $this->getAutoPublishElementalDisable()) {
            return;
        }

        $fields = $this->getOwner()->getElementalRelations();
        foreach ($fields as $fieldName) {
            $this->autopublish($fieldName);
        }
    }

    /**
     * Given a field name, attempt to autopublish all child elements.
     * @param  string $fieldName
     */
    private function autopublish(string $fieldName): void
    {
        // If the method doesn't exist, just quit.
        if (!$this->getOwner()->HasMethod($fieldName)) {
            return;
        }

        $elementArea = $this->getOwner()->{$fieldName}();

        if ($elementArea) {
            $elements = $elementArea->Elements();
            foreach ($elements as $element) {
                $element->copyVersionToStage(Versioned::DRAFT, Versioned::LIVE);
            }
        }
    }

    /**
     * Get whatever auto publishing should be disable for this class based off the `auto_publish_elemental_disable`
     * config flag. Default to false.
     * @return bool
     */
    public function getAutoPublishElementalDisable(): bool
    {
        return
            $this->getOwner()->config()->get('auto_publish_elemental_disable') ?
            true : false;
    }

    public function countElement()
    {
        return ElementalArea::get()->count();
    }
}
