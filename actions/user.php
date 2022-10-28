<?php

include '../env.php';
include '../dbFunctions.php';

// POST Requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $action = $_POST['action'];

  // create brand
  if ($action == 'add') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $hits = $_POST['hits'];
    $status = 1;
    $token = $database->generateRandomString(10);
    $password = password_hash($token, PASSWORD_DEFAULT);

    $columns = ['name', 'email', 'hits', 'status', 'token', 'password'];
    $values = [$name, $email, $hits, $status, $token, $password];
    $database->insertTbl('user', $columns, $values);
  }
}

header('location: '.appURL.'user.php');