<?php

namespace CloudSandwich\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as CFG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * Index of the public site
     *
     * @CFG\Route("/")
     * @CFG\Template()
     *
     * @return array for twig
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * lol @ fixture de merde
     *
     * @CFG\Route("/newuser")
     * @return void
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
        return $this->redirect($this->generateUrl('/'));
    }

    /**
     * Dashboard
     *
     * @CFG\Route("/auth/")
     * @CFG\Template()
     *
     * @return array for twig
     */
    public function authindexAction()
    {
        return [];
    }
}
