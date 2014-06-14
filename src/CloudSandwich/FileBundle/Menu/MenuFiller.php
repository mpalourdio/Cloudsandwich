<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Menu;

use CloudSandwich\CoreBundle\Menu\MenuFillerInterface;

class MenuFiller implements MenuFillerInterface
{
    public function __construct()
    {

    }

    public function getValues(){
        return array(
            'files'=>array('label'=>'menu de test','attributes'=>array('class'=>'nav-header')),
            'test'=>array('label'=>'menu de test','route'=>'cloudsandwich_core_default_index'),
            'second'=>array('label'=>'Deuxième','route'=>'cloudsandwich_core_default_authindex'),
            'third'=>array('label'=>'Troisieme','route'=>'cloudsandwich_file_default_index'),
        );
    }

}