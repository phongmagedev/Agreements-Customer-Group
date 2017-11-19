<?php
/**
 * Created by PhpStorm.
 * User: w1ndy
 * Date: 16/11/2017
 * Time: 16:55
 */
class Fram_Advanceagreements_Block_Agreements extends Mage_Checkout_Block_Agreements
{
    public function getAgreements()
    {
        if (!$this->hasAgreements()) {
            if (!Mage::getStoreConfigFlag('checkout/options/enable_agreements')) {
                $agreements = array();
            } else {
                $agreements = Mage::getModel('checkout/agreement')->getCollection()
                    ->addStoreFilter(Mage::app()->getStore()->getId())
                    ->addFieldToFilter('is_active', 1)
                    ->getAllIds();

                $agreementsIds = Mage::helper('advanceagreements')->filterAgreements($agreements);

                $agreements = Mage::getModel('checkout/agreement')->getCollection()
                    ->addStoreFilter(Mage::app()->getStore()->getId())
                    ->addFieldToFilter('is_active', 1)
                    ->addFieldToFilter('agreement_id', array('in'=>$agreementsIds) );
            }
            $this->setAgreements($agreements);
        }
        return $this->getData('agreements');


    }
}