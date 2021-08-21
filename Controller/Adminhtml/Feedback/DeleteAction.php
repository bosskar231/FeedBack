<?php

namespace Baskar\Feedback\Controller\Adminhtml\Feedback;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\View\Result\PageFactory;
use Baskar\Feedback\Model\AddFeedback;


class DeleteAction extends Action
{

    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @var $feedbackRegistry
     */
    protected $feedbackRegistry;

    /**
     * @var AddFeedback
     */
    protected $addFeedback;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     
     * @param RedirectFactory $redirectFactory
     * @param Action\Context $context
     * @param PageFactory $pageFactory
     * @param AddFeedback $addFeedback
     */
    public function __construct(RedirectFactory $redirectFactory, Action\Context $context, PageFactory $pageFactory, AddFeedback $addFeedback)
    {
        $this->addFeedback = $addFeedback;
        $this->pageFactory = $pageFactory;
        $this->resultRedirectFactory = $redirectFactory;
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
                $model->delete();
                $this->messageManager->addSuccessMessage(__('Successfully deleted '));
                $result = $this->resultRedirectFactory->create();
                return $result->setPath('*/*');
            }
        }
    }

}
