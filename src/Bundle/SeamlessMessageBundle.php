<?php

namespace RusLan\SeamlessMessage\Bundle;

use RusLan\SeamlessMessage\Bundle\DependencyInjection\SeamlessMessageExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SeamlessMessageBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new SeamlessMessageExtension();
    }

}