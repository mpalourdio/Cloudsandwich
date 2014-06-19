<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Opener;

/**
 * Class TextOpener
 *
 * @package CloudSandwich\FileBundle\Opener
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */
class TextOpener extends AbstractOpener implements OpenerInterface
{
    /**
     * {@@inheritdoc}
     */
    public function getMimeTypes()
    {
        return [
            'text/plain',
        ];
    }

    /**
     * {@@inheritdoc}
     */
    public function getTemplate()
    {
        return '@CloudSandwichFile/Text/text.html.twig';
    }

    /**
     * {@@inheritdoc}
     */
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
