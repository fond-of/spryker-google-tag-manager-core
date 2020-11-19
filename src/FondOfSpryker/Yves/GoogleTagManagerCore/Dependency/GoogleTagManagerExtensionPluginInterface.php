<?php

namespace FondOfSpryker\Yves\GoogleTagManagerCore\Dependency;

interface GoogleTagManagerExtensionPluginInterface
{
    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function addVariable(string $page, array $params): array;
}
