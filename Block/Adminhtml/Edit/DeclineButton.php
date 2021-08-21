<?php


namespace Baskar\Feedback\Block\Adminhtml\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeclineButton extends Generic implements ButtonProviderInterface
{

  
    public function getButtonData()
    {

        $status = $this->getModel()->load($this->id)->getStatus();

        $decline = [];
        if ($status != 'Declined') {
            $decline = [
                'label' => __('Reject'),
                'class' => 'save primary',
                'on_click' => sprintf('location.href="%s"', $this->getBackUrl()),
                'sort_order' => 10
            ];
        }
        return $decline;
    }

   
    public function getBackUrl()
    {
        return $this->getUrl('*/*/Decline');
    }

}
