<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MenuBuilder
 *
 * @package CloudSandwich\CoreBundle\Menu
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */
class MenuBuilder
{
    /**
     * @var \Knp\Menu\FactoryInterface
     */
    protected $factory;

    /**
     * @var array
     */
    protected $items = [];

    /**
     * contrsuctor
     *
     * @param FactoryInterface $factory knpmenubundle requirement
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * createMainMenu
     *
     * @param Request $request
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem(
            'root',
            [
                'childrenAttributes' => [
                    'class' => 'nav nav-sidebar'
                ]
            ]
        );

        foreach ($this->items as $id => $item) {
            $menu->addChild($id, $item);
        }

        return $menu;
    }

    /**
     * For each child bundle, we add its menu
     *
     * @param MenuFillerInterface $id the service id given by the compiler pass
     */
    public function addFiller(MenuFillerInterface $id)
    {
        $values = $id->getValues();
        foreach ($values as $id => $value) {
            $this->items[$id] = $value;
        }
    }
}
