<?php
/**
 * Created by PhpStorm.
 * User: w1ndy
 * Date: 16/11/2017
 * Time: 13:53
 */
class Fram_Advanceagreements_Helper_Data extends Mage_Checkout_Helper_Data
{
   public function getLastIdOfAgreements()
   {
       $id = null;
       $model = Mage::getModel('checkout/agreement')->getCollection();
       foreach($model as $agreement)
       {
           $id = $agreement->getId();
       }
       return $id;
   }
    public function getRequiredAgreementIds() {

        if (is_null($this->_agreements)) {
            if (!Mage::getStoreConfigFlag('checkout/options/enable_agreements')) {
                $this->_agreements = array();
            } else {
                $this->_agreements = Mage::getModel('checkout/agreement')->getCollection()
                    ->addStoreFilter((Mage::app()->getStore()->getId()))
                    ->addFieldToFilter('is_active', 1)
                    ->getAllIds();
                $this->_agreements = $this->filterAgreements($this->_agreements);
            }
        }
        return $this->_agreements;

    }

    public function getOnlineCustomerGroupId()
    {
        return Mage::getSingleton('customer/session')->getCustomerGroupId();
    }

    public function filterAgreements($agreements)
    {
        $groupModel = Mage::getModel('advanceagreements/group');
        foreach($agreements as $key => $agreementId)
        {
            $customerGroupIds = json_decode($groupModel->load($agreementId,'agreement_id')->getCustomerGroupId());
            if(
                $this->getOnlineCustomerGroupId() == $customerGroupIds || in_array($this->getOnlineCustomerGroupId(),$customerGroupIds) || !$customerGroupIds
                || $customerGroupIds == null
            )
            {
                continue;
            }else{
                unset($agreements[$key]);
            }
        }
        return $agreements;
    }

    public function test()
    {
        $groupModel = Mage::getModel('advanceagreements/group');
        $customerGroupIds = json_decode($groupModel->load(1,'agreement_id')->getCustomerGroupId());
        return $customerGroupIds;
    }
}