<?php

namespace WebTorque\SilverstripeHelpers\Tests\Blocks;

use SilverStripe\ORM\DataExtension;


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
     * [getAutoPublishElementalDisable description]
     * @return bool [description]
     */
    public function getAutoPublishElementalDisable(): bool
    {
        return
            $this->getOwner()->config()->get('auto_publish_elemental_disable') ?
            true : false;
    }


}
