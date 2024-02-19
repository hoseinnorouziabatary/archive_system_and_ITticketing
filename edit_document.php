<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM documents where document_id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
	$id = $_GET['id'];
}
include 'new_document.php';
?>