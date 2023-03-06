<?php

namespace BroCode\StoreOverview\Model;

use BroCode\StoreOverview\Api\StoreOverviewServiceInterface;
use BroCode\StoreOverview\Model\StoreOverviewDataMapper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\InvalidArgumentException;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Service Class for retrieving store overviews
 * @author Benjamin Rosenberger <<bensch.rosenberger@gmail.com>>
 */
class StoreOverviewService implements StoreOverviewServiceInterface
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var StoreOverviewDataMapper
     */
    protected $dataFactory;

    /**
     * @param StoreManagerInterface $storeManager
     * @param StoreOverviewDataMapper $dataFactory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        StoreOverviewDataMapper $dataFactory
    ) {
        $this->storeManager = $storeManager;
        $this->dataFactory = $dataFactory;
    }

    public function findStoreOverviewData($scopeId = null, $scope = 'store')
    {
        if ($scopeId === null) {
            $retriever = function () {
                return $this->storeManager->getWebsites();
            };
        } else {
            switch ($scope) {
                case \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE:
                case \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITES:
                    $retriever = function () use ($scopeId) {
                        return [$this->storeManager->getWebsite($scopeId)];
                    };
                    break;
                case \Magento\Store\Model\ScopeInterface::SCOPE_GROUP:
                case \Magento\Store\Model\ScopeInterface::SCOPE_GROUPS:
                    $retriever = function () use ($scopeId) {
                        return [$this->storeManager->getGroup($scopeId)];
                    };
                    break;
                case \Magento\Store\Model\ScopeInterface::SCOPE_STORE:
                case \Magento\Store\Model\ScopeInterface::SCOPE_STORES:
                    $retriever = function () use ($scopeId) {
                        return [$this->storeManager->getStore($scopeId)];
                    };
                    break;
                default:
                    throw new InvalidArgumentException(__('Invalid Scope given: %s', $scope));
            }
        }

        $storeOverData = array_map(
            function ($website) {
                return $this->dataFactory->map($website);
            },
            $retriever()
        );

        return $storeOverData;
    }
}
