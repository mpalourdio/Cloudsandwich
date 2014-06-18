<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Manager;

use CloudSandwich\FileBundle\Opener\OpenerInterface;

use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Translation\Translator;

class FileManager
{

    private $context;
    private $translator;
    private $rootPath;
    private $openers = [];
    private $aliases = [];

    /**
     * @param Translator      $translator
     * @param SecurityContext $context
     */
    public function __construct(Translator $translator, SecurityContext $context,$folders)
    {
        $this->translator = $translator;
        $this->context    = $context;
        $this->aliases = $folders;
    }

    /**
     * For each fileopener we register it
     *
     * @param OpenerInterface $id
     */
    public function addOpener(OpenerInterface $id)
    {
        $types = $id->getMimeTypes();
        foreach ($types as $type) {
            $this->openers[$type] = $id;
        }
    }

    public function getBreadCrumb($alias,$requestedFolder)
    {
        $folder  = realpath($this->aliases[$alias] . DIRECTORY_SEPARATOR . $requestedFolder);
        $folders = explode(DIRECTORY_SEPARATOR, str_replace($this->aliases[$alias], '', $folder));

        return $folders;
    }

    public function listDirectory($alias,$requestedFolder)
    {
        $filesToDisplay = [];

        $folder = realpath($this->aliases[$alias] . DIRECTORY_SEPARATOR . $requestedFolder);

        if ($folder == $this->aliases[$alias]) {
            $folder .= DIRECTORY_SEPARATOR;
        }
        $requestedFolder = str_replace($this->aliases[$alias] . DIRECTORY_SEPARATOR, '', $folder);

        if (strlen(realpath($this->aliases[$alias])) > strlen(realpath($folder))) {
            throw new AccessDeniedException();
        }

        if ($this->aliases[$alias] != realpath($folder))
            $filesToDisplay['folders'][] = ['name' => '..', 'link' => $requestedFolder . DIRECTORY_SEPARATOR . '..'];

        $finder = new Finder();
        $finder->depth('== 0');
        $finder->directories()->in($folder);
        foreach ($finder as $file) {
            $filesToDisplay['folders'][] = ['name' => $file->getFilename(), 'link' => $requestedFolder . DIRECTORY_SEPARATOR . $file->getRelativePathname()];
        }

        $finder->files();
        foreach ($finder as $file) {
            $file     = new File($this->aliases[$alias] . DIRECTORY_SEPARATOR . $requestedFolder . DIRECTORY_SEPARATOR . $file->getFilename());
            $mimetype = $file->getMimeType();
            /** @var OpenerInterface $opener */
            if (isset($this->openers[$mimetype]))
                $opener = $this->openers[$mimetype];
            else
                $opener = $this->openers['default'];

            $opener->initialize($alias,$requestedFolder, $file->getFilename(), $file);

            $filesToDisplay['files'][] = ['template' => $opener->getTemplate(), 'vars' => $opener->getVarsForTemplate($requestedFolder, $file->getFilename())];
        }

        return $filesToDisplay;
    }

    public function getFile($alias,$folder, $file)
    {

        $file = new File($this->aliases[$alias] . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $file);
        //$content =    readfile($file->getRealPath());

        $mimetype = $file->getMimeType();
        if (isset($this->openers[$mimetype]))
            $opener = $this->openers[$mimetype];
        else
            $opener = $this->openers['default'];
        $opener->initialize($alias,$folder, $file->getFilename(), $file);

        return $opener->getFile($file);
    }
}
