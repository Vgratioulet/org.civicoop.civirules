<?php
/**
 * BAO RuleAction for CiviRule Rule Action
 * 
 * @author Erik Hommel (CiviCooP) <erik.hommel@civicoop.org>
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 */
class CRM_Civirules_BAO_RuleAction extends CRM_Civirules_DAO_RuleAction {
  /**
   * Function to get values
   * 
   * @return array $result found rows with data
   * @access public
   * @static
   */
  public static function getValues($params) {
    $result = array();
    $ruleAction = new CRM_Civirules_BAO_RuleAction();
    if (!empty($params)) {
      $fields = self::fields();
      foreach ($params as $key => $value) {
        if (isset($fields[$key])) {
          $ruleAction->$key = $value;
        }
      }
    }
    $ruleAction->find();
    while ($ruleAction->fetch()) {
      $row = array();
      self::storeValues($ruleAction, $row);
      $result[$row['id']] = $row;
    }
    return $result;
  }
  /**
   * Function to add or update rule action
   * 
   * @param array $params 
   * @return array $result
   * @access public
   * @throws Exception when params is empty
   * @static
   */
  public static function add($params) {
    $result = array();
    if (empty($params)) {
      throw new Exception('Params can not be empty when adding or updating a civirule rule action');
    }
    $ruleAction = new CRM_Civirules_BAO_RuleAction();
    $fields = self::fields();
    foreach ($params as $key => $value) {
      if (isset($fields[$key])) {
        $ruleAction->$key = $value;
      }
    }
    $ruleAction->save();
    self::storeValues($ruleAction, $result);
    return $result;
  }
  /**
   * Function to delete a rule action with id
   * 
   * @param int $ruleActionId
   * @throws Exception when ruleActionId is empty
   * @access public
   * @static
   */
  public static function deleteWithId($ruleActionId) {
    if (empty($ruleActionId)) {
      throw new Exception('rule action id can not be empty when attempting to delete a civirule rule action');
    }
    $ruleAction = new CRM_Civirules_BAO_RuleAction();
    $ruleAction->id = $ruleActionId;
    $ruleAction->delete();
    return;
  }
  /**
   * Function to disable a rule action
   * 
   * @param int $ruleActionId
   * @throws Exception when ruleActionId is empty
   * @access public
   * @static
   */
  public static function disable($ruleActionId) {
    if (empty($ruleActionId)) {
      throw new Exception('rule action id can not be empty when attempting to disable a civirule rule action');
    }
    $ruleAction = new CRM_Civirules_BAO_RuleAction();
    $ruleAction->id = $ruleActionId;
    $ruleAction->find(true);
    self::add(array('id' => $ruleAction->id, 'is_active' => 0));
  }
  /**
   * Function to enable a rule action
   * 
   * @param int $ruleActionId
   * @throws Exception when ruleActionId is empty
   * @access public
   * @static
   */
  public static function enable($ruleActionId) {
    if (empty($ruleActionId)) {
      throw new Exception('rule action id can not be empty when attempting to enable a civirule rule action');
    }
    $ruleAction = new CRM_Civirules_BAO_RuleAction();
    $ruleAction->id = $ruleActionId;
    $ruleAction->find(true);
    self::add(array('id' => $ruleAction->id, 'is_active' => 1));
  }
}