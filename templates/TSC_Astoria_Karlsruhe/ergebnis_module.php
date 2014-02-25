<?PHP 
include('database.php');


    // Connect to database
    $mysqli = @new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    //
    // Check connection
    if (mysqli_connect_errno()) {
        printf("Unable to connect to database: %s", mysqli_connect_error());
        exit();
    }
	
	$zeitraum=3;
	
$heute = time();
$ende = time();

//86400 sekunden = 1 Tag

switch($zeitraum){
	
	case 1: $ende = $ende - 7*86400;
			break;
	
	case 2: $ende = $ende - 14*86400;
			break;
	
	case 3: $ende = $ende - 28*86400;
			break;
	
	case 4: $ende = $ende - 365*86400;
			break;
	
	case 5: $ende = 0; break;
	
	default: $ende = $ende - 28*86400;
			break;
	
	}
	
	    // Construct SQL statement for query & execute
    $sql	= "SELECT * FROM ergebnisse WHERE datum >= $ende AND freigabe = 1 AND paar_name IS NOT NULL GROUP BY ort, datum ORDER BY datum DESC;

";
    $alle_ergebnisse = $mysqli->query($sql); 
	
	$i=1;
	
	
	

	echo "<ul class=\"latestnews\">";
	
	if(is_object($alle_ergebnisse)){
  
while($alle_ergebnisseLine = $alle_ergebnisse->fetch_array(MYSQLI_ASSOC)) {
	
		$ort = $alle_ergebnisseLine['ort'];
	$datum = $alle_ergebnisseLine['datum'];
		

 		
		echo "<li class=\"latestnews\"><a href=\"/index.php/aktuelles-a-termine/ergebnisse-der-paare\" 
class=\"latestnews\">".date('d', $datum).".".date('m', $datum).".".date('Y', $datum).": ".$ort."</a> </li>";
 
  
  }  // elle ergebnisse durch
  
	}
  
  ?>
  
