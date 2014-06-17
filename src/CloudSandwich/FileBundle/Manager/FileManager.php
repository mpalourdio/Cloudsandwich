<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Manager;

use CloudSandwich\FileBundle\Opener\OpenerInterface;

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

        $root = realpath(dirname(__FILE__));
        $root = str_replace(__NAMESPACE__,'',$root);

        $this->rootPath = realpath($root.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'files');
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
        $folder = realpath($this->rootPath.DIRECTORY_SEPARATOR.$requestedFolder);
        $folders = explode(DIRECTORY_SEPARATOR,str_replace($this->rootPath,'',$folder));
        return $folders;
    }

    public function listDirectory($requestedFolder){
        $filesToDisplay=array();

        $folder = realpath($this->rootPath.DIRECTORY_SEPARATOR.$requestedFolder);

        if($folder==$this->rootPath)
            $folder.=DIRECTORY_SEPARATOR;
        $requestedFolder = str_replace($this->rootPath.DIRECTORY_SEPARATOR,'',$folder);

        if(strlen(realpath($this->rootPath))>strlen(realpath($folder)))
            throw new AccessDeniedException();

        if($this->rootPath!=realpath($folder))
            $filesToDisplay['folders'][] = array('name' => '..','link'=>$requestedFolder.DIRECTORY_SEPARATOR.'..');

        $finder = new Finder();
        $finder->depth('== 0');
        $finder->directories()->in($folder);
        foreach ($finder as $file) {
            $filesToDisplay['folders'][] = array('name' => $file->getFilename(),'link'=>$requestedFolder.DIRECTORY_SEPARATOR.$file->getRelativePathname());
        }

        $finder->files();
        foreach ($finder as $file) {
            $file = new File($this->rootPath.DIRECTORY_SEPARATOR.$requestedFolder.DIRECTORY_SEPARATOR.$file->getFilename());
            $mimetype= $file->getMimeType();
            /** @var OpenerInterface $opener */
            if(isset($this->openers[$mimetype]))
                $opener = $this->openers[$mimetype];
            else
                $opener = $this->openers['default'];

            $opener->initialize($requestedFolder,$file->getFilename(),$file);

            $filesToDisplay['files'][] =array('template'=>$opener->getTemplate(),'vars'=>$opener->getVarsForTemplate($requestedFolder,$file->getFilename()));
        }

        return $filesToDisplay;
    }

    public function getFile($folder,$file){

        $file = new File($this->rootPath.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$file);
        //$content =    readfile($file->getRealPath());

        $mimetype = $file->getMimeType();
        if(isset($this->openers[$mimetype]))
            $opener = $this->openers[$mimetype];
        else
            $opener = $this->openers['default'];
        $opener->initialize($folder,$file->getFilename(),$file);


        return $opener->getFile($file);
    }

}