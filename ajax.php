<?php
ob_start();
date_default_timezone_set("Asia/Manila");

$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
    $login = $crud->login();
    if($login)
        echo $login;
}
if($action == 'login2'){
    $login = $crud->login2();
    if($login)
        echo $login;
}
if($action == 'logout'){
    $logout = $crud->logout();
    if($logout)
        echo $logout;
}
if($action == 'logout2'){
    $logout = $crud->logout2();
    if($logout)
        echo $logout;
}

if($action == 'signup'){
    $save = $crud->signup();
    if($save)
        echo $save;
}
if($action == 'save_user'){
    $save = $crud->save_user();
    if($save)
        echo $save;
}
if($action == 'update_user'){
    $save = $crud->update_user();
    if($save)
        echo $save;
}
if($action == 'delete_user'){
    $save = $crud->delete_user();
    if($save)
        echo $save;
}
if($action == 'save_document'){
    $save = $crud->save_document();
    if($save)
        echo $save;
}
if($action == 'save_ticket'){
    $save = $crud->save_ticket();
    if($save)
        echo $save;
}
if($action == 'delete_document'){
    $save = $crud->delete_document();
    if($save)
        echo $save;
}
if($action == 'delete_ticket'){
    $save = $crud->delete_ticket();
    if($save)
        echo $save;
}
if($action == 'save_task'){
    $save = $crud->save_task();
    if($save)
        echo $save;
}
if($action == 'delete_task'){
    $save = $crud->delete_task();
    if($save)
        echo $save;
}
if($action == 'save_progress'){
    $save = $crud->save_progress();
    if($save)
        echo $save;
}
if($action == 'delete_progress'){
    $save = $crud->delete_progress();
    if($save)
        echo $save;
}
if($action == 'get_report'){
    $get = $crud->get_report();
    if($get)
        echo $get;
}
if($action == 'change_active_user'){
    $get = $crud->change_active_user();
    if($get)
        echo $get;
}
ob_end_flush();
?>
