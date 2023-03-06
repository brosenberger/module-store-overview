<?php

namespace BroCode\StoreOverview\Model\Data;

use BroCode\StoreOverview\Api\Data\StoreOverviewDataInterface;
use Magento\Framework\DataObject;

/**
 * .
 */
class StoreOverviewData extends DataObject implements StoreOverviewDataInterface
{
    public function getId()
    {
        return $this->getData(self::FIELD_ID);
    }

    public function setId($id)
    {
        return $this->setData(self::FIELD_ID, $id);
    }

    public function getName()
    {
        return $this->getData(self::FIELD_NAME);
    }

    public function setName($name)
    {
        return $this->setData(self::FIELD_NAME, $name);
    }

    public function getCode()
    {
        return $this->getData(self::FIELD_CODE);
    }

    public function setCode($code)
    {
        return $this->setData(self::FIELD_CODE, $code);
    }

    public function getUrl()
    {
        return $this->getData(self::FIELD_URL);
    }

    public function setUrl($url)
    {
        return $this->setData(self::FIELD_URL, $url);
    }

    public function getLogo()
    {
        return $this->getData(self::FIELD_LOGO);
    }

    public function setLogo($logo)
    {
        return $this->setData(self::FIELD_LOGO, $logo);
    }

    public function getDefault()
    {
        return $this->getData(self::FIELD_DEFAULT);
    }

    public function setDefault($default)
    {
        return $this->setData(self::FIELD_DEFAULT, $default);
    }

    public function getActive()
    {
        return $this->getData(self::FIELD_ACTIVE);
    }

    public function setActive($active)
    {
        return $this->setData(self::FIELD_ACTIVE, $active);
    }

    public function getChildren()
    {
        return $this->getData(self::FIELD_CHILDREN);
    }

    public function setChildren($children)
    {
        return $this->setData(self::FIELD_CHILDREN, $children);
    }
}
