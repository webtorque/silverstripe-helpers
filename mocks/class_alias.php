<?php

/**
 * A lot of Silverstripe packages expect a `Page` class and `PageController` class to exist in the root Namespace. To
 * shut them up during unit testing we just create a dummy alias for those classes and auto load them with composer when
 * we run our tests.
 */

class_alias('SilverStripe\\CMS\\Model\\SiteTree', 'Page');
class_alias('SilverStripe\\CMS\\Controllers\\ContentController', 'PageController');



// WebTorque\SilverstripeHelpers\Tests\Mocks\TestPage
//     ::add_extension('WebTorque\\SilverstripeHelpers\\Tests\\Blocks\\AutoPublishElementalExtension');
