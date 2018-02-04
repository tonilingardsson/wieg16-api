<?php
/**
 * Created by PhpStorm.
 * User: lingardssonluna
 * Date: 2017-11-23
 * Time: 16:38
 * THIS FILE WORKS!
 */
require "db.php";

$companies = [];


$sql = "SELECT * FROM customers";
$stn = $pdo->query($sql);
$stn->execute();
$customers = $stn->fetchAll();
    foreach ($customers as $customer) {
    $companies[] = $customer['customer_company'];
    }

    $companies = array_unique($companies);

    foreach($companies as $company) {
    $sql = "SELECT * FROM companies WHERE company_name = '$company'";
    $result = $pdo->query($sql);
    if($result->rowCount() == 0) {
    $sql = "INSERT INTO companies (company_name) VALUES ('$company')";
    $pdo->query($sql);
    }
    
    }

$sql = "SELECT * FROM companies";
$stn = $pdo->query($sql);
$dbCompanies = $result->fetchAll(PDO::FETCH_ASSOC);

foreach ($dbCompanies as $dbCompany) {
    $sql = "UPDATE customers SET company_id = ".$dbCompany['id']." WHERE customer_company = '".$dbCompany['company_name']."'";
    $pdo->query($sql);
}
header("Content-Type: application/json");
echo json_encode($companies);