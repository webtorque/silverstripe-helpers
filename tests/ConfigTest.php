<?php
namespace WebTorque\SilverstripeHelpers\Tests;

use SilverStripe\Control\Director;
use SilverStripe\Control\Middleware\CanonicalURLMiddleware;
use SilverStripe\Core\Environment;
use SilverStripe\Dev\SapphireTest;

class ConfigTest extends SapphireTest
{
    /**
     * Test if Force SSL is set correctly.
     *
     * We can not have a full test suite here, because there's not really any way to test based on the environement.
     */
    public function testSslForceRedirect()
    {
        $dontForceSSL = Environment::getEnv('WT_DONT_FORCE_SSL') ?: false;
        $isDev = Director::isDev();
        $shouldForceSSL = !($dontForceSSL || $isDev);
        $message = $shouldForceSSL
            ? 'SSL should have been force.'
            : 'SSL should not have been force.';

        $this->assertEquals(CanonicalURLMiddleware::singleton()->getForceSSL(), $shouldForceSSL, $message);
    }
}
