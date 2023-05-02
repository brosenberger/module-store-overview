<?php

namespace BroCode\StoreOverview\Api;

use BroCode\StoreOverview\Api\Data\StoreOverviewDataInterface;

/**
 * @author Benjamin Rosenberger <<bensch.rosenberger@gmail.com>>
 */
interface StoreOverviewServiceInterface
{
    /**
     * @param string|int $scopeId
     * @param string $scope
     * @return \BroCode\StoreOverview\Api\Data\StoreOverviewDataInterface[]
     */
    public function findStoreOverviewData($scopeId = null, $scope = 'store');
}
