<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Opener;

use Symfony\Component\HttpFoundation\File\File;

/**
 * Default opener for files not openable
 * Class ImageOpener
 * @package CloudSandwich\FileBundle\Opener
 */
class DefaultOpener implements OpenerInterface
{
    public function getMimeTypes()
    {
        return array('default');
    }

    public function getTemplate()
    {
        return '@CloudSandwichFile/Default/file.html.twig';
    }

    public function getVarsForTemplate($requestedFolder,$fileName)
    {
        return array(
            'name'=>$fileName
        );
    }


}