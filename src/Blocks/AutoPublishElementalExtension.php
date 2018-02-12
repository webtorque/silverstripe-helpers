<?php

namespace WebTorque\SilverstripeHelpers\Blocks;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Versioned\Versioned;
use DNADesign\Elemental\Models\ElementalArea;
use WebTorque\SilverstripeHelpers\Tests\Mocks\DummyPage;

/**
 * Extends a SiteTree to auto publish all its elemental blocks when the it's published.
 *
 * You can define the following flags on your class to control this behavior:
 * * `auto_publish_elemental_fields`: array of string reprensenting the expected names of the Elemental field. Defaults
 * to `ElementalArea` if not set.
 * * `auto_publish_elemental_disable`: Allows you to disable the auto publishing feature in child classes. Default to
 * `false`.
 *
 */
class AutoPublishElementalExtension extends DataExtension
{

    /**
     * [onAfterWrite description]
     */
    public function onAfterWrite(): void
    {
        // If current page is a draft or if auto-publishing is disable, quit right away.
        $liveID = Versioned::get_versionnumber_by_stage($this->getOwner(), Versioned::LIVE, $this->getOwner()->ID);
        if ($this->getOwner()->Version != $liveID  || $this->getAutoPublishElementalDisable()) {
            return;
        }

        $fields = $this->getAutoPublishElementalFields();
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
        $elementArea = $this->getOwner()->ElementalArea();

        var_dump(ElementalArea::singleton()->baseTable());
        die();
        foreach (ElementalArea::get() as $area) {
            var_dump($area->ID);
        }


        if ($elementArea) {
            $elements = $elementArea->Elements();
            foreach ($elements as $element) {
                echo "publishing element";
                $element->copyVersionToStage(Versioned::DRAFT, Versioned::LIVE);
            }
        }
    }

    /**
     * Get the list of Elemental fields that should be auto published. This can be defined on the parent class with the
     * `auto_publish_elemental_fields` config flag as a string or array of string. If left unset, the value defaults to
     * `ElementalArea`.
     * @return string[]
     */
    public function getAutoPublishElementalFields(): array
    {
        $fields = $this->getOwner()->config()->get('auto_publish_elemental_fields');
        if (!$fields) {
            return ['ElementalArea'];
        } elseif (is_array($fields)) {
            return $fields;
        } else {
            return [$fields];
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
}
