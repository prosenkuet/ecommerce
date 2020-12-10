<?php

require_once __DIR__ . "/classes/myclassautoloader.php";
$pdoConnection = new DbConn();


$query = "SELECT * from (SELECT c.Name,count(ItemNumber) as `totalitem` FROM item_category_relations icr, category c where icr.categoryId = c.Id  group by categoryId) as tab order by tab.totalitem desc";


$stmt = $pdoConnection->conn->prepare($query);
$stmt->execute();

$tab = "<table border='1'><thead><tr><td>Category Name</td><td>Total Item</td></tr></thead><tbody>";
while ($row = $stmt->fetch()) {
    $tab .= "<tr><td>".$row["Name"]."</td><td>".$row["totalitem"]."</td></tr>";
    
}
$tab .= "</tbody></table>";

echo $tab;


?>
