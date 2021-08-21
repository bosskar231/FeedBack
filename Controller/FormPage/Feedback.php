<?php

namespace Baskar\Feedback\Controller\FormPage;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;


class Feedback extends Action
{

    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(Context $context, PageFactory $pageFactory)
    {

        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

 
    public function execute()
    {

        $result = $this->pageFactory->create();
        $result->getConfig()->getTitle()->set('Feedback Form');
        return $result;
    }

}
