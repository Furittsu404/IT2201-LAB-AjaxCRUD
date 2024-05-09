<?php
class Database
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function executeQuery($sql)
    {
        $result = $this->conn->query($sql);
        $data = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data_row = array();
                foreach ($row as $r) {
                    array_push($data_row, $r);
                }
                array_push($data, $data_row);
            }
        }
        return $data;
    }

    public function updateRecord($data, $table, $id)
    {
        $update = "";
        foreach ($data as $key => $value) {
            $update .= $key . "='" . $value . "',";
        }
        $update = substr($update, 0, -1);
        $primary_key = array_keys($id)[0];
        $key_value = $id[$primary_key];
        $sql = "UPDATE $table SET {$update} WHERE $primary_key = $key_value";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function deleteRecord($table, $id)
    {
        $primary_key = array_keys($id)[0];
        $key_value = $id[$primary_key];
        $sql = "DELETE FROM $table WHERE $primary_key = $key_value";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function showRecords($table, $condition = null)
    {
        $sql = "Select * from $table";
        if ($condition != null) {
            $sql .= " $condition";
        }
        return $this->executeQuery($sql);
    }

    public function showAll($table)
    {
        $sql = "Select * from $table";
        return $this->executeQuery($sql);
    }

    public function addRecord($data, $table)
    {
        $tbl_columns = implode(",", array_keys($data));
        $tbl_values = implode("','", $data);
        $sql = "INSERT INTO $table($tbl_columns) VALUES ('$tbl_values')";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function pagination($identifier, $recordsPerPage, $table, $condition = null)
    {
        $sql = "SELECT COUNT($identifier) as count FROM $table";
        if ($condition !== null) {
            $sql .= " $condition";
        }
        $totalRecordsResult = $this->conn->query($sql);
        $totalRecords = $totalRecordsResult->fetch_assoc()['count'];
        $totalPages = ceil($totalRecords / $recordsPerPage);
        return $totalPages;
    }

    public function verifyEmail($email, $id = null)
    {
        if ($id == null) {
            $user = "SELECT user_Email FROM userlogin WHERE user_Email = '$email'";
            $admin = "SELECT admin_Email FROM adminlogin WHERE admin_Email = '$email'";
            $shop = "SELECT shop_Email FROM shoplogin WHERE shop_Email = '$email'";
        } else {
            $user = "SELECT user_Email FROM userlogin WHERE user_Email = '$email' AND user_ID != $id";
            $admin = "SELECT admin_Email FROM adminlogin WHERE admin_Email = '$email' AND admin_ID != $id";
            $shop = "SELECT shop_Email FROM shoplogin WHERE shop_Email = '$email' AND shop_ID != $id";
        }
        $sql = "($user) UNION ($admin) UNION ($shop)";
        $result = $this->conn->query($sql);
        return $result->num_rows;
    }

}
