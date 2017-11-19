<?php
/**
 * Created by PhpStorm.
 * User: w1ndy
 * Date: 16/11/2017
 * Time: 13:56
 */
class Fram_Advanceagreements_Model_Observer
{
    public function addCustomerGroupFields($observer)
    {
        $block = $observer->getEvent()->getBlock();
        if (!isset($block)) {
            return $this;
        }
        if($block->getType() == 'adminhtml/checkout_agreement_edit_form')
        {
            $id = Mage::app()->getRequest()->getParam('id');
            $value =  json_decode(Mage::getModel('advanceagreements/group')->load($id,'agreement_id')->getCustomerGroupId());
            $form = $block->getForm();

            $fieldset = $form->getElement('base_fieldset');
            $fieldset->addField('customer_group_id', 'multiselect', array(
                'name'      => 'customer_group_id[]',
                'label'     => Mage::helper('adminhtml')->__('Customer Group Id'),
                'title'     => Mage::helper('adminhtml')->__('Customer Group Id'),
                'required'  => true,
                'value'     => $value,
                'values'    => Mage::getResourceModel('customer/group_collection')->toOptionArray()
            ));
        }
    }

    public function saveAgreementForGroup($observer)
    {
        $controller = $observer ->getEvent()->getControllerAction();
        $request = $controller->getRequest();
        $postData = $request->getPost();
        $agreementId = $postData['agreement_id'];
        if(!$agreementId || $agreementId == null || $agreementId == 0)
        {
            $agreementId = Mage::helper('advanceagreements')->getLastIdOfAgreements();
        }
        $customerGroupId = json_encode($postData['customer_group_id']);
        $postData = [
            'agreement_id' => $agreementId,
            'customer_group_id'=>$customerGroupId
        ];
        $groupModel = Mage::getModel('advanceagreements/group');
        if($groupModel->load($agreementId,'agreement_id'))
        {
            $groupModel = Mage::getModel('advanceagreements/group')
                ->load($groupModel->getId())
                ->addData($postData);
            $groupModel->save();
        }else{
            $groupModel->setData($postData)->save();
        }
        return;
    }

    public function deleteAgreementGroup($observer)
    {
        $controller = $observer ->getEvent()->getControllerAction();
        $request = $controller->getRequest();
        $id = $request->getParam('id');
        if(!$id)
        {
            return;
        }
        $groupModel = Mage::getModel('advanceagreements/group')
            ->load($id,'agreement_id');
        $groupModel->delete();
        return;
    }
}