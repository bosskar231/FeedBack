<?php


namespace Baskar\Feedback\Controller\Adminhtml\Feedback;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;


class Index extends Action
{

    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @param Action\Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(Action\Context $context, PageFactory $pageFactory)
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

 
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Baskar_Feedback::feedback');
    }

  
    public function execute()
    {
        $result = $this->pageFactory->create();
        $result->getConfig()->getTitle()->set('Customers Feedback');
        return $result;
    }

}
