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


    var chatinput = document.getElementById("search").value;
if (chatinput.length > 0)
{
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
}
else {
  $("#show_up").hide();
}
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
        <input type="text" class="form-control" autocomplete="off" placeholder="Search CPU or GPU" name="names" id="search" />
      </div>
      <div id="show_up"></div>
    </form>
    <ul class="nav navbar-nav navbar-right">
      <?php julkinenTest();?>
    </ul>
  </div>
</nav>

<div class="container">

<h1>News</h1>
<br>
<br>

<?php
  include 'AdminPages/logininfo.php';

  $sqlLause = "SELECT Otsikko, Teksti, disp_name, blogiID
  from Blogi
  INNER JOIN Admins ON Admins.AdminID = Blogi.Admin
  ORDER BY blogiID DESC;";


  $komento = $yhteys->prepare($sqlLause);
  $komento->execute();

  // palautettujen rivien lukumäärä saadaan näin
  $num = $komento->rowCount();

  //check if more than 0 record found
  if($num>0){

  // haetaan kaikki osastot
  // fetch() on nopeampi kuin fetchAll()


  while ($rivi = $komento->fetch(PDO::FETCH_ASSOC)){
  // extract muuttaa
  //  $rivi['osnimi'] taulukosta alkiot vastaaviin muuttujiin $osnimi 
  extract($rivi);

  // tehdään jokaisesta osastotaulun rivistä oma rivi tauluun
 echo "<div class='jumbotron'>";
 echo "<h2 class='display-4'><b>{$Otsikko}</b></h2>";
 echo "<br>";
 echo "<p class='lead'>{$Teksti}</p>";
 echo "<hr class='my-4'>";
 echo "<p> -{$disp_name}</p>";
 echo "</div>";
 echo "<br>";
 echo "<br>";
  }
  }

  // jos ei löytynyt yhtään
  else{
  echo "<div class='alert alert-danger'>Cannot find any records.</div>";
  }
  ?>

</div>

</body>
</html> 