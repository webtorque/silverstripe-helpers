# Autopublish elemental blocks with parent page
If you want to autopublish elemental block associated to a page when that page gets published, you can attach the
`AutoPublishElementalExtension` to your `Page` object.

## Attaching the extension in PHP
```php
<?php

use DNADesign\Elemental\Extensions\ElementalPageExtension;
use WebTorque\SilverstripeHelpers\Blocks\AutoPublishElementalExtension;

class DummyPage extends Page
{

    // private static $table_name = 'DummyPage';

    private static $extensions = [
        ElementalPageExtension::class,
        AutoPublishElementalExtension::class,
    ];
}
```

## Attaching the extension in YML
```yml
DummyPage:
  extensions:
    - DNADesign\Elemental\Extensions\ElementalPageExtension
    - WebTorque\SilverstripeHelpers\Blocks\AutoPublishElementalExtension
```

## Disabling the autopublishing
If you want to disable auto publishing (e.g.: lets say you have a child class that should not autopublish), you can set
a the `auto_publish_elemental_disable` flag.

```yml
DummyPage:
  extensions:
    - DNADesign\Elemental\Extensions\ElementalPageExtension
    - WebTorque\SilverstripeHelpers\Blocks\AutoPublishElementalExtension

ChildDummyPage:
  auto_publish_elemental_disable: true
```
