<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Opener;

class PdfOpener extends AbstractOpener implements OpenerInterface
{
    /**
     * @return array
     */
    public function getMimeTypes()
    {
        return [
            'application/pdf',
        ];
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return '@CloudSandwichFile/Pdf/pdf.html.twig';
    }

    /**
     * @return array
     */
    public function getVarsForTemplate()
    {
        return [
            'name'      => $this->fileName,
            'modalname' => str_replace('.', '', $this->fileName),
            'folder'    => $this->requestedFolder,
            'size'      => $this->getReadableSize(),
        ];
    }
}
