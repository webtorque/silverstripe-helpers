<?php

namespace WebTorque\SilverstripeHelpers\SEO;

use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;

/**
 * Extends a SiteTree to auto publish all its elemental blocks when the it's published.
 *
 * You can define the following flag on your class to control this behavior:
 * * `auto_publish_elemental_disable`: Allows you to disable the auto publishing feature in child classes. Default to
 * `false`.
 *
 */
class RobotsController extends Controller
{
    /**
     * Return a robots file based on the environement.
     * @param  HTTPRequest  $request
     * @return HTTPResponse
     */
    public function index(HTTPRequest $request): HTTPResponse
    {
        $this->setResponse(new HTTPResponse());
        $this->getResponse()->setStatusCode(200);
        $this->getResponse()->setBody('invalid');

        var_dump($this->config()->defaults);
        die();

        return $this->getResponse();
    }
}
