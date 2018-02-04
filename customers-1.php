    <?php
/*$pdo = new PDO('mysql:host=localhost;dbname=milletech_invoice', 'root', 'root', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);
*/
    require "db.php";
// Lösning 1: Jag gör inte hela :P

$customers = $pdo->query('
	SELECT customers.*,
	order_addresses.id AS address_id,
	order_addresses.city AS address_city,
	order_addresses.company AS address_company
	FROM customers
	LEFT JOIN order_addresses ON customers.id = order_addresses.customer_id
	GROUP BY customers.id
	')->fetchAll();
foreach ($customers as $index => $customer) {
	// $index = 0 på första varvet, sedan 1 osv
	// Vi utnyttjar $index för att manipulera arrayen som vi går igenom
	$customers[$index]['address'] = [];
	// Vi loopar över de enskilda fälten som finns på $customer
	// $key kommer att vara: id, created_at, address_id, address_city, address_company osv
	foreach ($customer as $key => $value) {
		if (strpos($key, 'address') !== false) {
			$customers[$index]['address'][$key] = $value;
			unset($customers[$index][$key]);
		}
	}
}
header("Content-Type: application/json");
echo json_encode($customers);
die();
/*
// Lösning 2: array_filter
$customers = $pdo->query('SELECT * FROM customers')->fetchAll();
// Jag grupperar på customer_id för att få ut en adress/kund. Ni har bara en adress.
$addresses = $pdo->query('SELECT * FROM order_addresses GROUP BY customer_id')->fetchAll();
foreach ($customers as $index => $customer) {
	$address = array_filter($addresses, function($item) use ($customer) {
		// Om detta blir true så får vi tillbaka den adressen i vår array
		return $item['customer_id'] == $customer['id'];
	});
	if (count($address) > 0) {
		$customers[$index]['address'] = array_shift($address);
	}
}
header("Content-Type: application/json");
echo json_encode($customers);
die();
// Lösning 3: Hämta ut adress på varje kund
$customers = $pdo->query('SELECT * FROM customers')->fetchAll();
foreach ($customers as $index => $customer) {
	// Det här är N+1-problemet
	// 677 kunder då är N = 677
	// Varför +1? Därför att ni ställer först en fråga för att hämta era 677 rader
	$address = $pdo->query('SELECT * FROM order_addresses WHERE customer_id = '.$customer['id'])->fetch();
	if ($address != null) {
		$customers[$index]['address'] = $address;
	}
}
header("Content-Type: application/json");
echo json_encode($customers);
die();
*/
// Lösning 4: Vänd på en array och gör den till ett index/uppslagsverk
/*$customers = $pdo->query('SELECT * FROM customers')->fetchAll();
$addresses = $pdo->query('SELECT * FROM order_addresses GROUP BY customer_id')->fetchAll();
$address_index = [];
foreach ($addresses as $address) {
    $address_index[$address['customer_id']] = $address;
}
foreach ($customers as $index => $customer) {
    if (isset($address_index[$customer['id']])) {
        $customers[$index]['address'] = $address_index[$customer['id']];
    }
}
header("Content-Type: application/json");
echo json_encode($customers);*/