<?php

namespace FondOfSpryker\Yves\GoogleTagManagerCore;

use FondOfSpryker\Shared\GoogleTagManagerCore\GoogleTagManagerCoreConstants;
use Spryker\Yves\Kernel\AbstractBundleConfig;

class GoogleTagManagerCoreConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getContainerId(): string
    {
        return $this->get(GoogleTagManagerCoreConstants::CONTAINER_ID, 'GTM-XXXXXX');
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->get(GoogleTagManagerCoreConstants::ENABLED, false);
    }
}
