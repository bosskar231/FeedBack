<?php

namespace Baskar\Feedback\Controller\FormPage;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Baskar\Feedback\Model\AddFeedbackFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Baskar\Feedback\Helper\FeedbackMail;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;

class FeedbackSave extends Action
{



    /**
     * @var AddFeedbackFactory
     */
    protected $feedback;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @var Mail
     */
    protected $mail;

    /**
     * @param Mail $mail
     * @param Context $context
     * @param AddFeedbackFactory $feedback
     * @param StateInterface $inlineTranslation
     * @param ScopeConfigInterface $scopeConfig
     * @param TransportBuilder $transportBuilder
     */
    public function __construct(FeedbackMail $mail, Context $context, AddFeedbackFactory $feedback, StateInterface $inlineTranslation, ScopeConfigInterface $scopeConfig, TransportBuilder $transportBuilder)
    {
        $this->feedback = $feedback;
        $this->scopeConfig = $scopeConfig;
        $this->inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->mail = $mail;
        parent::__construct($context);
    }


    public function execute()
    {
        $post = (array) $this->getRequest()->getPost();
        $result = $this->resultRedirectFactory->create();
        
        if (!empty($post['firstname'] && !empty($post['lastname'] && !empty($post['useremail'] && !empty($post['feedback']))))) {
            $firstName = $post['firstname'];
            $lastName = $post['lastname'];
            $userEmail = $post['useremail'];
            $feedback = $post['feedback'];
            $block=\Magento\Framework\App\ObjectManager::getInstance()->get('Baskar\Feedback\Block\LoginCustomer');
            
           $firstName1= $block->getUserFirstName();
           $lastName1=$block->getUserLastName();
           $userEmail1= $block->getUserEmail();
           if($firstName!=$firstName1 || $lastName!=$lastName1 || $userEmail!=$userEmail1)
           {
                $this->messageManager->addErrorMessage('You tried to put proxy');
            $result->setPath('*/*/feedback');
            return $result;
           }
            $model = $this->feedback->create();
            $model->addData([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'user_email' => $userEmail,
                'feedback' => $feedback
            ]);
            $saveData = $model->save();
         
            
            if ($saveData) {
                $this->messageManager->addSuccessMessage('hi '.$firstName.' '.$lastName.' Thank You For your valuable feedback !');
                $result->setPath('');
                $this->mail->sendFeedbackMail($model->getData('user_email'), $model->getData('first_name'), $model->getData('feedback'), "Thanks for the feedback !!!");
                return $result;
            }
        } else {
            $this->messageManager->addErrorMessage('Feedback not saved !');
            $result->setPath('*/*/feedback');
            return $result;
        }
    }

}
