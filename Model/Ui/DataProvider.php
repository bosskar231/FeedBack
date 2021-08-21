<?php


namespace Baskar\Feedback\Model\Ui;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Baskar\Feedback\Model\ResourceModel\AddFeedback\CollectionFactory;



class DataProvider extends AbstractDataProvider
{

    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $feedbackCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
    $name, $primaryFieldName, $requestFieldName, CollectionFactory $feedbackCollectionFactory, array $meta = [], array $data = []
    )
    {
        $this->collection = $feedbackCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

  
    public function getData()
    {



        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();


        foreach ($items as $member) {

            $this->loadedData[$member->getId()] = $member->getData();
        }


        return $this->loadedData;
    }

}
