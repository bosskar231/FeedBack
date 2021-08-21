<?php

namespace Baskar\Feedback\Controller\Adminhtml\Feedback;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
use Baskar\Feedback\Helper\FeedbackMail;
use Baskar\Feedback\Model\AddFeedback;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;


class Decline extends Action
{

 

    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @var AddFeedback
     */
    protected $addFeedback;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    protected $inlineTranslation;
    protected $_transportBuilder;
    protected $mail;

    /**
     * @param FeedbackMail $mail
     * @param RedirectFactory $redirectFactory
     * @param StateInterface $inlineTranslation
     * @param TransportBuilder $transportBuilder
     * @param ScopeConfigInterface $scopeConfig
     * @param Action\Context $context
     * @param PageFactory $pageFactory
     * @param AddFeedback $addFeedback
     */
    public function __construct(FeedbackMail $mail, RedirectFactory $redirectFactory, StateInterface $inlineTranslation, TransportBuilder $transportBuilder, ScopeConfigInterface $scopeConfig, Action\Context $context, PageFactory $pageFactory, AddFeedback $addFeedback)
    {
        $this->addFeedback = $addFeedback;
        $this->pageFactory = $pageFactory;
        $this->resultRedirectFactory = $redirectFactory;
        $this->scopeConfig = $scopeConfig;
        $this->inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->mail = $mail;
        parent::__construct($context);
    }

    
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Baskar_Feedback::feedback');
    }

   
    public function execute()
    {
        $id = $this->getRequest()->getParam("id");

        $model = $this->addFeedback;

        if ($id) {

            $model->load($id);

            if (!$model->getId()) {

                $this->messageManager->addErrorMessage(__("This Member does not exist"));
            } else {

                $model->setStatus('Declined');
                $model->save();
                $this->messageManager->addSuccessMessage(__('Feedback declined'));
                $this->mail->sendFeedbackMail($model->getData('user_email'), $model->getData('first_name'), $model->getData('feedback'), "Your feedback has been declined !!");
                $result = $this->resultRedirectFactory->create();
                return $result->setPath('*/*');
            }
        }
    }

}
