<html lang="en">
<head>

  <title>Vertailutyökalu - Hae vertailtavat komponentit</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
      <li class="active"><a href="cpucomparison.php">Compare CPU's</a></li>
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

        <?php
              include 'AdminPages/logininfo.php';
              $sql = "SELECT TeknisetCPU.CPU_ID AS ID, Merkki.MerkkiNimi AS Merkki, Sarja.SarjaNimi AS Sarja, TeknisetCPU.Malli AS Malli
              FROM TeknisetCPU
              INNER JOIN Merkki ON TeknisetCPU.MerkkiID = Merkki.MerkkiID
              INNER JOIN Sarja ON TeknisetCPU.SarjaID = Sarja.SarjaID; ";
              $komento = $yhteys->prepare($sql);
              $komento ->execute();
              $tulos = $komento->fetchAll();
              ?>

<div class="container">
<form action="CPUvertailu.php" method="get">
      <div class="col-sm-6">
      <div class="form-group">
            <select class='form-control' name='CPU1' placeholder='Search CPU1'>
            <?php foreach ($tulos as $row){ ?>
            <option value="<?php echo $row['ID'];?>"> <?php echo $row['Merkki'];?> <?php echo $row['Sarja'];?> <?php echo $row['Malli'];?></option>
                <?php } ?>
            </select>
      </div>
      </div>
      <div class="col-sm-6">
      <div class="form-group">
            <select class='form-control' name='CPU2' placeholder='Search CPU1'>
            <?php foreach ($tulos as $row){ ?>
              <option value="<?php echo $row['ID'];?>"> <?php echo $row['Merkki'];?> <?php echo $row['Sarja'];?> <?php echo $row['Malli'];?></option>
                <?php } ?>
            </select>
      </div>
      </div>
      <button type="submit" class="btn btn-success">Vertaa</button>
</form>

</div>

</body>