<?php
namespace WebTorque\SilverstripeHelpers\Tests;

use SilverStripe\Control\Director;
use SilverStripe\Control\Middleware\CanonicalURLMiddleware;
use SilverStripe\Core\Environment as SSEnvironment;
use SilverStripe\Dev\SapphireTest;
use WebTorque\SilverstripeHelpers\Environment;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Core\Kernel;

class EnvironmentTest extends SapphireTest
{
    /**
     * Test if Force SSL is unset in Dev mode
     */
    public function testForceSSLInDev()
    {
        Injector::inst()->get(Kernel::class)->setEnvironment('dev');
        Environment::ForceSSL();

        $this->assertFalse(CanonicalURLMiddleware::singleton()->getForceSSL(), 'In dev mode, ForceSSL should not be enabled');
    }

    /**
     * Test if Force SSL is set in Test mode
     * @TODO Rewrite that test so it can work on the cli.
     */
    public function testForceSSLInTest()
    {
        Injector::inst()->get(Kernel::class)->setEnvironment('test');
        Environment::ForceSSL();

        //$this->assertTrue(CanonicalURLMiddleware::singleton()->getForceSSL(), 'In test mode, ForceSSL should be enabled');
    }

    /**
     * Test if Force SSL is set in Test mode
     * @TODO Rewrite that test so it can work on the cli.
     */
    public function testForceSSLInLive()
    {
        Injector::inst()->get(Kernel::class)->setEnvironment('live');
        Environment::ForceSSL();

        // $this->assertTrue(CanonicalURLMiddleware::singleton()->getForceSSL(), 'In live mode, ForceSSL should be enabled');
    }

    /**
     * Test if Force SSL is unset when `WT_DONT_FORCE_SSL` is truty
     */
    public function testForceSSLwithNoForceSSLFlag()
    {
        Injector::inst()->get(Kernel::class)->setEnvironment('live');
        SSEnvironment::setEnv('WT_DONT_FORCE_SSL', true);
        Environment::ForceSSL();

        $this->assertFalse(CanonicalURLMiddleware::singleton()->getForceSSL(), 'When WT_DONT_FORCE_SSL is set, ForceSSL should not be enabled');
    }
}
