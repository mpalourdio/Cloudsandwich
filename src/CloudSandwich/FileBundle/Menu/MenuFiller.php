<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Menu;


use CloudSandwich\CoreBundle\Menu\MenuBuilder;
use CloudSandwich\CoreBundle\Menu\MenuFillerInterface;

class MenuFiller implements MenuFillerInterface
{
    private $builder;

    public function __construct(MenuBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function getValues(){
        $this->builder->addItem('test','menu de test','cloudsandwich_core_default_index');
    }

}