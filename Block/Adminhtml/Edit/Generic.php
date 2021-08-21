<?php


namespace Baskar\Feedback\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;
use Baskar\Feedback\Model\AddFeedbackFactory;


class Generic
{

    /**
     * @var id
     */
    protected $id;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var AddFeedbackFactory
     */
    protected $addFeedbackFactory;

   
    public function __construct(Context $context, AddFeedbackFactory $addFeedback)
    {

        $this->id = $context->getRequest()->getParam('id');
        $this->urlBuilder = $context->getUrlBuilder();
        $this->addFeedbackFactory = $addFeedback;
    }

    public function getModel()
    {
        return $this->addFeedbackFactory->create();
    }

 
    public function getUrl($route)
    {
        return $this->urlBuilder->getUrl($route, ['id' => $this->id]);
    }

}
