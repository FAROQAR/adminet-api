<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of BaseModel
 *
 * @author nasywan
 */
class MBaseModel extends Model {

    //put your code here
    public function selectQueryPaging($sql, $limit, $offset) {
        $result = $this->db->query($sql . " limit $offset,$limit");
        $response['data'] = $result->getResultArray();
        $result->freeResult();

        $result = $this->db->query($sql);
        $response["record"] = $result->getNumRows();

        $result->freeResult();
        return $response;
    }

    public function selectQuery($sql) {
        $result = $this->db->query($sql);
        return $result;
    }

    public function selectAll($table) {
        $builder = $this->db->table($table);
        $result = $builder->get();
        return $result;
    }

    public function selectBuilder($table, $where) {
        $builder = $this->db->table($table);
        $builder->where($where);
        $result = $builder->get();
        return $result;
    }

    public function selectBuilderPaging($table, $where, $limit, $offset) {
        $builder = $this->db->table($table);
        if (is_array($where)) {
            $builder->where($where);
        } elseif (strlen($where) > 0) {
            $builder->where($where);
        }
        $builder->limit($limit, $offset);
        $rdata = $builder->get();
        $response['data'] = $rdata;

        $builder = $this->db->table($table);
        if (is_array($where)) {
            $builder->where($where);
        } elseif (strlen($where) > 0) {
            $builder->where($where);
        }
        $rcount = $builder->countAll();
        $response["record"] = $rcount;
        return $response;
    }

    public function updateBuild($table, $data, $where) {
        $this->db->table($table)->update($data, $where);
        $result = $this->db->affectedRows();
        return $result;
    }

    public function deleteBuild($table, $where) {
        $this->db->table($table)->delete($where);
        $result = $this->db->affectedRows();
        return $result;
    }

    public function deleteBuildIn($table, $whereField, $where) {
        $this->db->table($table)->whereIn($whereField, $where)->delete();
//        $this->db->whereIn($whereField, $where);
//        $this->db->delete();
        $result = $this->db->affectedRows();
        return $result;
    }

    public function insertBuild($table, $data) {
        $this->db->table($table)->insert($data);
        $result = $this->db->affectedRows();
        return $result;
    }

    public function insertBatchBuild($table, $data) {
        $this->db->table($table)->insertBatch($data);
        $result = $this->db->affectedRows();
        return $result;
    }

    public function callFunction($fname, $param = NULL) {
//         if (mysqli_more_results($this->db->conn_id)) {
//            mysqli_next_result($this->db->conn_id);
//        }
        $sql = "";
        $query = NULL;
        if ($param) {
            $genparam = join(',', array_fill(0, count($param), '?'));
            $sql = "select $fname($genparam) as retval";
            $query = $this->db->query($sql, $param);
        } else {
            $sql = "select $fname() as retval";
            $query = $this->db->query($sql);
        }

        $rows = array();
        $total = 0;
        if ($query->getNumRows() > 0) {
            $rows = $query->getRow();
            $total = $query->getNumRows();
        }
        $query->freeResult();
        return $rows->retval;
    }

    function SP_getData($spname, $param = NULL) {
//         if (mysqli_more_results($this->db->conn_id)) {
//            mysqli_next_result($this->db->conn_id);
//        }
        $sql = "";
        $query = NULL;
        if ($param) {
            $genparam = join(',', array_fill(0, count($param), '?'));
            $sql = "call $spname($genparam)";
            $query = $this->db->query($sql, $param);
        } else {
            $sql = "call $spname()";
            $query = $this->db->query($sql);
        }

        $rows = array();
        $total = 0;
        if ($query->getNumRows() > 0) {
            $rows = $query->getResult();
            $total = $query->getNumRows();
        }

//        $results = '{success:true,record:' . $total . ',data:' . json_encode($rows) . '}';
        $results = array('success' => true, 'record' => $total, 'data' => $rows);

        // $query->nextResult();
        $query->freeResult();
        return $results;
    }

    function SP_execData($spname, $param = NULL) {
//         if (mysqli_more_results($this->db->conn_id)) {
//            mysqli_next_result($this->db->conn_id);
//        }
        $sql = "";
        $query = NULL;
        if ($param) {
            $genparam = join(',', array_fill(0, count($param), '?'));
            $sql = "call $spname($genparam)";
            $query = $this->db->query($sql, $param);
        } else {
            $sql = "call $spname()";
            $query = $this->db->query($sql);
        }
        if ($query->getNumRows() > 0) {
            $rows = $query->getResult();
            $total = $query->getNumRows();
        }

//        $results = '{success:true,record:' . $total . ',data:' . json_encode($rows) . '}';
        $results = array('success' => true, 'record' => $total, 'data' => $rows);
        // $query->next_result();
        $query->freeResult();
        return  $results;
    }

}
