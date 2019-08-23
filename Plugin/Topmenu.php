<?php
namespace Neo\Gallery\Plugin;

class Topmenu
{
    /**
    * @param Context                                   $context
    * @param array                                     $data
    */
    public function __construct(
        \Magento\Customer\Model\Session $session
    ) {
        $this->Session = $session;
    }


    public function afterGetHtml(\Magento\Theme\Block\Html\Topmenu $topmenu, $html)
    {
        $swappartyUrl = $topmenu->getUrl('gallery/gallery');//here you can set link
        $magentoCurrentUrl = $topmenu->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);
        if (strpos($magentoCurrentUrl,'gallery/gallery') !== false) {
            $html .= "<li class=\"level0 nav-8 active level-top ui-menu-item\">";
        } else {
            $html .= "<li class=\"level0 nav-7 level-top ui-menu-item\">";
        }
        $html .= "<a href=\"" . $swappartyUrl . "\" class=\"level-top ui-corner-all\"><span>" . __("Gallery") . "</span></a>";
        $html .= "</li>";
        return $html;
    }
}