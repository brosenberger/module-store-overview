<?php

namespace BroCode\StoreOverview\Api\Data;

/**
 * @author Benjamin Rosenberger <<bensch.rosenberger@gmail.com>>
 */
interface StoreOverviewDataInterface
{
    const FIELD_ID='id';
    const FIELD_NAME='name';
    const FIELD_CODE='code';
    const FIELD_URL='url';
    const FIELD_LOGO='logo';
    const FIELD_DEFAULT='default';
    const FIELD_ACTIVE='active';
    const FIELD_CHILDREN='children';

    /**
     * @return integer
     */
    public function getId();

    /**
     * @param integer $id
     * @return StoreOverviewDataInterface
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return \BroCode\StoreOverview\Api\Data\StoreOverviewDataInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getCode();

    /**
     * @param string $code
     * @return \BroCode\StoreOverview\Api\Data\StoreOverviewDataInterface
     */
    public function setCode($code);

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param string $url
     * @return \BroCode\StoreOverview\Api\Data\StoreOverviewDataInterface
     */
    public function setUrl($url);

    /**
     * @return string
     */
    public function getLogo();

    /**
     * @param string $logo
     * @return \BroCode\StoreOverview\Api\Data\StoreOverviewDataInterface
     */
    public function setLogo($logo);

    /**
     * @return boolean
     */
    public function getDefault();

    /**
     * @param boolean $default
     * @return StoreOverviewDataInterface
     */
    public function setDefault($default);

    /**
     * @return boolean
     */
    public function getActive();

    /**
     * @param boolean $active
     * @return StoreOverviewDataInterface
     */
    public function setActive($active);

    /**
     * @return \BroCode\StoreOverview\Api\Data\StoreOverviewDataInterface[]|null
     */
    public function getChildren();

    /**
     * @param \BroCode\StoreOverview\Api\Data\StoreOverviewDataInterface[] $children
     * @return \BroCode\StoreOverview\Api\Data\StoreOverviewDataInterface
     */
    public function setChildren($children);
}
