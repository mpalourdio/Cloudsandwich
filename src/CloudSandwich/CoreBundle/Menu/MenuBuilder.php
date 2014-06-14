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
        $menu = $this->factory->createItem('root',array('childrenAttributes'=>array('class'=>'nav nav-sidebar')));

        foreach($this->items as $id=>$item){
            $menu->addChild($id, $item);
        }
        return $menu;
    }

    /**
     * For each child bundle, we add its menu
     * @param MenuFillerInterface $id
     */
    public function addFiller(MenuFillerInterface $id){
        $values = $id->getValues();
        foreach($values as $id=>$value){
            $this->items[$id]= $value;
        }
    }



}