<?php

namespace BroCode\StoreOverview\Block\Adminhtml\Dashboard;

use BroCode\StoreOverview\Api\StoreOverviewServiceInterface;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Framework\Json\Helper\Data as JsonHelper;

/**
 *
 */
class StoreList extends Template
{
    protected $_template = 'BroCode_StoreOverview::dashboard/store_list.phtml';
    /**
     * @var StoreOverviewServiceInterface
     */
    protected $overviewService;

    /**
     * @param Context $context
     * @param StoreOverviewServiceInterface $overviewService
     * @param array $data
     * @param JsonHelper|null $jsonHelper
     * @param DirectoryHelper|null $directoryHelper
     */
    public function __construct(
        Template\Context $context,
        StoreOverviewServiceInterface $overviewService,
        array $data = [],
        ?JsonHelper $jsonHelper = null,
        ?DirectoryHelper $directoryHelper = null
    ) {
        parent::__construct($context, $data, $jsonHelper, $directoryHelper);
        $this->overviewService = $overviewService;
    }

    /**
     * @return \BroCode\StoreOverview\Api\Data\StoreOverviewDataInterface[]
     */
    public function getStoreOverViewData() {
        if ($this->getParam('store')) {
            return $this->overviewService->findStoreOverviewData(
                $this->getParam('store'),
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        } elseif ($this->getParam('website')) {
            return $this->overviewService->findStoreOverviewData(
                $this->getParam('website'),
                \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE
            );
        } elseif ($this->getParam('group')) {
            return $this->overviewService->findStoreOverviewData(
                $this->getParam('group'),
                \Magento\Store\Model\ScopeInterface::SCOPE_GROUP
            );
        }
        return $this->overviewService->findStoreOverviewData();
    }
}
