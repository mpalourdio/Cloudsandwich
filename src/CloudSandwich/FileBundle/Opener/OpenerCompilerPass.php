<?php
/**
 * Created by PhpStorm.
 * User: sme
 * Date: 13.06.14
 * Time: 15:08
 */
namespace CloudSandwich\FileBundle\Opener;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class OpenerCompilerPass implements CompilerPassInterface
{
    /**
     * @param  ContainerBuilder $container
     * @return null|void
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('cloudsandwich.filemanager')) {
            return null;
        }

        $definition     = $container->getDefinition('cloudsandwich.filemanager');
        $taggedServices = $container->findTaggedServiceIds('cloudsandwich.fileopener');

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall('addOpener', [new Reference($id)]);
        }
    }
}
