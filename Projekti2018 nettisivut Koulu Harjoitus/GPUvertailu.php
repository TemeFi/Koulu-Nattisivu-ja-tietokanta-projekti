<html lang="en">
<head>



  <title>Vertailutyökalu - GPU comparison</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
<!-- kaaviot -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
      
      <?php

include 'AdminPages/logininfo.php';

$key1=$_GET['GPU1'];
$key2=$_GET['GPU2']; // Vaihda tähän GPU2

//HAE GPU 1

$sqlLause = "SELECT GPURating AS GPURating1, ValmistajaNimi AS ValmistajaNimi1, MerkkiNimi AS MerkkiNimi1, SarjaNimi AS SarjaNimi1, MalliNimi AS MalliNimi1, CUDA_STREAM AS CUDA_STREAM1, GDDR AS GDDR1, GPUKellotaajuusBASE AS GPUKellotaajuusBASE1, GPUKellotaajuusBOOST AS GPUKellotaajuusBOOST1, GPUMEMKapasiteetti AS GPUMEMKapasiteetti1, GPUMEMKellotaajuus AS GPUMEMKellotaajuus1, Korkeus AS Korkeus1, Leveys AS Leveys1, MaxPystyReso AS MaxPystyReso1, MaxVaakaReso AS MaxVaakaReso1, Pituus AS Pituus1 

FROM TeknisetGPU 

INNER JOIN Sarja ON Sarja.SarjaID = TeknisetGPU.SarjaID  

INNER JOIN Valmistaja ON Valmistaja.ValmistajaID = TeknisetGPU.ValmistajaID  

INNER JOIN Merkki ON Merkki.MerkkiID = TeknisetGPU.MerkkiID  

INNER JOIN Malli ON Malli.MalliID = TeknisetGPU.MalliID

WHERE GPU_ID = $key1;";



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
}
}


//HAE GPU 2

$sqlLause = "SELECT GPURating AS GPURating2, ValmistajaNimi AS ValmistajaNimi2, MerkkiNimi AS MerkkiNimi2, SarjaNimi AS SarjaNimi2, MalliNimi AS MalliNimi2, CUDA_STREAM AS CUDA_STREAM2, GDDR AS GDDR2, GPUKellotaajuusBASE AS GPUKellotaajuusBASE2, GPUKellotaajuusBOOST AS GPUKellotaajuusBOOST2, GPUMEMKapasiteetti AS GPUMEMKapasiteetti2, GPUMEMKellotaajuus AS GPUMEMKellotaajuus2, Korkeus AS Korkeus2, Leveys AS Leveys2, MaxPystyReso AS MaxPystyReso2, MaxVaakaReso AS MaxVaakaReso2, Pituus AS Pituus2 

FROM TeknisetGPU 

INNER JOIN Sarja ON Sarja.SarjaID = TeknisetGPU.SarjaID  

INNER JOIN Valmistaja ON Valmistaja.ValmistajaID = TeknisetGPU.ValmistajaID  

INNER JOIN Merkki ON Merkki.MerkkiID = TeknisetGPU.MerkkiID  

INNER JOIN Malli ON Malli.MalliID = TeknisetGPU.MalliID

WHERE GPU_ID = $key2;";



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
}
}

$GPUKellotaajuusBASE1 = $GPUKellotaajuusBASE1/1000;
$GPUKellotaajuusBASE2 = $GPUKellotaajuusBASE2/1000;
$GPUKellotaajuusBOOST1 = $GPUKellotaajuusBOOST1/1000;
$GPUKellotaajuusBOOST2 = $GPUKellotaajuusBOOST2/1000;
$GPUMEMKellotaajuus1 = $GPUMEMKellotaajuus1/1000;
$GPUMEMKellotaajuus2 = $GPUMEMKellotaajuus2/1000;

      ?>


      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          [' ', '<?php echo $ValmistajaNimi1 . " " . $MerkkiNimi1 . " " . $SarjaNimi1 . " ". $MalliNimi1 ?>', '<?php echo $ValmistajaNimi2 . " " . $MerkkiNimi2 . " " . $SarjaNimi2 . " " . $MalliNimi2 ?>'],
          ['CUDA / Stream', <?php echo $CUDA_STREAM1; ?>, <?php echo $CUDA_STREAM2; ?>],
          ['GDDR', <?php echo $GDDR1; ?>, <?php echo $GDDR2; ?>],
          ['Kellotaajuus', <?php echo $GPUKellotaajuusBASE1; ?>, <?php echo $GPUKellotaajuusBASE2; ?>],
          ['Maksimi kellotaajuus', <?php echo $GPUKellotaajuusBOOST1; ?>, <?php echo $GPUKellotaajuusBOOST2; ?>],
          ['Muistin kapasiteetti', <?php echo $GPUMEMKapasiteetti1; ?>, <?php echo $GPUMEMKapasiteetti2; ?>],
          ['Muistin kellotaajuus', <?php echo $GPUMEMKellotaajuus1; ?>, <?php echo $GPUMEMKellotaajuus2; ?>],
          ['Maksimi pystyresoluutio', <?php echo $MaxPystyReso1; ?>, <?php echo $MaxPystyReso2; ?>],
          ['Maksimi vaakaresoluutio', <?php echo $MaxVaakaReso1; ?>, <?php echo $MaxVaakaReso2; ?>],
          ['Korkeus', <?php echo $Korkeus1; ?>, <?php echo $Korkeus2; ?>],
          ['Leveys', <?php echo $Leveys1; ?>, <?php echo $Leveys2; ?>],
          ['Pituus', <?php echo $Pituus1; ?>, <?php echo $Pituus2; ?>]
        ]);
        var options = {
          chart: {
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

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

span.psw {
    float: right;
    padding-top: 16px;
}



</style>
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
    <li><a href="etusivu.php">Home</a></li>
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
  
  <div class="page-header">
  </div>
<?php




// tehdään jokaisesta osastotaulun rivistä oma rivi tauluun

// uusi table



echo "<div class='container'>";
echo  "<h2>{$ValmistajaNimi1} {$MerkkiNimi1} {$SarjaNimi1} {$MalliNimi1} VS {$ValmistajaNimi2} {$MerkkiNimi2} {$SarjaNimi2} {$MalliNimi2}</h2>";        
echo  "<table class='table'>";
echo    "<thead>";
echo    "<tr>";
echo      "</tr>";
echo    "</thead>";
echo    "<tbody>";
echo      "<tr>";
echo        "<td><b>Valmistaja</b></td>";
echo        "<td>{$ValmistajaNimi1}</td>";
echo        "<td>{$ValmistajaNimi2}</td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td><b>Merkki</b></td>";
echo        "<td>{$MerkkiNimi1}</td>";
echo        "<td>{$MerkkiNimi2}</td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td><b>Sarja</b></td>";
echo        "<td>{$SarjaNimi1}</td>";
echo        "<td>{$SarjaNimi2}</td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td><b>Malli</b></td>";
echo        "<td>{$MalliNimi1}</td>";
echo        "<td>{$MalliNimi2}</td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td><b>GDDR</b></td>";
echo        "<td>{$GDDR1}</td>";
echo        "<td>{$GDDR2}</td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td><b>Kellotaajuus</b></td>";
echo        "<td>{$GPUKellotaajuusBASE1} GHz</td>";
echo        "<td>{$GPUKellotaajuusBASE2} GHz</td>";
echo      "</tr>";
echo        "<td><b>Maksimi kellotaajuus</b></td>";
echo        "<td>{$GPUKellotaajuusBOOST1} GHz</td>";
echo        "<td>{$GPUKellotaajuusBOOST2} GHz</td>";
echo      "</tr>";
echo      "</tr>";
echo        "<td><b>Muistin kapasiteetti</b></td>";
echo        "<td>{$GPUMEMKapasiteetti1}</td>";
echo        "<td>{$GPUMEMKapasiteetti2}</td>";
echo      "</tr>";
echo      "</tr>";
echo        "<td><b>Muistin kellotaajuus</b></td>";
echo        "<td>{$GPUMEMKellotaajuus1} GHz</td>";
echo        "<td>{$GPUMEMKellotaajuus2} GHz</td>";
echo      "</tr>";
echo      "</tr>";
echo        "<td><b>Maksimi pystyresoluutio</b></td>";
echo        "<td>{$MaxPystyReso2}</td>";
echo        "<td>{$MaxPystyReso2}</td>";
echo      "</tr>";
echo      "</tr>";
echo        "<td><b>Maksimi vaakaresoluutio</b></td>";
echo        "<td>{$MaxVaakaReso1}</td>";
echo        "<td>{$MaxVaakaReso2}</td>";
echo      "</tr>";
echo      "</tr>";
echo        "<td><b>Korkeus</b></td>";
echo        "<td>{$Korkeus1}</td>";
echo        "<td>{$Korkeus2}</td>";
echo      "</tr>";
echo      "</tr>";
echo        "<td><b>Leveys</b></td>";
echo        "<td>{$Leveys1}</td>";
echo        "<td>{$Leveys2}</td>";
echo      "</tr>";
echo      "</tr>";
echo        "<td><b>Pituus</b></td>";
echo        "<td>{$Pituus1}</td>";
echo        "<td>{$Pituus2}</td>";
echo      "</tr>";
echo      "</tr>";
echo        "<td><b>Arvostelut</b></td>";
echo        "<td>{$GPURating1}</td>";
echo        "<td>{$GPURating2}</td>";
echo      "</tr>";

echo    "</tbody>";
echo  "</table>";
echo "</div>";


?>
<div class="container">
<div id="barchart_material" style="width: auto; height: 500px;"></div>

</div>

</body>
