<?php
require_once 'DbConnection.php';
require_once 'Model.php';

$db = new DbConnection();
$model = new Model($db);

if (isset($_GET['wallOffset']) && is_numeric($_GET['wallOffset'])){
    $offset = (int)$_GET['wallOffset'];
}

$data = $model->getData($offset);
echo json_encode($data);