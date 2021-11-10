<?php
$servername = "mysql.cc.puv.fi";
$username = "e1701247";
$password = "RTySaR9anuqv";
$dbname = "e1701247_vertailu";

echo "hello";
if (isset($_GET["poistTaulu"]) && isset($_GET["poistID"]))
{
     $poistTaulu= $_GET["poistTaulu"];
     $poistID = $_GET["poistID"];
}
else
{
    die('ERROR: Osastoa ei löydy.');
}


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to delete a record
    $sql = "DELETE FROM $poistTaulu WHERE id=$poistID";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Record deleted successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;

?> 