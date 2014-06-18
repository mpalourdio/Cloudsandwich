<?php

namespace CloudSandwich\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as CFG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @CFG\Route("/")
     * @CFG\Template()
     */
    public function indexAction()
    {

        return [];
    }

    /**
     * @CFG\Route("/newuser")
     * @CFG\Template()
     */
    public function newuserAction()
    {
        /*
        $em      = $this->getDoctrine()->getManager();
        $factory = $this->get('security.encoder_factory');

        $m = new User();
        $m->setEmail('sergio@mendolia.ch');
        $encoder  = $factory->getEncoder($m);
        $rand     = 'admin';
        $password = $encoder->encodePassword($rand, $m->getSalt());
        $m->setPassword($password);
        $m->setEnabled(true);
        $m->setUsername('admin');
        $em->persist($m);
        $em->flush();
        */
        return $this->redirect($this->generateUrl('cloudsandwich_core_default_index'));
    }

    /**
     * @CFG\Route("/auth/")
     * @CFG\Template()
     */
    public function authindexAction()
    {


        return [];
    }
}
