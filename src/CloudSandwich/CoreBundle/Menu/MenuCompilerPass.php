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

class MenuCompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('cloudsandwich.menubuilder')) {
            return null;
        }

        $definition = $container->getDefinition('cloudsandwich.menubuilder');
        $taggedServices = $container->findTaggedServiceIds('cloudsandwich.menufiller');

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall('addFiller',array(new Reference($id)));
        }
    }

}