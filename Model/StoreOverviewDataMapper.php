<?php

namespace BroCode\StoreOverview\Model;

use BroCode\StoreOverview\Api\Data\StoreOverviewDataInterface;
use BroCode\StoreOverview\Api\Data\StoreOverviewDataInterfaceFactory;
use BroCode\StoreOverview\Model\Data\StoreOverviewData;
use Magento\Backend\Block\System\Store\Store;
use Magento\Config\Model\Config\Backend\Image\Logo;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Api\Data\GroupInterface;
use Magento\Store\Api\Data\WebsiteInterface;
use Magento\Store\Model\App\Emulation;
use Magento\Store\Model\Group;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Theme\ViewModel\Block\Html\Header\LogoPathResolver;

/**
 * @author Benjamin Rosenberger <<bensch.rosenberger@gmail.com>>
 */
class StoreOverviewDataMapper
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var StoreOverviewDataInterfaceFactory
     */
    protected $dataFactory;
    /**
     * @var LogoPathResolver
     */
    protected $logoPathResolver;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param LogoPathResolver $logoPathResolver
     * @param StoreOverviewDataInterfaceFactory $dataFactory
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        LogoPathResolver $logoPathResolver,
        StoreOverviewDataInterfaceFactory $dataFactory
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->dataFactory = $dataFactory;
        $this->logoPathResolver = $logoPathResolver;
        $this->storeManager = $storeManager;
    }

    /**
     * @param $scopeElement
     * @return StoreOverviewDataInterface
     */
    public function map($scopeElement)
    {
        $element = $this->dataFactory->create();

        if ($scopeElement instanceof WebsiteInterface) {
            return $this->createWebsiteElement($element, $scopeElement);
        } elseif ($scopeElement instanceof GroupInterface) {
            return $this->createStoreGroupElement($element, $scopeElement);
        }

        return $this->createStoreViewElement($element, $scopeElement);
    }

    /**
     * @param StoreOverviewData $element
     * @param WebsiteInterface $website
     * @return StoreOverviewData
     */
    public function createWebsiteElement($element, $website)
    {
        $children = array_map(
            function ($store) {
                return $this->map($store);
            },
            array_filter(
                $this->storeManager->getStores(),
                function ($store) use ($website) {
                    return $store->getWebsiteId() == $website->getId();
                }
            )
        );
        $element->setId($website->getId())
            ->setName($website->getName())
            ->setCode($website->getCode())
            ->setUrl($this->getUrl($website->getId(), ScopeInterface::SCOPE_WEBSITE))
            ->setDefault($website->getIsDefault()==true)
            ->setActive(true)
            ->setChildren($children);

        $firstChild = reset($children);
        if ($firstChild){
            $element->setLogo($firstChild->getLogo());
        }

        return $element;
    }

    /**
     * @param StoreOverviewDataInterface $element
     * @param GroupInterface $storeGroup
     * @return StoreOverviewDataInterface|StoreOverviewData
     */
    public function createStoreGroupElement($element, $storeGroup)
    {
        return $this->map($this->storeManager->getWebsite($storeGroup->getWebsiteId()));
    }

    public function createStoreViewElement($element, $storeView)
    {
        $element->setId($storeView->getId())
            ->setName($storeView->getName())
            ->setCode($storeView->getCode())
            ->setLogo($this->getLogo($storeView->getId(), ScopeInterface::SCOPE_STORE, $storeView))
            ->setDefault($storeView->getId() == $storeView->getGroup()->getDefaultStoreId())
            ->setActive($storeView->getIsActive()==true)
            ->setUrl($storeView->getBaseUrl());
        return $element;
    }

    protected function getLogo($scopeId, $scope, $scopeElement = null)
    {
        $storeLogoPath = $this->scopeConfig->getValue(
            'design/header/logo_src',
            $scope,
            $scopeId
        );
        if ($storeLogoPath !== null) {
            $storeLogoPath = Logo::UPLOAD_DIR . '/' . $storeLogoPath;
        }
        return ($scopeElement!==null?$scopeElement->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA):'')
            . $storeLogoPath;
    }

    protected function getUrl($scopeId, $scope)
    {
        return $this->scopeConfig->getValue(
            'web/secure/base_url',
            $scope,
            $scopeId
        );
    }
}
