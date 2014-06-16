<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Opener;

use Symfony\Component\HttpFoundation\File\File;

abstract class AbstractOpener implements OpenerInterface
{

    protected $requestedFolder;
    protected $fileName;
    protected $file;

    abstract function getMimeTypes();

    abstract function getTemplate();

    public function initialize($requestedFolder,$fileName,File $file){
        $this->file=$file;
        $this->fileName = $fileName;
        $this->requestedFolder = $requestedFolder;
    }

    abstract function getVarsForTemplate();
}