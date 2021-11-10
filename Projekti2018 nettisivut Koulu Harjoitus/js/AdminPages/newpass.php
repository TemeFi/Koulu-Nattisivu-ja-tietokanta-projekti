<html lang="en">
<head>
<!-- hakukentän tyylit -->
<style>
#show_up{
  display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    padding: 12px 16px;
    z-index: 1;
}
#show_up a{
	border-bottom: 1px solid #ddd;
	display: block;
	padding: 5px;
}
</style>
  <title>Vertailutyökalu</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
  <!-- Ajax hakukenttä -->
  <script>
$(document).ready(function(e){
	$("#search").keyup(function(){
		$("#show_up").show();
		var text = $(this).val();
		$.ajax({
			type: 'GET',
			url: 'search.php',
			data: 'txt=' + text,
			success: function(data){
				$("#show_up").html(data);
			}
		});
	})
});
</script>

</head>
<body>

<?php
session_start();
include('AdminPages/loginCheck.php');
?>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="etusivu.php"><img class="img-responsive" src="Logo.png" alt="Chania" width="150" height="150"> </a>
    </div>
    <ul class="nav navbar-nav">
    <li class="active"><a href="etusivu.php">Home</a></li>
      <li><a href="cpucomparison.php">Compare CPU's</a></li>
      <li><a href="gpucomparison.php">Compare GPU's</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Listed components <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="listCPU.php">CPU list</a></li>
          <li><a href="listGPU.php">GPU list</a></li>
        </ul>
      </li>
    </ul>
    <form class="navbar-form navbar-left">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Search CPU or GPU" name="names" id="search" />
      </div>
      <div id="show_up"></div>
    </form>
    <ul class="nav navbar-nav navbar-right">
    </ul>
  
    </div>
</nav>

<?php

if (isset($_GET['hash']))
{
  $key=$_GET['hash'];
}
else
{
    die('ERROR: Osastoa ei löydy.');
}

include 'logininfo.php';



function generateRandomString($length = 50) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}
$hash = generateRandomString();
// ensin ehto, joka varmistaa, että käyttäjä näkee ensin lomakkeen ja vasta sen jälkeen kun 
// lomakkeelta lähetetään tietoa, tapahtuu tämä php-koodi

	if($_POST){
        
    // include hakee yhteyden tietokantaan, jossa on osasto-taulu, yhteys-objektille on annettu nimi $yhteys

    try{
	  // tehdään insert eli tietorivin lisääminen tietokantaan
      // insert-kysely muodostetaan käyttäen nimettyjä parametreja
      // lisättävien tietojen sijalla	
      // alkuperäinen hash E06TpOK5foCDDRxgbspS
        
      $lisaysKomento = "UPDATE Admins SET pass = :tyyppi, hashi = '" . $hash . "' WHERE hashi = '" .  $key. "' ";

console.log( $lisaysKomento);

	  $sqlLause = $yhteys->prepare($lisaysKomento);
	  
	  // haetaan käyttäjän antamat tiedot ja putsataan ne laittomuuksista
	  $tyyppi = htmlspecialchars(strip_tags($_POST["tyyppi"]));
	  
	  // laitetaan käyttäjän antamat tiedot nimettyjen parametrien tilalle
    $sqlLause->bindParam(':tyyppi', $tyyppi);
    
	  
	  // suorita kysely käyttäjän antamilla tiedoilla
	   if ($sqlLause->execute()){
      echo "<div class='alert alert-success'>Salasana muutettu.</div>";
      header('refresh: 3; url=adminlogin.php'); // redirect the user after 10 seconds

    } else {
      echo "<div class='alert alert-danger'>Salasanaa ei muutettu.</div>";
    }
    }
     
    // show error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>



<div>
<!-- html form - kutsuu itseään, eli php-koodi on tässä samassa tiedostossa tuossa yläpuolella -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?hash=' . $hash;?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Uusi Salasana</td>
            <td><input type='text'autocomplete='off' name='tyyppi' class='form-control' /></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <input type='submit' value='Päivitä salasana' class='btn btn-primary' />
                     
            </td>
        </tr>
    </table>
</form>

          
 </div> <!-- end .container -->

</body>
</html> 