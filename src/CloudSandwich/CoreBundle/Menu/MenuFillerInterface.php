<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\CoreBundle\Menu;

/**
 * Interface MenuFillerInterface
 *
 * @package CloudSandwich\CoreBundle\Menu
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */
interface MenuFillerInterface
{
    /**
     * Return menu elements
     *
     * @return array() of values
     */
    public function getValues();
}
