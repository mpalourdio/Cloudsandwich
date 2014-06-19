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
 * Interface OpenerInterface
 *
 * @package CloudSandwich\FileBundle\Opener
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */
interface OpenerInterface
{

    /**
     * getMimeTypes
     *
     * @return mixed
     *
     */
    public function getMimeTypes();

    /**
     * getTemplate
     *
     * @return mixed
     *
     */
    public function getTemplate();

    /**
     * initialize
     *
     * @param string $alias           alias
     * @param string $requestedFolder reuqestedfolder
     * @param string $fileName        name of the file
     * @param File   $file            instasnce of the file
     *
     * @return mixed
     *
     */
    public function initialize($alias, $requestedFolder, $fileName, File $file);

    /**
     * getVarsForTemplate
     *
     * @return mixed
     *
     */
    public function getVarsForTemplate();

    /**
     * getFile
     *
     * @return mixed
     *
     */
    public function getFile();
}
