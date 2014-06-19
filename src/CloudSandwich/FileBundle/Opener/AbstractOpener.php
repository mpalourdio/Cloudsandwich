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

/**
 * Class AbstractOpener
 *
 * @package CloudSandwich\FileBundle\Opener
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */
abstract class AbstractOpener implements OpenerInterface
{

    /**
     * @var
     */
    protected $requestedFolder;
    /**
     * @var string
     */
    protected $fileName;
    /**
     * @var File
     */
    protected $file;
    /**
     * @var
     */
    protected $alias;

    /**
     * Returns list of mimetypes opened by the opener
     *
     * @return array
     */
    abstract function getMimeTypes();

    /**
     * Returns a template name to render files of this type
     *
     * @return mixed
     */
    abstract function getTemplate();

    /**
     * Initialize the opener for a file
     *
     * @param string $alias           the alias of the folder
     * @param string $requestedFolder the subfolder of the alias
     * @param string $fileName        the name of the file
     * @param File   $file            a file instance of the file
     *
     * @return void
     */
    public function initialize($alias, $requestedFolder, $fileName, File $file)
    {
        $this->file            = $file;
        $this->fileName        = $fileName;
        $this->requestedFolder = $requestedFolder;
        $this->alias           = $alias;
    }

    /**
     * Return a list of variable to pass th twig template
     *
     * @return array
     */
    abstract function getVarsForTemplate();

    /**
     * Returns the file to be served
     *
     * @return Response
     */
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

    /**
     * Returns a size readable for a human
     *
     * @return string
     */
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
