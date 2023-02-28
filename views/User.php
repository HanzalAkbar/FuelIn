<?php
/*
 * Copyright (c) 2023. Hanzal Akbar
 */
session_start();

use Fuelin\DatabaseConnection;
use Fuelin\UserController;


include($_SERVER['DOCUMENT_ROOT'] . "/fuelin/database/DBConn.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/UserController.php");

$db = new DatabaseConnection;

if (isset($_POST['login'])) {

    $user = new UserController;

    $username = $user->escape_string($_POST['username']);
    $password = $user->escape_string($_POST['password']);


    $auth = $user->check_login($username, $password);

    if (!$auth) {
        $_SESSION['message'] = 'Invalid username or password';
    } else {
        $_SESSION['user'] = $auth[0];
        $_SESSION['station'] = $auth[1];
        $_SESSION['id'] = $auth[2];
    }
//    header('http://localhost/fuelin');
    header('location: http://localhost/fuelin');
}

if (isset($_POST['saveUser'])) {

    if (!isset($_SESSION['user'])) {
        header('location: http://localhost/fuelin');
    }

    $inputData = [
        'category' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['category']),
        'email' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['email']),
        'username' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['username']),
        'password' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['password']),
        'fillingstationid' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['fillingstationid']),
    ];

    $user = new UserController;
    $result = $user->create($inputData);

    if ($result) {
        $_SESSION['message'] = "User Added Successfully";
    } else {
        $_SESSION['message'] = "User Not Added";
    }
    header("Location:  http://localhost/fuelin");
    exit(0);
}

if (isset($_POST['updateUser'])) {

    if (!isset($_SESSION['user'])) {
        header('location: http://localhost/fuelin');
    }

    $id = mysqli_real_escape_string($db->conn, $_POST['user_id']);
    $inputData = [
        'category' => mysqli_real_escape_string($db->conn, $_POST['category']),
        'email' => mysqli_real_escape_string($db->conn, $_POST['email']),
        'username' => mysqli_real_escape_string($db->conn, $_POST['username']),
        'password' => mysqli_real_escape_string($db->conn, $_POST['password']),
        'fillingstationid' => mysqli_real_escape_string($db->conn, $_POST['fillingstationid']),
    ];
    $user = new UserController;
    $result = $user->update($inputData, $id);

    if ($result) {
        $_SESSION['message'] = "User Updated Successfully";
    } else {
        $_SESSION['message'] = "User Not Updated";
    }
    header("Location: user\User-view.php");
    exit(0);
}

if (isset($_POST['deleteUser'])) {

    if (!isset($_SESSION['user'])) {
        header('location: http://localhost/fuelin');
    }

    $id = mysqli_real_escape_string($db->conn, $_POST['deleteUser']);
    $user = new UserController;
    $result = $user->delete($id);
    if ($result) {
        $_SESSION['message'] = "User Deleted Successfully";
    } else {
        $_SESSION['message'] = "User Not Deleted";
    }
    header("Location: user\User-view.php");
    exit(0);
}