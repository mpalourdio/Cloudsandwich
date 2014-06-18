<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Menu;

use CloudSandwich\CoreBundle\Menu\MenuFillerInterface;
use Symfony\Component\Translation\Translator;

class MenuFiller implements MenuFillerInterface
{
    private $translator;
    private $folders;

    public function __construct(Translator $translator,$folders)
    {
        $this->translator = $translator;
        $this->folders = $folders;
    }

    public function getValues()
    {
        $menu = [
            'files'       => [
                'label'      => $this->translator->trans('file.menu.header'),
                'attributes' => ['class' => 'nav-header']
            ]];

        foreach($this->folders as $alias=>$path){
            $menu['files.index'.$alias] = [
                'label'      => $alias,
                'route'      => 'cloudsandwich_file_default_index',
                'routeParameters'=>['alias'=>$alias],
                'attributes' => ['icon' => 'fa-folder']
            ];
        }
        return $menu;
    }
}
