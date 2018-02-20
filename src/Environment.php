<?php
namespace WebTorque\SilverstripeHelpers;

use SilverStripe\Core\Environment as SSEnvironment;
use SilverStripe\Control\Director;

/**
 * Utility class to help manage environement tweaks.
 */
class Environment
{

    /**
     * Force SSL when not in DEV.
     */
    public static function ForceSSL(): void
    {
        $dontForceSSL = SSEnvironment::getEnv('WT_DONT_FORCE_SSL') ?: false;

        if (!$dontForceSSL && !Director::isDev()) {
            Director::forceSSL();
        }
    }
}
