<?php

namespace CloudSandwich\FileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as CFG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @CFG\Route("/")
     * @CFG\Template()
     */
    public function indexAction()
    {
        return array();
    }
    /**
     * @CFG\Route("/list")
     * @CFG\Template()
     */
    public function filesAction(Request $request)
    {
        $html="";
        $fm =  $this->get("cloudsandwich.filemanager");
        $filelist = $fm->listDirectory($request->get('folder'));
        //Render list of folders
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
        return new Response($html);
    }

    /**
     * @CFG\Route("/breadcrumb")
     * @CFG\Template()
     */
    public function breadcrumbAction(Request $request)
    {
        $html="";
        $fm =  $this->get("cloudsandwich.filemanager");
        $breadcrumb = $fm->getBreadCrumb($request->get('folder'));
        $html.=$this->render('@CloudSandwichFile/Default/breadcrumb.html.twig',array('folders'=>$breadcrumb))->getContent();
        return new Response($html);
    }

    /**
     * @CFG\Route("/serve")
     * @CFG\Template()
     */
    public function serveAction(Request $request)
    {
        $folder = $request->get("folder");
        $file = $request->get('file');
        $fm =  $this->get("cloudsandwich.filemanager");
        return $fm->getFile($folder,$file);
    }

}
