<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\CoreBundle\Menu;

use Symfony\Component\Translation\Translator;

/**
 * Class MenuFiller
 *
 * @package CloudSandwich\CoreBundle\Menu
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */
class MenuFiller implements MenuFillerInterface
{
    /**
     * @var \Symfony\Component\Translation\Translator
     */
    protected $translator;

    /**
     * Constructor
     *
     * @param Translator $translator symfony trnaslator service
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * getValues
     *
     * @return array
     */
    public function getValues()
    {
        return [
            'core.index' => [
                'label'      => $this->translator->trans('core.menu.index'),
                'route'      => 'cloudsandwich_core_default_authindex',
                'attributes' => ['icon' => 'fa-home']
            ],
        ];
    }
}
