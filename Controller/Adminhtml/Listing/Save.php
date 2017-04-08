<?php

namespace WSite\Menu\Controller\Adminhtml\Listing;

class Save extends \Magento\Backend\App\Action
{
    protected $_menuModel;
    
    public function __construct(
        \WSite\Menu\Model\MenuFactory $menuModelFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->_menuModelFectory = $menuModelFactory;
        parent::__construct($context);
    }
    
    public function execute()
    {
        $id = (int) $this->getRequest()->getParam('entity_id');
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->_menuModelFectory->create();

            if ($id) {
                $model->load($id);
            }
            else{
                unset($data['entity_id']);
            }

            try {
                if (isset($data['identifier'])) {
                    $data['identifier'] = strtolower($data['identifier']);
                    $data['identifier'] = preg_replace('/[^a-z0-9]/', '_', $data['identifier']);
                }
                
                $model
                    ->setData($data)
                    ->save();
                
                $id = $model->getId();
                
                $this->messageManager->addSuccessMessage(__('The menu was successfully saved.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id, '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\ValidatorException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __($e->getMessage() . ' Something went wrong while saving the item.')
                );
            }
            $this->_getSession()->setFormData($data);
        } else {
            $this->messageManager->addErrorMessage(__('Incorrect data'));
        }

        return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id, '_current' => true]);
    }
    
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('WSite_Menu::content_menu');
    }
}
