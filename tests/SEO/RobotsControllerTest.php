<?php
namespace WebTorque\SilverstripeHelpers\Tests\SEO;

use SilverStripe\Dev\SapphireTest;
use WebTorque\SilverstripeHelpers\SEO\RobotsController;
use SilverStripe\Control\Director;

class RobotsControllerTest extends SapphireTest
{
    /**
     * Make sure AutoPublishElementalFields default to `ElementalArea`.
     */
    public function testIndexLive()
    {
        Director::test("robots.txt");
    }
}
