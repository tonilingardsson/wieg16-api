<?php
/**
 * Created by PhpStorm.
 * User: lingardssonluna
 * Date: 2017-11-23
 * Time: 16:20
 * THIS FILE WORKS!
 */
require "db.php";

$customerId = $_GET['customer_id'];

$sql = "SELECT street, postcode, city FROM address WHERE customer_id = ".$customerId;
$stn = $pdo->query($sql);
$stn->execute();
$customer = $stn->fetch();

header("Content-Type: application/json");

if ($customer != null){

    echo json_encode($customer);
}

else {
    header("HTTP/1.0 404 not found!");
    echo json_encode(["message" => "Customer not found."]);
}
