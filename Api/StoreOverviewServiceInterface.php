<?php

namespace BroCode\StoreOverview\Api;

use BroCode\StoreOverview\Api\Data\StoreOverviewDataInterface;

/**
 *
 */
interface StoreOverviewServiceInterface
{
    /**
     * @param string|int $scopeId
     * @param string $scope
     * @return StoreOverviewDataInterface[]
     */
    public function findStoreOverviewData($scopeId = null, $scope = 'store');
}
