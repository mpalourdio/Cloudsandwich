<?php

namespace CloudSandwich\ContactBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as CFG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @CFG\Route("/hello/{name}")
     * @CFG\Template()
     */
    public function indexAction($name)
    {
        return ['name' => $name];
    }
}
