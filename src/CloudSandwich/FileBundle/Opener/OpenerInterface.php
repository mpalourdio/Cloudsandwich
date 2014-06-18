<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Opener;

use Symfony\Component\HttpFoundation\File\File;

interface OpenerInterface
{
    public function getMimeTypes();

    public function getTemplate();

    public function initialize($alias, $requestedFolder, $fileName, File $file);

    public function getVarsForTemplate();

    public function getFile();
}
