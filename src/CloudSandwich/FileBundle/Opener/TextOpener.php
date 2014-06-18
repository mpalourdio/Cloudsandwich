<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Opener;

class TextOpener extends AbstractOpener implements OpenerInterface
{
    public function getMimeTypes()
    {
        return [
            'text/plain',
        ];
    }

    public function getTemplate()
    {
        return '@CloudSandwichFile/Text/text.html.twig';
    }

    public function getVarsForTemplate()
    {

        return [
            'name'      => $this->fileName,
            'modalname' => str_replace('.', '', $this->fileName),
            'size'      => $this->getReadableSize(),
            'folder'    => $this->requestedFolder
        ];
    }
}
