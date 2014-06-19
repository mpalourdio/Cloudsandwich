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

/**
 * Class OpenerCompilerPass loads list of all registered openers
 *
 * @package CloudSandwich\FileBundle\Opener
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */
class OpenerCompilerPass implements CompilerPassInterface
{

    /**
     * process
     *
     * @param ContainerBuilder $container the container
     *
     * @return null
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('cloudsandwich.filemanager')) {
            return null;
        }

        $definition = $container->getDefinition('cloudsandwich.filemanager');
        $taggedServices = $container->findTaggedServiceIds('cloudsandwich.fileopener');

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall('addOpener', [new Reference($id)]);
        }
    }
}
