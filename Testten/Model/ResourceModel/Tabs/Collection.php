<?php

namespace Kitchen\Testten\Model\ResourceModel\Tabs;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'tab_id';
    protected function _construct()
    {
        $this->_init(
            \Kitchen\Testten\Model\Tabs::class,
            \Kitchen\Testten\Model\ResourceModel\Tabs::class
        );
    }
}
