<?php

namespace CloudSandwich\FileBundle;

use CloudSandwich\FileBundle\Opener\OpenerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CloudSandwichFileBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new OpenerCompilerPass());
    }
}
