<?php

namespace CloudSandwich\FileBundle\Controller;

use CloudSandwich\FileBundle\Manager\FileManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as CFG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @CFG\Route(service="cloudsandwich.controller.default")
 */
class DefaultController extends Controller
{
    protected $fileManager;
    /**
     * @param FileManager $fileManager
     */
    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }
    /**
     * @CFG\Route("/{alias}/")
     * @CFG\Template()
     */
    public function indexAction($alias)
    {
        return ['alias'=>$alias];
    }

    /**
     * @CFG\Route("/{alias}/list")
     */
    public function filesAction(Request $request,$alias)
    {
        $html     = "";
        $filelist = $this->fileManager->listDirectory($alias,$request->get('folder'));
        //Render list of folders
        if (isset($filelist['folders'])) {
            foreach ($filelist['folders'] as $folder) {
                $html .= $this->render(
                    '@CloudSandwichFile/Default/folder.html.twig',
                    ['name' => $folder['name'], 'link' => $folder['link']]
                )
                    ->getContent();
            }
        }

        if (isset($filelist['files'])) {
            //Render list of files
            foreach ($filelist['files'] as $file) {
                $html .= $this->render($file['template'], $file['vars'])->getContent();
            }
        }

        return new Response($html);
    }

    /**
     * @CFG\Route("/{alias}/breadcrumb")
     * @CFG\Template()
     */
    public function breadcrumbAction(Request $request,$alias)
    {
        $html       = "";
        $breadcrumb = $this->fileManager->getBreadCrumb($alias,$request->get('folder'));
        $html .= $this->render(
            '@CloudSandwichFile/Default/breadcrumb.html.twig',
            ['folders' => $breadcrumb]
        )->getContent();

        return new Response($html);
    }

    /**
     * @CFG\Route("/{alias}/serve")
     */
    public function serveAction(Request $request,$alias)
    {
        $folder = $request->get("folder");
        $file   = $request->get('file');

        return $this->fileManager->getFile($alias,$folder, $file);
    }
}
