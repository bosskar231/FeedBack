<?php


namespace Baskar\Feedback\Model\ResourceModel\AddFeedback;

use Baskar\Feedback\Model\ResourceModel\AddFeedback as AddFeedbackRS;
use Baskar\Feedback\Model\AddFeedback;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    
    protected $_idFieldName = 'customer_id';

    public function _construct()
    {
        $this->_init(AddFeedback::class, AddFeedbackRS::class);
    }

}
