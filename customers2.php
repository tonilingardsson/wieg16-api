<?php
require "db.php";

$customerId = (int)$_GET ['customer_id'];

$sql = 'SELECT * FROM customers WHERE id = .$id';
$stn = $pdo->query($sql);
$stn->execute([':id' => $customerId]);
$customers = $stn->fetch();
$status = 200;
if ($response == null) {
    $status = 404;
    $response = ["message" => "Customer not found"];
}

/* MADE WITH KIM. ABOVE Solution following Marcus files
foreach ($customers as $key => $customer){
    $sql = "SELECT * FROM address WHERE customer_id = ".$customers['id'];
    $query = $pdo->query($sql);
    $address = $query->fetch();
    if ($address != null){
        $customers [$key]['$address'] = $address;
    }
}
*/
header("Content-Type: application/json");
echo json_encode($customers);
