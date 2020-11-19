<?php

namespace FondOfSpryker\Yves\GoogleTagManagerCore;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class GoogleTagManagerCoreDependencyProvider extends AbstractBundleDependencyProvider
{
    public const VARIABLE_BUILDER_PLUGINS = 'VARIABLE_BUILDER_PLUGINS';
    public const DEFAULT_VARIABLE_PLUGINS = 'EXTENSION_DEFAULT_PLUGINS';

    /**
     * @param Container $container
     *
     * @return Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addGoogleTagManagerVariableBuilderPlugins($container);
        $container = $this->addDefaultGoogleTagManagerExtensionPlugins($container);

        return $container;
    }

    /**
     * @param Container $container
     * @return Container
     */
    protected function addGoogleTagManagerVariableBuilderPlugins(Container $container): Container
    {
        $container->set(static::VARIABLE_BUILDER_PLUGINS, function () {
            return $this->getGoogleTagManagerVariableBuilderPlugins();
        });

        return $container;
    }

    /**
     * @return \FondOfSpryker\Yves\GoogleTagManagerCore\Dependency\GoogleTagManagerExtensionPluginInterface[][];
     */
    protected function getGoogleTagManagerVariableBuilderPlugins(): array
    {
        return [];
    }

    /**
     * @return \FondOfSpryker\Yves\GoogleTagManagerCore\Dependency\GoogleTagManagerExtensionPluginInterface[];
     */
    protected function getGoogleTagManagerCategoryVariableBuilderPlugins(): array
    {
        return [];
    }

    /**
     * @param Container $container
     * @return Container
     */
    protected function addDefaultGoogleTagManagerExtensionPlugins(Container $container): Container
    {
        $container->set(static::DEFAULT_VARIABLE_PLUGINS, function () {
            return $this->getDefaultGoogleTagManagerExtensionPlugins();
        });

        return $container;
    }

    /**
     * @return \FondOfSpryker\Yves\GoogleTagManagerCore\Dependency\GoogleTagManagerExtensionPluginInterface[];
     */
    protected function getDefaultGoogleTagManagerExtensionPlugins(): array
    {
        return [];
    }
}
