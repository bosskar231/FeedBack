<?php

namespace Baskar\Feedback\Controller\Adminhtml\Feedback;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Baskar\Feedback\Model\AddFeedback;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Baskar\Feedback\Helper\FeedbackMail;


class Save extends Action
{

 

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

    /**
     * @var StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @var FeedbackMail
     */
    protected $mail;

    /**
     * @param FeedbackMail $mail
     * @param RedirectFactory $redirectFactory
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param Action\Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param AddFeedback $addFeedback
     */
    public function __construct(FeedbackMail $mail, RedirectFactory $redirectFactory, TransportBuilder $transportBuilder, StateInterface $inlineTranslation, Action\Context $context, ScopeConfigInterface $scopeConfig, AddFeedback $addFeedback)
    {
        $this->addFeedback = $addFeedback;
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

        if ($id) {

            $model = $this->addFeedback;

            $model->load($id);

            if (!$model->getId()) {

                $this->messageManager->addErrorMessage(__("This Member does not exist"));
            } else {

                $model->setStatus('Accepted');

                $model->save();

                $result = $this->resultRedirectFactory->create();


                $this->messageManager->addSuccessMessage(__('Feedback Accepted '));

                $this->mail->sendFeedbackMail($model->getData('user_email'), $model->getData('first_name'), $model->getData('feedback'), 'Your Feedback has been accepted');

                return $result->setPath('*/*');
            }
        }
    }

}
