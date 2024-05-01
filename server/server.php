<?php
date_default_timezone_set("Asia/Manila");

require_once "model/model.php";

$model = new Model("localhost", "root", "", "all_system_database");

if (isset($_POST["check_connection"])) {
    if ($model->MOD_DATABASE_CONNECTED()) {
        $response = array(
            "status" => 200,
            "message" => "Database is connected.",
        );
    } else {
        $response = array(
            "status" => 500,
            "message" => "Can't connect to the database.",
        );
    }

    echo json_encode($response);
}

if (isset($_POST["add_teacher"])) {
    $teacher_id = $_POST["teacher_id"];
    $name = $_POST["name"];
    $password = $_POST["password"];
    $user_type = "teacher";

    if (!$model->MOD_GET_TEACHER_DETAILS_BY_TEACHER_ID($teacher_id)) {
        if ($model->MOD_ADD_TEACHER($teacher_id, $name, password_hash($password, PASSWORD_BCRYPT), $user_type)) {
            $response = array(
                "status" => 200,
                "message" => "Data has been saved to the database.",
            );
        } else {
            $response = array(
                "status" => 500,
                "message" => "There was a problem while processing your request.",
            );
        }
    } else {
        $response = array(
            "status" => 500,
            "message" => "Teacher ID is already in use.",
        );
    }

    echo json_encode($response);
}

if (isset($_POST["login_teacher"])) {
    $teacher_id = $_POST["teacher_id"];
    $password = $_POST["password"];

    $teacher_data = $model->MOD_GET_TEACHER_DETAILS_BY_TEACHER_ID($teacher_id);

    $response = array(
        "status" => 404,
        "message" => "Invalid Teacher ID or Password!",
    );

    if ($teacher_data) {
        foreach ($teacher_data as $row) {
            $hash = $row["password"];
        }

        if (password_verify($password, $hash)) {
            $response = $response = array(
                "status" => 200,
                "message" => "OK",
            );
        }
    }

    echo json_encode($response);
}

if (isset($_POST["check_attendance"])) {
    $teacher_id = $_POST["teacher_id"];
    $date_today = date("m/d/Y");
    $current_time = date("h:i a");

    $teacher_data = $model->MOD_GET_TEACHER_DETAILS_BY_TEACHER_ID($teacher_id);
    if ($teacher_data) {
        foreach ($teacher_data as $teacher_data_row) {
            $db_teacher_name = $teacher_data_row["name"];
        }

        $attendance_data = $model->MOD_GET_ATTENDANCE_TODAY($teacher_id, $date_today);

        if ($attendance_data) {
            foreach ($attendance_data as $row) {
                $db_time_in = $row["time_in"];
                $db_status = $row["status"];
            }

            if ($db_status == "Out") {
                $response = array(
                    "status" => 500,
                    "message" => "You have already taken your attendance today!",
                );
            } else {
                if ($model->MOD_UPDATE_ATTENDANCE($teacher_id, $date_today, $current_time, "Out")) {
                    $response = array(
                        "status" => 200,
                        "message" => "Attendance is successfully recorded.",
                        "teacher_name" => $db_teacher_name,
                        "time_in" => $db_time_in,
                        "time_out" => $current_time,
                        "attendance_status" => "Out",
                    );
                } else {
                    $response = array(
                        "status" => 500,
                        "message" => "There is an error while processing your request.",
                    );
                }
            }
        } else {
            if ($model->MOD_ADD_ATTENDANCE($teacher_id, $date_today, $current_time, "In")) {
                $response = array(
                    "status" => 200,
                    "message" => "Attendance is successfully recorded.",
                    "teacher_name" => $db_teacher_name,
                    "time_in" => $current_time,
                    "time_out" => "Not Yet Available",
                    "attendance_status" => "In",
                );
            } else {
                $response = array(
                    "status" => 500,
                    "message" => "There is an error while processing your request.",
                );
            }
        }
    } else {
        $response = array(
            "status" => 404,
            "message" => "Invalid Teacher ID!",
        );
    }

    echo json_encode($response);
}
