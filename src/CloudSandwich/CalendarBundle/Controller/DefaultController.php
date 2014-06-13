<?php

namespace CloudSandwich\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as CFG;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @CFG\Route("/hello/{name}")
     * @CFG\Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
}
