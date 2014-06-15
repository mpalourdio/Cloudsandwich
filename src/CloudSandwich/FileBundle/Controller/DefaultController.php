<?php

namespace CloudSandwich\FileBundle\Controller;

use CloudSandwich\CoreBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as CFG;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{
    /**
     * @CFG\Route("/hello")
     * @CFG\Template()
     */
    public function indexAction()
    {
        return array();
    }
    /**
     * @CFG\Route("/files")
     * @CFG\Template()
     */
    public function filesAction(Request $request)
    {
        $html="";
        $fm =  $this->get("cloudsandwich.filemanager");
        $breadcrumb = $fm->getBreadCrumb($request->get('folder'));
        $filelist = $fm->listDirectory($request->get('folder'));
        $html.=$this->render('@CloudSandwichFile/Default/breadcrumb.html.twig',array('folders'=>$breadcrumb))->getContent();
        //Render list of folders
        $html.='<ul>';
        if(isset($filelist['folders'])){
            foreach($filelist['folders'] as $folder){
                $html.=$this->render('@CloudSandwichFile/Default/folder.html.twig',array('name'=>$folder['name'],'link'=>$folder['link']))->getContent();
            }
        }

        if(isset($filelist['files'])){
            //Render list of files
            foreach($filelist['files'] as $file){
                $html.=$this->render($file['template'],$file['vars'])->getContent();
            }
        }
        $html.='</ul>';
        return new Response($html);
    }
}
