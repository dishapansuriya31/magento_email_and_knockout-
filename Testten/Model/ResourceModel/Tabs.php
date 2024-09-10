<?php

namespace Kitchen\Testten\Model\ResourceModel;

class Tabs extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('kitchen_tabs', 'tab_id');
    }
}
