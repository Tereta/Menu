<?php
/**                                                                                                  
 *                                                                                                   
 *  /$$$$$$$$                              /$$                      /$$$$$$  /$$                     
 * |__  $$__/                             | $$                     /$$__  $$| $$                     
 *    | $$  /$$$$$$   /$$$$$$   /$$$$$$  /$$$$$$    /$$$$$$       | $$  \ $$| $$  /$$$$$$  /$$   /$$ 
 *    | $$ /$$__  $$ /$$__  $$ /$$__  $$|_  $$_/   |____  $$      | $$$$$$$$| $$ /$$__  $$|  $$ /$$/ 
 *    | $$| $$$$$$$$| $$  \__/| $$$$$$$$  | $$      /$$$$$$$      | $$__  $$| $$| $$$$$$$$ \  $$$$/  
 *    | $$| $$_____/| $$      | $$_____/  | $$ /$$ /$$__  $$      | $$  | $$| $$| $$_____/  >$$  $$  
 *    | $$|  $$$$$$$| $$      |  $$$$$$$  |  $$$$/|  $$$$$$$      | $$  | $$| $$|  $$$$$$$ /$$/\  $$ 
 *    |__/ \_______/|__/       \_______/   \___/   \_______/      |__/  |__/|__/ \_______/|__/  \__/ 
 *                                                                                                   
 * @copyright   Copyright © 2017 Tereta Alexander, tereta@mail.ua. All rights reserved.              
 * @license     http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)           
 */

namespace MagentoYo\Menu\Controller\Adminhtml\Listing;

class MassRemove extends \Magento\Backend\App\Action
{
    protected $_menuCollectionFactory;
    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \MagentoYo\Menu\Model\MenuFactory $menuFactory
    ) {
        $this->_menuFactory = $menuFactory;
        
        parent::__construct($context);
    }
    
    public function execute()
    {
        $id = (int) $this->getRequest()->getParam('entity_id');
        $data = $this->getRequest()->getPostValue();
        if (!$data && $id){
            $data['entity_id'] = [$id];
        }
        elseif (isset($data['selected'])) {
            $data['entity_id'] = $data['selected'];
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data && isset($data['entity_id']) && is_array($data['entity_id']) && $data['entity_id']) {
            $ids = $data['entity_id'];
            $modelCollection = $this->_menuFactory->create()->getCollection();
            $modelCollection->addFieldToFilter('entity_id', $ids);

            try {
                $modelCollection->walk('delete');
                $this->messageManager->addSuccessMessage(__('The menus were successfully removed.'));
                return $resultRedirect->setPath('*/*');
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __($e->getMessage() . ' Something went wrong while mass remove.')
                );
            }
            $this->_getSession()->setFormData($data);
        }

        return $resultRedirect->setPath('*/*');
    }
    
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MagentoYo_Menu::content_menu');
    }
}
