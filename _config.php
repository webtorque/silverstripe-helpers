<?php

use SilverStripe\Core\Environment as SSEnvironment;
use WebTorque\SilverstripeHelpers\Environment;

// Don't run this code snippet during the unit test otherwise it goes boom.
if (SSEnvironment::getEnv('PHPUNIT_TESTSUITE')) {
    return;
}

Environment::ForceSSL();
