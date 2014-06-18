<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\CoreBundle\Menu;

interface MenuFillerInterface
{
    /**
     * @return array() of values
     */
    public function getValues();
}
