<?php

namespace Kitchen\Testten\Model;

class Tabs extends \Magento\Framework\Model\AbstractModel
{
    public function _construct()
    {
        $this->_init(\Kitchen\Testten\Model\ResourceModel\Tabs::class);
    }
}


