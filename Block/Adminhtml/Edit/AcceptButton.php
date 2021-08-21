<?php

namespace Baskar\Feedback\Block\Adminhtml\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;


class AcceptButton extends Generic implements ButtonProviderInterface
{

    
    public function getButtonData()
    {


        $status = $this->getModel()->load($this->id)->getStatus();

        $data = [];

        if ($status != 'Accepted') {
            $data = [
                'label' => __('Accept'),
                'class' => 'save primary',
                'on_click' => sprintf('location.href="%s"', $this->getBackUrl()),
                'sort_order' => 10
            ];
        }
        return $data;
    }

 
    public function getBackUrl()
    {

        return $this->getUrl('*/*/save');
    }

}
