<?php


namespace Baskar\Feedback\Model;

class AddFeedback extends \Magento\Framework\Model\AbstractModel
{

    public function _construct()
    {
        $this->_init("Baskar\Feedback\Model\ResourceModel\AddFeedback");
    }

}
