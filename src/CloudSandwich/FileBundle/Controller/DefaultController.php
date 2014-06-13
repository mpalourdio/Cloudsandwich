<?php

namespace CloudSandwich\FileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as CFG;

class DefaultController extends Controller
{
    /**
     * @CFG\Route("/hello")
     * @CFG\Template()
     */
    public function indexAction()
    {
        return array('name' => 'hj');
    }
}
