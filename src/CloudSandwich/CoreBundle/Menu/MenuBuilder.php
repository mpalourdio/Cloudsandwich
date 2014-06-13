<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;

class MenuBuilder
{
    private $factory;

    private $items = array();

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');

        $menu->setAttribute('class','nav nav-sidebar');
        foreach($this->items as $id=>$item){
            $menu->addChild($id, $item);
        }
        return $menu;
    }

    public function addItem($id,$label,$route){
        $this->items[$id] = array('route'=> $route,'label'=>$label);
    }

    public function addFiller(MenuFillerInterface $id){
        $id->getValues();
    }



}