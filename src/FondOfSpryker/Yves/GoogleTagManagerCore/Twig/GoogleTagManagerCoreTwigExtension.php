<?php

namespace FondOfSpryker\Yves\GoogleTagManagerCore\Twig;

use Generated\Shared\Transfer\GoogleTagManagerDefaultVariablesTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use SprykerShop\Yves\ShopApplication\Plugin\AbstractTwigExtensionPlugin;
use Twig\Environment;
use Twig_SimpleFunction;

/**
 * @method \FondOfSpryker\Yves\GoogleTagManagerCore\GoogleTagManagerCoreFactory getFactory()
 * @method \FondOfSpryker\Yves\GoogleTagManagerCore\GoogleTagManagerCoreConfig getConfig()
 */
class GoogleTagManagerCoreTwigExtension extends AbstractTwigExtensionPlugin
{
    public const FUNCTION_GOOGLE_TAG_MANAGER = 'googleTagManager';
    public const FUNCTION_DATA_LAYER = 'dataLayer';

    /**
     * @var array
     */
    protected $dataLayerVariables = [];

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            $this->createGoogleTagManagerFunction(),
            $this->createDataLayerFunction(),
        ];
    }

    /**
     * @return \Twig_SimpleFunction
     */
    protected function createGoogleTagManagerFunction()
    {
        return new Twig_SimpleFunction(
            static::FUNCTION_GOOGLE_TAG_MANAGER,
            [$this, 'renderGoogleTagManager'],
            [
                'is_safe' => ['html'],
                'needs_environment' => true,
            ]
        );
    }

    /**
     * @return \Twig_SimpleFunction
     */
    protected function createDataLayerFunction()
    {
        return new Twig_SimpleFunction(
            static::FUNCTION_DATA_LAYER,
            [$this, 'renderDataLayer'],
            [
                'is_safe' => ['html'],
                'needs_environment' => true,
            ]
        );
    }

    /**
     * @param \Twig\Environment $twig
     * @param string $templateName
     *
     * @return string
     */
    public function renderGoogleTagManager(Environment $twig, $templateName): string
    {
        if (!$this->getConfig()->isEnabled() || !$this->getConfig()->getContainerID()) {
            return '';
        }

        return $twig->render($templateName, [
            'containerID' => $this->getConfig()->getContainerID(),
        ]);
    }

    /**
     * @param \Twig\Environment $twig
     * @param string $page
     * @param array $params
     *
     * @return string
     */
    public function renderDataLayer(Environment $twig, string $page, array $params): string
    {
        ,
        {
            "name": "fond-of-spryker/google-tag-manager-default-variables",
      "type": "path",
      "url": "local_repositories/fond-of-spryker/spryker-google-tag-manager-default-variables"
    }        if (!$this->getConfig()->isEnabled() || !$this->getConfig()->getContainerID()) {
            return '';
        }

        $dataLayerVariables = $this->addDefaultVariables($page, $params);

        foreach ($this->getFactory()->getVariableBuilderPlugins() as $variableBuilderPlugin) {
            if (!\array_key_exists($page, $variableBuilderPlugin)) {
                continue;
            }

            foreach ($variableBuilderPlugin as $plugin) {
                $dataLayerVariables = \array_merge(
                    $dataLayerVariables,
                    $plugin->addVariable($page, $params)
                );
            }
        }

        return $twig->render($this->getDataLayerTemplateName(), [
            'data' => $dataLayerVariables
        ]);
    }

    /**
     * @param $page
     * @param array $params
     *
     * @return array
     */
    protected function addDefaultVariables($page, array $params = []): array
    {
        $dataLayerVariables = [];
        $defaultPlugins = $this->getFactory()->getDefaultVariableBuilderPlugin();

        foreach ($defaultPlugins as $plugin) {
            $dataLayerVariables[] = $plugin->addVariable($page, $params);
        }

        return array_merge([], ...$dataLayerVariables);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $product
     *
     * @return array
     */
    protected function addProductVariables(ProductAbstractTransfer $product): array
    {
        $productVariableBuilder = $this->getFactory()
            ->getProductVariableBuilder();

        return $this->dataLayerVariables = array_merge(
            $this->dataLayerVariables,
            $productVariableBuilder->getVariables($product)
        );
    }

    /**
     * @param array $category
     * @param array $products
     * @param string $contentType
     *
     * @return array
     */
    protected function addCategoryVariables($category, $products, string $contentType): array
    {
        $categoryVariableBuilder = $this->getFactory()->getCategoryVariableBuilderPlugin();

        return $this->dataLayerVariables = array_merge(
            $this->dataLayerVariables,
            $categoryVariableBuilder->getVariables($category, $products, [
                'contentType' => $contentType,
            ])
        );
    }

    /**
     * @return array
     */
    protected function addQuoteVariables(): array
    {
        $quoteVariableBuilder = $this->getFactory()
            ->getQuoteVariableBuilderPlugin();

        $quoteTransfer = $this->getFactory()
            ->getCartClient()
            ->getQuote();

        if (count($quoteTransfer->getItems()) === 0) {
            return $this->dataLayerVariables;
        }

        return $this->dataLayerVariables = array_merge(
            $this->dataLayerVariables,
            $quoteVariableBuilder->getVariables($quoteTransfer)
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return array
     */
    protected function addOrderVariables(OrderTransfer $orderTransfer): array
    {
        $orderVariableBuilder = $this->getFactory()->getOrderVariableBuilderPlugin();

        return $this->dataLayerVariables = array_merge(
            $this->dataLayerVariables,
            $orderVariableBuilder->getVariables($orderTransfer)
        );
    }

    /**
     * @param string $page
     *
     * @return array
     */
    protected function addNewsletterSubscribeVariables(string $page): array
    {
        $newsletterVariableBuilder = $this->getFactory()->getNewsletterVariableBuilder();

        return $this->dataLayerVariables = array_merge(
            $this->dataLayerVariables,
            $newsletterVariableBuilder->getVariables($page)
        );
    }

    /**
     * @return string
     */
    protected function getDataLayerTemplateName(): string
    {
        return '@GoogleTagManager/partials/data-layer.twig';
    }

    /**
     * @return string|null
     */
    protected function getClientIpAddress(): ?string
    {
        $ipAddress = $_SERVER['REMOTE_ADDR'];

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $ipAddress;
    }
}
