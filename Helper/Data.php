<?php
namespace Neo\Gallery\Helper;
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_ENABLE = 'neo_gallery/general/enable';	
	protected $_scopeConfig;	
    protected $_storeManager;
    protected $_backendUrl;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
         \Magento\Backend\Model\UrlInterface $backendUrl
    ) {
		$this->_scopeConfig = $context->getScopeConfig();
        parent::__construct($context);
        $this->_storeManager = $storeManager;
        $this->_backendUrl = $backendUrl;
    }
	
	 /**
     * Check if enabled
     *
     * @return string|null
     */
    public function isEnable()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ENABLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }   
}
