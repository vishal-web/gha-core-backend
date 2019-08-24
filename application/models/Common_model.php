<?php
class Common_model extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }
  
  public function dbselect($Table, $Condition = NULL, $Data = NULL, $Start = NULL, $Join = NULL, $Order = NULL, $Limit = 10, $GroupBy = NULL, $OrCondition = NULL)
  {
    if ($Data != NULL) {
      $this->db->select($Data);
    } else {
      $this->db->select("*");
    }
    $this->db->from($Table);
    if ($Join === NULL) {
    } else {
      foreach ($Join as $tablejoin) {
        if (isset($tablejoin['type'])) {
          $this->db->join($tablejoin['table'], $tablejoin['condition'], $tablejoin['type']);
        } else {
          $this->db->join($tablejoin['table'], $tablejoin['condition']);
        }
      }
    }
    if ($Condition != NULL) {
      $this->db->where($Condition);
    }
    if ($OrCondition != NULL) {
      $this->db->or_where($OrCondition);
    }
    if ($Order != NULL) {
      if (isset($Order['field']) && isset($Order['type'])) {
        $field = $Order['field'];
        $type  = $Order['type'];
        $this->db->order_by($field, $type);
      }
    }
    if ($GroupBy != NULL) {
      $this->db->group_by($GroupBy);
    }
    if ($Start === NULL) {
      $query = $this->db->get();
    } else {
      $this->db->limit($Limit, $Start);
      $query = $this->db->get();
    }
    return $query;
  }
  public function quizselect($Table, $Condition = NULL, $Data, $Order = NULL, $Limit = NULL, $Join = NULL)
  {
    $this->db->select($Data);
    $this->db->from($Table);
    if ($Join === NULL) {
      
    } else {
      foreach ($Join as $tablejoin) {
        if (isset($tablejoin['type'])) {
          $this->db->join($tablejoin['table'], $tablejoin['condition'], $tablejoin['type']);
        } else {
          $this->db->join($tablejoin['table'], $tablejoin['condition']);
        }
      }
    }
    if ($Condition != NULL) {
      $this->db->where($Condition);
    }
    $this->db->order_by($Order);
    $this->db->limit($Limit);
    $query = $this->db->get();
    return $query->result_array();
  }
  public function dbupdate($Table, $Data, $Condtion)
  {
    $this->db->where($Condtion);
    return $this->db->update($Table, $Data);
  }
  
  public function dbinsert($Table, $Data)
  {
    return $this->db->insert($Table, $Data);
  }
  public function dbdelete($Table, $Condition)
  {
    $query = $this->db->where($Condition);
    $query = $this->db->delete($Table);
    if ($query) {
      return true;
    } else {
      return false;
    }
  }
  public function customSelect($query)
  {
    $result = $this->db->query($query);
    return $result->result_array();
  }
  public function oneaddself($condition, $data, $table)
  {
    $this->db->set($data, $data . '+200', FALSE);
    $this->db->where($condition);
    return $this->db->update($table);
  }
  public function already_exists($Table, $Data)
  {
    $result = $this->db->get_where($Table, $Data);
    if (count($result->row_array()) > 0) {
      return true;
    } else {
      return false;
    }
  }
  public function unionQuery($queryArray)
  {
    if (!empty($queryArray) && is_array($queryArray)) {
      $query = "";
      $sno   = 0;
      echo $QueryCount = count($queryArray);
      foreach ($queryArray as $data) {
        $sno++;
        $query .= $data . " UNION ";
        
      }
      $query = substr($query, 0, strlen($query) - 7);
      
    }
    $result = $this->db->query($query);
    return $result->result_array();
  }
  public function oneupdateself($column, $value, $condition, $table)
  {
    $this->db->set($column, $column . '+ ' . $value, FALSE);
    $this->db->where($condition);
    return $this->db->update($table);
  }
  
  public function oneminusself($column, $value, $condition, $table)
  {
    $this->db->set($column, $column . '- ' . $value, FALSE);
    $this->db->where($condition);
    return $this->db->update($table);
  }  
}
?>