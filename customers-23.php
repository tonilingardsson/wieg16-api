<?php
/*$pdo = new PDO('mysql:host=localhost;dbname=Milletech', 'root', 'root', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);
*/
require "db.php";
$customerId = (int)$_GET['customer_id'];
$stmt = $pdo->prepare('SELECT * FROM customers WHERE id = :id');
$stmt->execute([':id' => $customerId]);
$response = $stmt->fetch();
$status = 200;
if ($response == null) {
    $status = 404;
    $response = ["message" => "Customer not found"];
}
header("Content-Type: application/json", true, $status);
echo json_encode($response);
