<html lang="en">
<head>



  <title>Vertailutyökalu - CPU comparison</title>
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

$key1=$_GET['CPU1'];
$key2=$_GET['CPU2'];

//HAE CPU 1

$sqlLause = "SELECT CPURating AS CPURating1, MerkkiNimi AS MerkkiNimi1, SarjaNimi AS SarjaNimi1, Kanta AS Kanta1, Kellotaajuus AS Kellotaajuus1, MAX_Kellotaajuus AS MAX_Kellotaajuus1, Malli AS Malli1, TDP AS TDP1, Teknologia AS Teknologia1, Threadit AS Threadit1, Valimuisti AS Valimuisti1, Ytimet AS Ytimet1

from TeknisetCPU 

INNER JOIN Sarja ON Sarja.SarjaID = TeknisetCPU.SarjaID 
  
INNER JOIN Merkki ON Merkki.MerkkiID = TeknisetCPU.MerkkiID 

INNER JOIN CPU_Kanta ON CPU_Kanta.KantaID = TeknisetCPU.KantaID

WHERE CPU_ID = $key1;";



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


//HAE CPU 2

$sqlLause = "SELECT CPURating AS CPURating2, MerkkiNimi AS MerkkiNimi2, SarjaNimi AS SarjaNimi2, Kanta AS Kanta2, Kellotaajuus AS Kellotaajuus2, MAX_Kellotaajuus AS MAX_Kellotaajuus2, Malli AS Malli2, TDP AS TDP2, Teknologia AS Teknologia2, Threadit AS Threadit2, Valimuisti AS Valimuisti2, Ytimet AS Ytimet2

from TeknisetCPU 

INNER JOIN Sarja ON Sarja.SarjaID = TeknisetCPU.SarjaID 
  
INNER JOIN Merkki ON Merkki.MerkkiID = TeknisetCPU.MerkkiID 

INNER JOIN CPU_Kanta ON CPU_Kanta.KantaID = TeknisetCPU.KantaID

WHERE CPU_ID = $key2;";



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
$Kellotaajuus1 = $Kellotaajuus1/1000;
$Kellotaajuus2 = $Kellotaajuus2/1000;
$MAX_Kellotaajuus1 = $MAX_Kellotaajuus1/1000;
$MAX_Kellotaajuus2 = $MAX_Kellotaajuus2/1000;
      ?>


      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          [' ', '<?php echo $MerkkiNimi1 . " " . $SarjaNimi1 . " ". $Malli1 ?>', '<?php echo $MerkkiNimi2 . " " . $SarjaNimi2 . " " . $Malli2 ?>'],
          ['Kellotaajuus', <?php echo $Kellotaajuus1; ?>, <?php echo $Kellotaajuus2; ?>],
          ['Maksimi kellotaajuus', <?php echo $MAX_Kellotaajuus1; ?>, <?php echo $MAX_Kellotaajuus2; ?>],
          ['Teknologia', <?php echo $Teknologia1; ?>, <?php echo $Teknologia2; ?>],
          ['Threadit', <?php echo $Threadit1; ?>, <?php echo $Threadit2; ?>],
          ['Välimuisti', <?php echo $Valimuisti1; ?>, <?php echo $Valimuisti2; ?>],
          ['Ytimet', <?php echo $Ytimet1; ?>, <?php echo $Ytimet2; ?>],
          ['Arvostelut', <?php echo $CPURating1; ?>, <?php echo $CPURating2; ?>]
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
echo  "<h2>{$MerkkiNimi1} {$SarjaNimi1} {$Malli1} VS {$MerkkiNimi2} {$SarjaNimi2} {$Malli2}</h2>";        
echo  "<table class='table'>";
echo    "<thead>";
echo    "<tr>";
echo      "</tr>";
echo    "</thead>";
echo    "<tbody>";
echo      "<tr>";
echo        "<td>Merkki</td>";
echo        "<td>{$MerkkiNimi1}</td>";
echo        "<td>{$MerkkiNimi2}</td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td>Sarja</td>";
echo        "<td>{$SarjaNimi1}</td>";
echo        "<td>{$SarjaNimi2}</td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td>Malli</td>";
echo        "<td>{$Malli1}</td>";
echo        "<td>{$Malli2}</td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td>Kanta</td>";
echo        "<td>{$Kanta1}</td>";
echo        "<td>{$Kanta2}</td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td>Kellotaajuus</td>";
echo        "<td>{$Kellotaajuus1} GHz</td>";
echo        "<td>{$Kellotaajuus2} GHz</td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td>Maksimi kellotaajuus</td>";
echo        "<td>{$MAX_Kellotaajuus1} GHz</td>";
echo        "<td>{$MAX_Kellotaajuus2} GHz</td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td>TDP</td>";
echo        "<td>{$TDP1} W</td>";
echo        "<td>{$TDP2} W</td>";
echo      "</tr>";
echo        "<td>Teknologia</td>";
echo        "<td>{$Teknologia1} nm</td>";
echo        "<td>{$Teknologia2} nm</td>";
echo      "</tr>";
echo      "</tr>";
echo        "<td>Threadit</td>";
echo        "<td>{$Threadit1}</td>";
echo        "<td>{$Threadit2}</td>";
echo      "</tr>";
echo      "</tr>";
echo        "<td>Valimuisti</td>";
echo        "<td>{$Valimuisti1} MB</td>";
echo        "<td>{$Valimuisti2} MB</td>";
echo      "</tr>";
echo      "</tr>";
echo        "<td>Ytimet</td>";
echo        "<td>{$Ytimet1}</td>";
echo        "<td>{$Ytimet2}</td>";
echo      "</tr>";
echo      "</tr>";
echo        "<td>Arvostelut</td>";
echo        "<td>{$CPURating1}</td>";
echo        "<td>{$CPURating2}</td>";
echo      "</tr>";
echo    "</tbody>";
echo  "</table>";
echo "</div>";

?>
<div class="container">
<div id="barchart_material" style="width: auto; height: 500px;"></div>

</div>

</body>
