<?php

namespace RusLan\SeamlessMessage\Configurator;

use RusLan\SeamlessMessage\Bundle\Provider\History\HistoryProviderAwareInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SeamlessMessageBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
//        $container->registerForAutoconfiguration(HistoryProviderAwareInterface::class)->addTag(HealthInterface::TAG);
    }
}