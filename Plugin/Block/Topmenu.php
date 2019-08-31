<?php 

namespace Neo\Gallery\Plugin\Block;

use Magento\Framework\Data\Tree\NodeFactory;
use Neo\Gallery\Helper\Data;
class Topmenu
{
    /**
     * @var NodeFactory
     */
    protected $nodeFactory;
    /**
     * @var Data
     */
    protected $helper;

    public function __construct(
        NodeFactory $nodeFactory,
        Data $helper
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->helper = $helper;
    }

    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ) {
        $node = $this->nodeFactory->create(
            [
                'data' => $this->getNodeAsArray(),
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree()
            ]
        );
        $subject->getMenu()->addChild($node);
    }

    protected function getNodeAsArray()
    {
        if($this->helper->isEnable() == 0){
            return [];
        }else{
            return [
                'name' => __('Gallery'),
                'id' => 'neo-gallery-slider-topmenu',
                'url' => 'gallery/gallery',
                'has_active' => false,
                'is_active' => false // (expression to determine if menu item is selected or not)
            ];
        }
    }
}