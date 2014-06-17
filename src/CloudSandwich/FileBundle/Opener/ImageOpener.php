<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Opener;

use Symfony\Component\Finder\SplFileInfo;

class ImageOpener extends AbstractOpener implements OpenerInterface
{
    public function getMimeTypes()
    {
        return array(
            'image/jpeg','image/png',
        );
    }

    public function getTemplate()
    {
        return '@CloudSandwichFile/Image/image.html.twig';
    }

    public function getVarsForTemplate()
    {
        return array(
            'name'=>$this->fileName,
            'modalname'=>str_replace('.','',$this->fileName),
            'folder'=>$this->requestedFolder,
            'size'=>$this->getReadableSize()
        );
    }


}