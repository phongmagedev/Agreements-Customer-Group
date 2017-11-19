<?php
/**
 * Created by PhpStorm.
 * User: w1ndy
 * Date: 16/11/2017
 * Time: 16:04
 */
class Fram_Advanceagreements_Model_Resource_Group extends  Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        return $this->_init('advanceagreements/group', 'id');
    }
}