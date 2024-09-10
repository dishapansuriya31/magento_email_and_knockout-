<?php
namespace Kitchen\Testten\Block;
use Kitchen\Testten\Model\TabsFactory;

 
class Index extends \Magento\Framework\View\Element\Template
{
    protected $configProvider;
    protected $tabsFactory;

    protected $_layoutProcessors;
 
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Checkout\Model\CompositeConfigProvider $configProvider,
        TabsFactory $tabsFactory,

        array $layoutProcessors = [],
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->configProvider = $configProvider;
        $this->_layoutProcessors = $layoutProcessors;
        $this->tabsFactory = $tabsFactory;

        
    }
 
    public function getJsLayout()
    {
        foreach ($this->_layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }
        return parent::getJsLayout();
    }

    public function display()
    {
        $collection = $this->tabsFactory->create()->getCollection()->getData();
        
    
        return json_encode($collection);
    }
    
    
}
 