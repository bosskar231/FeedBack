<?php
           

namespace Baskar\Feedback\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\SessionFactory;

class LoginCustomer extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magento\Customer\Model\SessionFactory $_customerSession
     */
    protected $_customerSession;

    /**
     * @var \Magento\Framework\App\Http\Context
     */
    protected $httpContext;

    /**
     * LoginCustomer constructor.
     * @param  $context
     * @param  $customerSession
     * @param array $data
     */
    public function __construct(
            Context $context, 
            SessionFactory $customerSession,
            array $data = []
    )
    {
        $this->_isScopePrivate = true;
        $this->_customerSession = $customerSession->create();
        ;
        parent::__construct($context, $data);
    }

  
    public function getCustomerSession()
    {
        return $this->_customerSession;
    }

    
    public function getUserFirstName()
    {
        if ($this->_customerSession->isLoggedIn()) {
            return $this->_customerSession->getCustomerData()->getFirstname();
        }
        return false;
    }


    public function getUserLastName()
    {
        if ($this->_customerSession->isLoggedIn()) {
            return $this->_customerSession->getCustomerData()->getLastname();
        }
        return false;
    }

 
    public function getUserEmail()
    {
        if ($this->_customerSession->isLoggedIn()) {
            return $this->_customerSession->getCustomerData()->getEmail();
        }
        return false;
    }

}
