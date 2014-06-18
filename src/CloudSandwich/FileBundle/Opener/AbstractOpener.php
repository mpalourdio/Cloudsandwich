<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Opener;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractOpener implements OpenerInterface
{

    protected $requestedFolder;
    protected $fileName;
    protected $file;

    abstract function getMimeTypes();

    abstract function getTemplate();

    public function initialize($requestedFolder, $fileName, File $file)
    {
        $this->file            = $file;
        $this->fileName        = $fileName;
        $this->requestedFolder = $requestedFolder;
    }

    abstract function getVarsForTemplate();

    public function getFile()
    {
        $fp = fopen($this->file->getRealPath(), "rb");

        $str = stream_get_contents($fp);
        fclose($fp);

        $response = new Response($str, 200);
        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('Content-Transfer-Encoding', 'Binary');
        $response->headers->set('Content-disposition', "attachment; filename=\"" . $this->file->getFilename() . "\"");

        return $response;
    }

    protected function getReadableSize()
    {
        $size = $this->file->getSize();
        $size = ($size / 8 / 1024);
        $unit = 'ko';
        if ($size > 1024) {
            $size = $size / 1024;
            $unit = 'Mo';
        }

        return number_format($size, 2) . $unit;
    }
}
