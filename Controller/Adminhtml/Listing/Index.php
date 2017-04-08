<?php
namespace WSite\Menu\Controller\Adminhtml\Listing;

class Index extends \Magento\Backend\App\Action
{
    protected $_resultPageFactory;
    
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('WSite_Menu::content_menu');
    }
    
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        
        parent::__construct($context);
    }
    
    protected function _initAction()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('WSite_Menu::content_menu');
        return $resultPage;
    }
    
    public function execute()
    {
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Listing of Menus'));
        return $resultPage;
    }
}
