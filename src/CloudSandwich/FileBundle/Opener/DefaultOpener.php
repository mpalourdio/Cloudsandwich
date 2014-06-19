<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Opener;

/**
 * Default opener for files not openable
 * Class ImageOpener
 *
 * @package CloudSandwich\FileBundle\Opener
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */
class DefaultOpener extends AbstractOpener implements OpenerInterface
{

    /**
     * {@@inheritdoc}
     */
    public function getMimeTypes()
    {
        return ['default'];
    }

    /**
     * {@@inheritdoc}
     */
    public function getTemplate()
    {
        return '@CloudSandwichFile/Default/file.html.twig';
    }

    /**
     * {@@inheritdoc}
     */
    public function getVarsForTemplate()
    {
        return [
            'name'   => $this->fileName,
            'mime'   => $this->file->getMimeType(),
            'folder' => $this->requestedFolder,
            'size'   => $this->getReadableSize()
        ];
    }
}
