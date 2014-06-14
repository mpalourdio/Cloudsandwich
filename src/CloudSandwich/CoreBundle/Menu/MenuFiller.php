<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\CoreBundle\Menu;

use Symfony\Component\Translation\Translator;

class MenuFiller implements MenuFillerInterface
{
    private $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function getValues(){
        return array(
            'core.index'=>array('label'=>$this->translator->trans('core.menu.index'),'route'=>'cloudsandwich_core_default_authindex','attributes'=>array('icon'=>'fa-home')),
        );
    }

}