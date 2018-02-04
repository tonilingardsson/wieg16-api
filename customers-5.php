<?php
$pdo = new PDO('mysql:host=localhost;dbname=milletech_invoice', 'root', 'root', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);
$customers = $pdo->query("SELECT * FROM customers")->fetchAll();
$customer_companies = [];
foreach ($customers as $customer) {
    $customer_companies[] = $customer['customer_company'];
}
foreach ($customer_companies as $customer_company) {
    $result = $pdo->query('SELECT id FROM customer_companies WHERE title = '.$customer_company);
    if ($result->rowCount() == 0) {
        $result = $pdo->prepare("INSERT INTO customer_companies (title) VALUES ('$customer_company')")->execute();
        if ($result == true) {
            $company_id = $pdo->lastInsertId();
            $pdo->query("UPDATE customers SET customer_company_id = $company_id WHERE customer_company = '$customer_company'");
        }
    }
}
//header("Content-Type: application/json", true, 200);
//echo json_encode($customer_companies);