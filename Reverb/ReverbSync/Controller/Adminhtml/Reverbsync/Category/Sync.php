<?php
namespace Reverb\ReverbSync\Controller\Adminhtml\Reverbsync\Category;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Sync extends \Magento\Backend\App\Action
{
    protected $_categorySyncHelper = null;
    protected $_adminHelper = null;

    
	/**
	 * @var PageFactory
	 */
	protected $resultPageFactory;
	
	public function __construct(Context $context, PageFactory $resultPageFactory) {
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}

	public function execute(){ 
		$resultPage = $this->resultPageFactory->create();
		$resultPage->setActiveMenu('Reverb_ReverbSync::reverbsync_category_sync');
		$resultPage->getConfig()->getTitle()->prepend((__('Sync Reverb Categories')));
		return $resultPage;
	}
	
	
	
	/*public function saveAction()
    {
        if (!$this->getRequest()->isPost())
        {
            $error_message = self::ERROR_SUBMISSION_NOT_POST;
            $this->_getAdminHelper()->throwRedirectException($error_message);
        }

        $post_array = $this->getRequest()->getPost();

        try
        {
            $category_map_form_element_name = $this->_getCategorySyncHelper()
                                                    ->getMagentoReverbCategoryMapElementArrayName();
            $category_mapping_array = isset($post_array[$category_map_form_element_name])
                                        ? $post_array[$category_map_form_element_name] : null;
            if (!is_array($category_mapping_array) || empty($category_mapping_array))
            {
                // This shouldn't occur, but account for the fact where it does
                $error_message = self::ERROR_SUBMISSION_NOT_POST;
                throw new Exception($error_message);
            }

            $this->_getCategorySyncHelper()->processMagentoReverbCategoryMapping($category_mapping_array);
        }
        catch(Exception $e)
        {
            $error_message = sprintf(self::EXCEPTION_CATEGORY_MAPPING, $e->getMessage());

            Mage::getSingleton('reverbSync/log')->logCategoryMappingError($error_message);
            $this->_setSessionErrorAndRedirect($error_message);
        }*/

        //$this->_redirect('*/*/index');
    //}
	
    /*public function updateCategoriesAction()
    {
        try
        {
            $categoryUpdateSyncHelper = Mage::helper('ReverbSync/sync_category_update');*/
            /* @var $categoryUpdateSyncHelper Reverb_ReverbSync_Helper_Sync_Category_Update */
           /* $categoryUpdateSyncHelper->updateReverbCategoriesFromApi();
        }
        catch(Exception $e)
        {
            $error_message = $this->__(self::EXCEPTION_UPDATING_REVERB_CATEGORIES, $e->getMessage());
            Mage::getSingleton('reverbSync/log')->logCategoryMappingError($error_message);
            $this->_setSessionErrorAndRedirect($error_message);
        }

        Mage::getSingleton('adminhtml/session')->addSuccess($this->__(self::SUCCESS_UPDATED_LISTINGS));*/

        //$this->_redirect('*/*/index');
    //}

    /**
     * @param $error_message
     * @throws Reverb_ReverbSync_Controller_Varien_Exception
     */
    protected function _setSessionErrorAndRedirect($error_message)
    {
        Mage::getSingleton('adminhtml/session')->addError($this->__($error_message));
        $exception = new Reverb_ReverbSync_Controller_Varien_Exception($error_message);
        $exception->prepareRedirect('*/*/index');
        throw $exception;
    }

    public function getUriPathForAction($action)
    {
        $uri_path = sprintf('%s/%s/%s', 'adminhtml', 'ReverbSync_category_sync', $action);
        return $uri_path;
    }

    public function getBlockToShow()
    {
        return $this->getModuleBlockGroupname() . '/adminhtml_category_edit';
    }

    public function getControllerDescription()
    {
        return "Reverb Category Sync";
    }

    public function getControllerActiveMenuPath()
    {
        return 'reverb/reverb_category_sync';
    }

    public function getModuleBlockGroupname()
    {
        return 'ReverbSync';
    }

    public function getObjectParamName()
    {
        return 'reverb_category_map';
    }

    /**
     * @return Reverb_ReverbSync_Helper_Sync_Category
     */
    protected function _getCategorySyncHelper()
    {
        if (is_null($this->_categorySyncHelper))
        {
            $this->_categorySyncHelper = Mage::helper('ReverbSync/sync_category');
        }

        return $this->_categorySyncHelper;
    }
}
