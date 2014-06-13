<?php

namespace CloudSandwich\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as CFG;

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
