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

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function getValues()
    {
        return [
            'files'       => [
                'label'      => $this->translator->trans('file.menu.header'),
                'attributes' => ['class' => 'nav-header']
            ],
            'files.index' => [
                'label'      => $this->translator->trans('file.menu.index'),
                'route'      => 'cloudsandwich_file_default_index',
                'attributes' => ['icon' => 'fa-folder']
            ],
        ];
    }
}
