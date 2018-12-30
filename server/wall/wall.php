<?php
require_once 'DbConnection.php';
require_once 'ListNews.php';

$db = new DbConnection();
$model = new ListNews($db);

if (isset($_GET['listNewsOffset']) && is_numeric($_GET['listNewsOffset'])){
    $offset = (int)$_GET['listNewsOffset'];
}

$data = $model->getData($offset);
echo json_encode($data);