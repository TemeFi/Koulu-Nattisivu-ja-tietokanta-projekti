<?php
// create a new function
function search($text){
	
	// connection to the Ddatabase
	$db = new PDO("mysql:host=mysql.cc.puv.fi;dbname=e1701247_vertailu", 'e1701247', 'RTySaR9anuqv');
	// let's filter the data that comes in
	$text = htmlspecialchars($text);
	// prepare the mysql query to select the users 
	$get_name = $db->prepare("SELECT TeknisetGPU.GPU_ID, Valmistaja.ValmistajaNimi, Merkki.MerkkiNimi, Sarja.SarjaNimi, Malli.MalliNimi
    FROM TeknisetGPU
    INNER JOIN Valmistaja ON TeknisetGPU.ValmistajaID = Valmistaja.ValmistajaID
    INNER JOIN Merkki ON TeknisetGPU.MerkkiID = Merkki.MerkkiID
    INNER JOIN Sarja ON TeknisetGPU.SarjaID = Sarja.SarjaID
    INNER JOIN Malli ON TeknisetGPU.MalliID = Malli.MalliID
	WHERE Valmistaja.ValmistajaNimi LIKE concat('%', :name, '%') OR Merkki.MerkkiNimi LIKE concat('%', :name, '%') OR Sarja.SarjaNimi LIKE concat('%', :name, '%') OR Malli.MalliNimi LIKE concat('%', :name, '%')
	LIMIT 10");
	// execute the query
	$get_name -> execute(array('name' => $text));
	// show the users on the page
	while($names = $get_name->fetch(PDO::FETCH_ASSOC)){
		// show each user as a link
		echo '<a href="NaytaGPU.php?ID='.$names['GPU_ID'].'">'.$names['ValmistajaNimi']. " " . $names['MerkkiNimi']. " " .$names['SarjaNimi']. " " .$names['MalliNimi'].'</a>';
		
	}


		// let's filter the data that comes in
		$text = htmlspecialchars($text);
		// prepare the mysql query to select the users 
		$get_name = $db->prepare("SELECT CPU_ID, MerkkiNimi, SarjaNimi, Malli
		from TeknisetCPU 
		INNER JOIN Sarja ON Sarja.SarjaID = TeknisetCPU.SarjaID 
		INNER JOIN Merkki ON Merkki.MerkkiID = TeknisetCPU.MerkkiID 
		INNER JOIN CPU_Kanta ON CPU_Kanta.KantaID = TeknisetCPU.KantaID
		WHERE MerkkiNimi LIKE concat('%', :name, '%') OR SarjaNimi LIKE concat('%', :name, '%') OR Malli LIKE concat('%', :name, '%')
		LIMIT 10");
		// execute the query
		$get_name -> execute(array('name' => $text));
		// show the users on the page
		while($names = $get_name->fetch(PDO::FETCH_ASSOC)){
			// show each user as a link
			echo '<a href="NaytaCPU.php?ID='.$names['CPU_ID'].'">'. $names['MerkkiNimi']. " " .$names['SarjaNimi']. " " .$names['Malli'].'</a>';
			
		}
}
// call the search function with the data sent from Ajax
search($_GET['txt']);
?>
