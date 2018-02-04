# Övningar för Lektion 3: API:er
## Övning 1
Nu är det dags att börja exponera den data
som du hämtat hem i lektion 2 övning 3.
Gör en fil som heter customers.php som skriver ut all data
från tabellen/tabellerna i json-format på skärmen.
Skicka lämplig header för att visa att det är json-data du
skickar och inte vanlig html.

1. Du ska skriva ut datan som du sparade från dina tabeller, inte hämta hem den igen.
2. Koppla upp dig mot din databas med PDO.
3. Hämta datan med lämplig SQL-sats.
4. Utmaning: Datan skall se likadan ut när du skriver ut den som den gör när den hämtas från API:et.
5. Alltså: Adressen skall ligga med på kunden.
6. Du kan lösa det på tre olika sätt:
    1. Göra en stor JOIN i din SQL och separera ut kolumnerna. Om två olika tabeller har samma kolumnnamn så skriver värdena över varandra.
    2. Hämta ut alla adresser separat med ett eget query och sedan para ihop dem med respektive kund.
    Eftersom adressen har customer_id så kan ni matcha på det. Titta på tex array_filter för att filtrera ut rätt adress.
    3. Hämta ut varje adress för sig när du loopar igenom kunderna. Gör en SELECT på customer_id.

## Övning 2
Bygg vidare så att man kan hämta ut en kund i taget.
Genom att ange en GET-parameter (förslagsvis customer_id) så skall man
kunna få ut en enskild kund.
Exempel på url: http://wieg16-api.dev/customers.php?customer_id=1
Denna url skall då visa mig kunden med id 1 i json-format.

1. Du har redan löst 95% av den här uppgiften redan.
2. Uppdatera din SQL så att du gör en WHERE id = ...

## Övning 3
Det kan vara så att man skriver ett customer_id som inte finns.
Skriv kod som hanterar att du inte får någon träff i databasen.
En http statuskod på 404 måste skickas och ett lämpligt
meddelande i json skall skrivas ut.
Exempel {"message": "Customer not found"}

1. Ta reda på hur många rader du fick ut från databasen.
2. Om du fick 0 rader så skall du skriva ut felmeddelandet.
3. Felmeddelandet skrivs lättast ut genom json_encode(["message" => "Customer not found"])
4. Glöm inte att skicka headers med funktionen header.

## Övning 4
Skriv kod för att enbart visa kundens adress.
Exempel på url: http://wieg16-api.dev/customers.php?customer_id=1&address=true
Då skall adressen för kunden med id 1 skrivas ut på skärmen i json-format.

1. Gör en if-sats för om $_GET['address'] är satt och = true.
2. Hämta adress från databasen baserat på customer_id.
3. Skriv ut adressen på skärmen.
4. Visa felmeddelande om adressen inte finns.

## Övning 5
Datan som du hämtat hem tidigare är lite dåligt strukturerad.
Det har visat sig att vi har behov av att veta vilka kunder som tillhör samma företag.
Skapa en separat tabell för företagen (förslagsvis companies) och
koppla ihop den tabellen med din customers-tabell.
Skriv sedan kod som går igenom datan och plockar ut företagsnamnen.
Företagsnamnen lagras sedan i den nya separata tabellen och
kunder med detta företagsnamn skall få samma company_id.

1. Lägg till company_id i customers-tabellen. Eller vad du nu döpt tabellen till.
2. Gör en ny tabell för companies som innehåller company_name och id. Id kan vara autoincrement och ska vara primary key.
3. Hämta ut alla customers så att du har dem i en lista.
4. Gör en tom lista för att lagra alla companies. $companies = [];
5. Loopa igenom dina kunder och samla på dig companies. $companies[] = $customer['customer_company']
6. När loopen är klar så kör du array_unique på $companies. Nu har du en lista med alla företag utan dubletter.
7. Loopa igenom $companies och stoppa in dem i $companies-tabellen.
8. Hämta ut företagen igen från databasen för att få ut dem i en lista med sina id:n.
9. Loopa igenom företagen som du hämtat ut med en foreach.
10. I loopen så kan du uppdatera customers-tabellen genom att göra en UPDATE customers SET company_id = x WHERE customer_company = y.

## Övning 6
Utöka din customers.php så att man kan hämta kunder baserat på company_id.
Om company_id anges så skall alla kunder med detta id visas.
Exempel på url: http://wieg16-api.dev/customers.php?company_id=1
Denna url skall då visa mig alla kunder med company_id 1 i json-format.

1. Samma princip som övning 2.
2. Gör helt enkelt en ny WHERE baserat på company_id istället för customer_id.