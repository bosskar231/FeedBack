<?php



namespace Baskar\Feedback\Controller\Adminhtml\Feedback;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
use Baskar\Feedback\Model\AddFeedback;


class EditAction extends Action
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
     * @param Action\Context $context
     * @param PageFactory $pageFactory
     * @param AddFeedback $addFeedback
     */
    public function __construct(Action\Context $context, PageFactory $pageFactory, AddFeedback $addFeedback)
    {
        $this->addFeedback = $addFeedback;
        $this->pageFactory = $pageFactory;

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

                $result = $this->resultRedirectFactory->create();

                return $result->setPath('feedback/feedback/index');
            }
        }

        $result = $this->pageFactory->create();

        $result->getConfig()->getTitle()->set('Feedback');

        return $result;
    }

}
