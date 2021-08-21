<?php



namespace Baskar\Feedback\Helper;

use Magento\Store\Model\Store;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;

class FeedbackMail
{

    /**
     * @var Magento\Framework\Translate\Inline
     */
    protected $inlineTranslation;

    /**
     * @var Magento\Framework\Mail\Template
     */
    protected $transportBuilder;
    /**
     *
     * @var Magento\Framework\App\Config\ScopeConfigInterface 
     */
    protected $scopeConfig;

    /**
     * @param ScopeInterface $scopeConfig
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     */
    public function __construct(ScopeConfigInterface $scopeConfig, TransportBuilder $transportBuilder, StateInterface $inlineTranslation)
    {
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
    }
    
   
    public function storeAdmin()
    {
        return $this->scopeConfig->getValue('trans_email/ident_general/email', ScopeInterface::SCOPE_STORE);
    }
    
 
    public function sendFeedbackMail($userEmail, $firstName, $feedback, $message)
    {

        $this->inlineTranslation->suspend();
        $transport = $this->transportBuilder->setTemplateIdentifier('mail_template')
                ->setTemplateOptions(['area'  => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => Store::DEFAULT_STORE_ID])
                ->setTemplateVars([ 
                                      'name'  =>  $firstName,
                                    'feedback'=> $feedback,
                                    'message' => $message])
                ->setFrom(['email' => $this->storeAdmin(), 'name' => 'noreply@owner.com'])
                ->addTo([$userEmail])
                ->addBcc($this->storeAdmin())
                ->getTransport();
        $transport->sendMessage();
        $this->inlineTranslation->resume();
    }

}
