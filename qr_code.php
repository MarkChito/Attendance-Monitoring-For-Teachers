<?php
require_once "model/model.php";

$model = new Model("localhost", "root", "", "all_system_database");

include_once "views/qr_code_view.php";