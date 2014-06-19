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

/**
 * Class MenuFiller
 *
 * @package CloudSandwich\FileBundle\Menu
 */
class MenuFiller implements MenuFillerInterface
{
    /**
     * @var \Symfony\Component\Translation\Translator
     */
    protected $translator;
    /**
     * @var string
     */
    protected $folders;

    /**
     * constructor
     *
     * @param Translator $translator translatro service
     * @param string     $folders    the list of alias folders from the configuration
     */
    public function __construct(Translator $translator, $folders)
    {
        $this->translator = $translator;
        $this->folders = $folders;
    }

    /**
     * Returns menu values for the menu
     *
     * @return array
     */
    public function getValues()
    {
        $menu = [
            'files' => [
                'label' => $this->translator->trans('file.menu.header'),
                'attributes' => ['class' => 'nav-header']
            ]
        ];

        foreach ($this->folders as $alias => $path) {
            $menu['files.index' . $alias] = [
                'label' => $alias,
                'route' => 'cloudsandwich_file_default_index',
                'routeParameters' => ['alias' => $alias],
                'attributes' => ['icon' => 'fa-folder']
            ];
        }
        return $menu;
    }
}
