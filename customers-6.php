<?php
$pdo = new PDO('mysql:host=localhost;dbname=milletech_invoice', 'root', 'root', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);
$companyId = (int)$_GET['company_id'];
$stmt = $pdo->prepare('SELECT * FROM customers WHERE customer_company_id = :id');
$stmt->execute([':id' => $companyId]);
$response = $stmt->fetchAll();
$status = 200;
if (count($response) == 0) {
    $status = 404;
    $response = ["message" => "Customers not found"];
}
header("Content-Type: application/json", true, $status);
echo json_encode($response);