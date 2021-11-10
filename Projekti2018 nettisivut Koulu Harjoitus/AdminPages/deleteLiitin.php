<html lang="en">
<head>
  <title>Vertailutyökalu - Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   
   <!-- Latest compiled and minified Bootstrap JavaScript 
   https://www.codeofaninja.com/2011/12/php-and-mysql-crud-tutorial.html
   -->
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<?php
session_start();
require('loginCheck.php');
testaaLogin();

$servername = "mysql.cc.puv.fi";
$username = "e1701247";
$password = "RTySaR9anuqv";
$dbname = "e1701247_vertailu";


if (isset($_GET["GPU_ID"]) && isset($_GET["LiitinID"]))
{
    $GPU_ID =  $_GET["GPU_ID"];
    $LiitinID =  $_GET["LiitinID"];
   
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
    $sql = "DELETE FROM Naytonliittimet WHERE GPU_ID=$GPU_ID AND LiitinID=$LiitinID";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "<div class='alert alert-success'> <strong>OK </strong> Poisto onnistui</div>";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?> 

<form>
    <table class='table table-hover table-responsive table-bordered'>
            <td>
                <a href="Naytonliittimet.php?ID=<?php echo $GPU_ID; ?>&Return=newGPU" class='btn btn-info'>Takaisin Edelliselle Sivulle</a>
            </td>
        </tr>
    </table>
</form>

</body>
</html