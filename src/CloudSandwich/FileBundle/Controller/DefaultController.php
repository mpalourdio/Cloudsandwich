<?php

namespace CloudSandwich\FileBundle\Controller;

use CloudSandwich\FileBundle\Manager\FileManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as CFG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Default controller for file display and manegement
 *
 * @author Sergio Mendolia <sergio@mendolia.ch>
 *
 * @CFG\Route(service="cloudsandwich.controller.default")
 */
class DefaultController extends Controller
{
    /**
     * @var \CloudSandwich\FileBundle\Manager\FileManager
     */
    protected $fileManager;
    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    protected $templating;

    /**
     * Constructor
     *
     * @param FileManager $fileManager the filemanager service
     * @param TwigEngine  $templating  twig templating engine
     */
    public function __construct(FileManager $fileManager, TwigEngine $templating)
    {
        $this->fileManager = $fileManager;
        $this->templating  = $templating;
    }

    /**
     * The page listing files
     *
     * @param string $alias the alias for a folder in the configuration
     *
     * @CFG\Route("/{alias}/")
     * @CFG\Template()
     *
     * @return array array sent to twig
     */
    public function indexAction($alias)
    {
        return ['alias' => $alias];
    }

    /**
     * return a table of files for a request directory
     *
     * @param Request $request Standard http request
     * @param string  $alias   the alias for a folder in the configuration
     *
     * @CFG\Route("/{alias}/list")
     *
     * @return Response generated html
     */
    public function filesAction(Request $request, $alias)
    {
        $html     = "";
        $filelist = $this->fileManager->listDirectory(
            $alias,
            $request->get('folder')
        );
        //Render list of folders
        if (isset($filelist['folders'])) {
            foreach ($filelist['folders'] as $folder) {
                $html .= $this->templating->renderResponse(
                    '@CloudSandwichFile/Default/folder.html.twig',
                    ['name' => $folder['name'], 'link' => $folder['link']]
                )
                    ->getContent();
            }
        }

        if (isset($filelist['files'])) {
            //Render list of files
            foreach ($filelist['files'] as $file) {
                $html .= $this->templating->renderResponse(
                    $file['template'],
                    $file['vars']
                )
                    ->getContent();
            }
        }

        return new Response($html);
    }

    /**
     * Gives backa breadcrumb for a folder
     *
     * @param Request $request Standard http request
     * @param string  $alias   the alias for a folder in the configuration
     *
     * @CFG\Route("/{alias}/breadcrumb")
     * @CFG\Template()
     * @return Response a generated HTML breadcrumb
     */
    public function breadcrumbAction(Request $request, $alias)
    {
        $html       = "";
        $breadcrumb = $this->fileManager->getBreadCrumb(
            $alias,
            $request->get('folder')
        );
        $html .= $this->templating
            ->renderResponse(
                '@CloudSandwichFile/Default/breadcrumb.html.twig',
                ['folders' => $breadcrumb]
            )
            ->getContent();

        return new Response($html);
    }

    /**
     * Serves an image to the browser
     *
     * @param Request $request Standard http request
     * @param string  $alias   the alias for a folder in the configuration
     *
     * @CFG\Route("/{alias}/serve")
     *
     * @return Response the response generated by the file manager
     */
    public function serveAction(Request $request, $alias)
    {
        $folder = $request->get('folder');
        $file   = $request->get('file');

        return $this->fileManager->getFile($alias, $folder, $file);
    }
}
