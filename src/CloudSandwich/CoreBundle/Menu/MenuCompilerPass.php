<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\CoreBundle\Menu;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class MenuCompilerPass
 *
 * @package CloudSandwich\CoreBundle\Menu
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */
class MenuCompilerPass implements CompilerPassInterface
{

    /**
     * process the list of services
     *
     * @param ContainerBuilder $container the container
     *
     * @return null
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('cloudsandwich.menubuilder')) {
            return null;
        }

        $definition = $container->getDefinition('cloudsandwich.menubuilder');
        $taggedServices = $container->findTaggedServiceIds(
            'cloudsandwich.menufiller'
        );

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall('addFiller', [new Reference($id)]);
        }
    }
}
