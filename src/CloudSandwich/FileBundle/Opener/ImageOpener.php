<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Opener;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class ImageOpener
 *
 * @package CloudSandwich\FileBundle\Opener
 *           * @author  Sergio Mendolia <sergio@mendolia.ch>
 */
class ImageOpener extends AbstractOpener implements OpenerInterface
{
    /**
     * {@@inheritdoc}
     */
    public function getMimeTypes()
    {
        return [
            'image/jpeg',
            'image/png',
        ];
    }

    /**
     * {@@inheritdoc}
     */
    public function getTemplate()
    {
        return '@CloudSandwichFile/Image/image.html.twig';
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
            'alias' => $this->alias,
        ];
    }

    /**
     * {@@inheritdoc}
     */
    public function getFile()
    {
        $fp = fopen($this->file->getRealPath(), "rb");

        $str = stream_get_contents($fp);
        fclose($fp);

        $response = new Response($str, 200);
        $response->headers->set('Content-Type', $this->file->getMimetype());

        return $response;
    }
}
