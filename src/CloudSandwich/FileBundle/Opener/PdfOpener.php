<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Opener;

/**
 * Class PdfOpener
 *
 * @package CloudSandwich\FileBundle\Opener
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */
class PdfOpener extends AbstractOpener implements OpenerInterface
{
    /**
     * {@@inheritdoc}
     */
    public function getMimeTypes()
    {
        return [
            'application/pdf',
        ];
    }

    /**
     * {@@inheritdoc}
     */
    public function getTemplate()
    {
        return '@CloudSandwichFile/Pdf/pdf.html.twig';
    }

    /**
     * {@@inheritdoc}
     */
    public function getVarsForTemplate()
    {
        return [
            'name' => $this->fileName,
            'modalname' => str_replace('.', '', $this->fileName),
            'folder' => $this->requestedFolder,
            'size' => $this->getReadableSize(),
        ];
    }
}
