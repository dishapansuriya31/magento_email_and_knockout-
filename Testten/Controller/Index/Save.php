<?php
namespace Kitchen\Testten\Controller\Index;
 
use Magento\Customer\Model\Session;
use Kitchen\Testten\Model\TabsFactory;

 
class Save extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    protected $tabsFactory;

 
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        Session $_session,
        TabsFactory $tabsFactory,
        \Magento\Framework\View\Result\PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
        $this->tabsFactory = $tabsFactory;
        $this->_session = $_session;
        return parent::__construct($context);
    }
 
    public function execute()
    {
        echo "Knockout";
        $jsonData = $this->getRequest()->getContent();
		$data = json_decode($jsonData, true);

		$tab = isset($data['value']) ? $data['value'] : '';
        
        $model = $this->tabsFactory->create();
        $model->setTabName($tab);
        $model->save();

        return $this->_pageFactory->create();
        
        
        
    
    }
}