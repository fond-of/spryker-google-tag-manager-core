<?php

namespace FondOfSpryker\Yves\GoogleTagManagerCore;

use FondOfSpryker\Yves\GoogleTagManagerCore\Dependency\GoogleTagManagerExtensionPluginInterface;
use Spryker\Yves\Kernel\AbstractFactory;
use FondOfSpryker\Yves\GoogleTagManagerCore\Twig\GoogleTagManagerCoreTwigExtension;

class GoogleTagManagerCoreFactory extends AbstractFactory
{
    /**
     * @return GoogleTagManagerCoreTwigExtension
     */
    public function createGoogleTagManagerCoreTwigExtension()
    {
        return new GoogleTagManagerCoreTwigExtension();
    }

    /**
     * @return GoogleTagManagerExtensionPluginInterface[][]
     */
    public function getVariableBuilderPlugins(): array
    {
        return $this->getProvidedDependency(GoogleTagManagerCoreDependencyProvider::VARIABLE_BUILDER_PLUGINS);
    }

    /**
     * @return GoogleTagManagerExtensionPluginInterface[]
     */
    public function getDefaultVariableBuilderPlugin(): array
    {
        return $this->getProvidedDependency(GoogleTagManagerCoreDependencyProvider::DEFAULT_VARIABLE_PLUGINS);
    }
}
