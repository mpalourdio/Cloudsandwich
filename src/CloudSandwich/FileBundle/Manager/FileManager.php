<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Manager;

use CloudSandwich\CoreBundle\Entity\User;
use CloudSandwich\FileBundle\Opener\OpenerInterface;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Translation\Translator;

class FileManager
{

    private $context;
    private $translator;
    private $rootPath;
    private $openers = array();
    /**
     * @param Translator $translator
     * @param SecurityContext $context
     */
    public function __construct(Translator $translator,SecurityContext $context)
    {
        $this->translator=$translator;
        $this->context=$context;

        $usr = $this->context->getToken()->getUser();
        $request = Request::createFromGlobals();

        $this->rootPath = realpath($request->server->get('DOCUMENT_ROOT').$request->getBasePath().'/../files/'.$usr->getId());
    }

    /**
     * For each fileopener we register it
     * @param OpenerInterface $id
     */
    public function addOpener(OpenerInterface $id){
        $types = $id->getMimeTypes();
        foreach($types as $type){
            $this->openers[$type] = $id;
        }
    }

    public function getBreadCrumb($requestedFolder){
        $folders = explode('/',str_replace($this->rootPath,'',$requestedFolder));
        return $folders;
    }

    public function listDirectory($requestedFolder){
        $filesToDisplay=array();

        $folder = realpath($this->rootPath.'/'.$requestedFolder);

        if(strlen(realpath($this->rootPath))>strlen(realpath($folder)))
            throw new AccessDeniedException();

        if($this->rootPath!=$folder)
            $filesToDisplay['folders'][] = array('name' => '..','link'=>'/'.$requestedFolder.'/..');

        $finder = new Finder();
        $finder->depth('== 0');
        $finder->directories()->in($folder);
        foreach ($finder as $file) {
            $filesToDisplay['folders'][] = array('name' => $file->getFilename(),'link'=>'/'.$requestedFolder.'/'.$file->getRelativePathname());
        }

        $finder->files();
        foreach ($finder as $file) {
            $file = new File($this->rootPath.'/'.$requestedFolder.'/'.$file->getFilename());
            $mimetype= $file->getMimeType();
            /** @var OpenerInterface $opener */
            if(isset($this->openers[$mimetype]))
                $opener = $this->openers[$mimetype];
            else
                $opener = $this->openers['default'];

            $filesToDisplay['files'][] =array('template'=>$opener->getTemplate(),'vars'=>$opener->getVarsForTemplate($requestedFolder,$file->getFilename()));
        }

        return $filesToDisplay;
    }
}