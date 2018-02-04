<?php
$pdo = new PDO('mysql:host=localhost;dbname=Milletech', 'root', 'root', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);
$customerId = (int)$_GET['customer_id'];
$address = (isset($_GET['address']) && $_GET['address'] == "true");
$status = 404;
$response = ["message" => "Address not found"];
if ($address) {
    $stmt = $pdo->prepare('SELECT * FROM order_addresses WHERE customer_id = :id GROUP BY customer_id');
    $stmt->execute([':id' => $customerId]);
    if ($stmt->rowCount() > 0) {
        $response = $stmt->fetch();
        $status = 200;
    }
}
//header("Content-Type: application/json", true, $status);
echo json_encode($response);