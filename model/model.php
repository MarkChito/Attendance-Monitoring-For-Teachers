<?php
class Model
{
    private $hostname;
    private $username;
    private $password;
    private $database;
    private $conn;

    public function __construct($hostname, $username, $password, $database)
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);
    }

    private function insert($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    private function update($table, $data, $condition)
    {
        $setValues = '';
        foreach ($data as $key => $value) {
            $setValues .= "$key = '$value', ";
        }
        $setValues = rtrim($setValues, ', ');

        $sql = "UPDATE $table SET $setValues WHERE $condition";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    private function delete($table, $condition)
    {
        $sql = "DELETE FROM $table WHERE $condition";

        if ($this->conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    private function selectFrom($table, $condition)
    {
        $sql = "SELECT * FROM $table WHERE $condition";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    private function selectAll($table)
    {
        $sql = "SELECT * FROM $table";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function MOD_DATABASE_CONNECTED()
    {
        return $this->conn ? true : false;
    }

    public function MOD_ADD_TEACHER($teacher_id, $name, $password, $user_type)
    {
        $data = array(
            "teacher_id" => $teacher_id,
            "name" => $name,
            "password" => $password,
            "user_type" => $user_type,
        );

        return $this->insert("tbl_teachermonitoring_useraccounts", $data);
    }

    public function MOD_GET_TEACHER_DETAILS_BY_TEACHER_ID($teacher_id)
    {
        return $this->selectFrom("tbl_teachermonitoring_useraccounts", "teacher_id = '" . $teacher_id . "'");
    }

    public function MOD_GET_ATTENDANCE($teacher_id)
    {
        return $this->selectFrom("tbl_teachermonitoring_attencance", "teacher_id = '" . $teacher_id . "'");
    }
    
    public function MOD_GET_ALL_ATTENDANCE()
    {
        return $this->selectAll("tbl_teachermonitoring_attencance");
    }

    public function MOD_GET_ATTENDANCE_TODAY($teacher_id, $date_today)
    {
        return $this->selectFrom("tbl_teachermonitoring_attencance", "`teacher_id` = '" . $teacher_id . "' AND `date_created` = '" . $date_today . "'");
    }

    public function MOD_ADD_ATTENDANCE($teacher_id, $date_today, $current_time, $status)
    {
        $data = array(
            "teacher_id" => $teacher_id,
            "date_created" => $date_today,
            "time_in" => $current_time,
            "status" => $status,
        );

        return $this->insert("tbl_teachermonitoring_attencance", $data);
    }

    public function MOD_UPDATE_ATTENDANCE($teacher_id, $date_today, $current_time, $status)
    {
        $data = array(
            "time_out" => $current_time,
            "status" => $status,
        );

        $condition = "`teacher_id` = '" . $teacher_id . "' AND `date_created` = '" . $date_today . "'";

        return $this->update("tbl_teachermonitoring_attencance", $data, $condition);
    }
}
