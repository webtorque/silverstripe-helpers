<?php

use SilverStripe\Core\Environment;
use SilverStripe\Control\Director;

// By default, we want all our Webtorque SS4 sites to be served over SSL unless they are in dev mode.
// In exceptional circumstances, we will allow this behavior to be overriden with the WT_DONT_FORCE_SSL flag.
$dontForceSSL = Environment::getEnv('WT_DONT_FORCE_SSL') ?: false;

if (!$dontForceSSL && !Director::isDev()) {
    Director::forceSSL();
}
