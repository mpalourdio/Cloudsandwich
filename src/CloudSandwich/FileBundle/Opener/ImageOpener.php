<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Opener;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

class ImageOpener implements OpenerInterface
{
    public function getMimeTypes()
    {
        return array(
            'image/jpeg',
        );
    }

    public function getTemplate()
    {
        return '@CloudSandwichFile/Image/image.html.twig';
    }

    public function getVarsForTemplate($requestedFolder,$fileName)
    {
        Request::createFromGlobals();

        return array(
            'name'=>$fileName,
            'link'=>'files/1/'.$fileName
        );
    }


}