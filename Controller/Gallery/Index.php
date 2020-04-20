<?php
/**
 * File created by BacNguyen
 */
namespace Neo\Gallery\Controller\Gallery;

use Neo\Gallery\Helper\Data;
use \Magento\Framework\Exception\NotFoundException;

class Index extends \Magento\Framework\App\Action\Action
{
	/**
     * @var _pageFactory
     */
	protected $_pageFactory;
	/**
     * @var _helper
     */
	protected $helper;
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		Data $helper)
	{
		$this->helper = $helper;
		$this->_pageFactory = $pageFactory;
		return parent::__construct($context);
	}

	public function execute()
	{
		if($this->helper->isEnable() == 0){
			throw new NotFoundException(__('Parameter is incorrect.'));
		}else{
			return $this->_pageFactory->create();
		}
	}
}