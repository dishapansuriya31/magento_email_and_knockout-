<?php
namespace Kitchen\Testten\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface;
use Magento\Store\Model\StoreManagerInterface; 

class SendEmail extends \Magento\Framework\App\Action\Action implements HttpPostActionInterface
{
    protected $resultJsonFactory;
    protected $transportBuilder;
    protected $inlineTranslation;
    protected $scopeConfig;
    protected $logger;
    protected $_storeManager; 

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        ScopeConfigInterface $scopeConfig,
        LoggerInterface $logger,
        StoreManagerInterface $_storeManager 
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
        $this->_storeManager = $_storeManager; // Initialize the _storeManager property
        parent::__construct($context);
    }

    public function execute()
{
    
    $postData = $this->getRequest()->getParams();
    
    $email = isset($postData['email']) ? trim($postData['email']) : '';
    $comment = isset($postData['comment']) ? trim($postData['comment']) : '';

    // Perform validation
    if ($email === '' || $comment === '') {
        return $result->setData(['success' => false, 'message' => __('Please fill in all required fields.')]);
    }

    try {
        $templateId = $this->scopeConfig->getValue(
            'kitchen_email/email_group/kitchen_email_template',
            ScopeInterface::SCOPE_STORE
        );
        $fromEmail = 'disha.pansuriya@kitchen365.com';
        $fromName = 'test'; // Replace with the sender's name

        $templateOptions = [
            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
            'store' => $this->_storeManager->getStore()->getId(),
        ];

        $templateVars = [
            'comment' => $comment,
        ];

        $this->inlineTranslation->suspend();
        $transport = $this->transportBuilder->setTemplateIdentifier($templateId)
            ->setTemplateOptions($templateOptions)
            ->setTemplateVars($templateVars)
            ->setFrom(['email' => $fromEmail, 'name' => $fromName])
            ->addTo($email)
            ->getTransport();

        $transport->sendMessage();
        $this->inlineTranslation->resume();

        return $result->setData(['success' => true, 'message' => __('Email sent successfully.')]);
    } catch (\Exception $e) {
        $this->logger->error('Failed to send email: ' . $e->getMessage());
        return $result->setData(['success' => false, 'message' => __('Failed to send email. Please try again later.')]);
    }
}

    
}
