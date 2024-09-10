<?php
namespace Kitchen\Testten\Controller\Index;
 
use Magento\Customer\Model\Session;
use Kitchen\Testten\Model\TabsFactory;
use Magento\Framework\Controller\Result\JsonFactory;

 
class fetchdata extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $resultJsonFactory;


    protected $tabsFactory;

 
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        Session $_session,
        TabsFactory $tabsFactory,
        JsonFactory $resultJsonFactory,
        \Magento\Framework\View\Result\PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
        $this->tabsFactory = $tabsFactory;
        $this->_session = $_session;
        $this->resultJsonFactory = $resultJsonFactory;

        return parent::__construct($context);
    }
 
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $collection = $this->tabsFactory->create()->getCollection();
        $tabsData = [];
    
        foreach ($collection as $tab) {
            $tabsData[] = ['name' => $tab->getTabName()];
        }
    
        return $result->setData($tabsData);
    }
}

