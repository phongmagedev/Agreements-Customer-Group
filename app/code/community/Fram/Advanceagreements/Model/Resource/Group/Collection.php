<?php
/**
 * Created by PhpStorm.
 * User: w1ndy
 * Date: 16/11/2017
 * Time: 16:06
 */
class Fram_Advanceagreements_Model_Resource_Group_Collection extends  Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        return $this->_init('advanceagreements/group');
    }
}