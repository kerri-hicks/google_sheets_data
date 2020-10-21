<?php
//header('Content-type: application/json');
 
// get the CSV feed
$feed = 'URL HERE;
 
// define arrays
$keys = array();
$newArray = array();
 
// Function to convert CSV into associative array
function csvToArray($file, $delimiter) { 
  if (($handle = fopen($file, 'r')) !== FALSE) { 
    $i = 0; 
    while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) { 
      for ($j = 0; $j < count($lineArray); $j++) { 
        $arr[$i][$j] = $lineArray[$j]; 
      } 
      $i++; 
    } 
    fclose($handle); 
  } 
  return $arr; 
} 
 
// make the array
$data = csvToArray($feed, ',');
 
// set number of elements (minus 1 because we shift off the first row)
$count = count($data) - 1;
 
// use first row for names  
$labels = array_shift($data);  
 
foreach ($labels as $label) {
  $keys[] = $label;
}
 
// Add Ids, just in case we want them later
$keys[] = 'id';
 
for ($i = 0; $i < $count; $i++) {
  $data[$i][] = $i;
}
 
// Bring it all together
for ($j = 0; $j < $count; $j++) {
  $d = array_combine($keys, $data[$j]);
  $newArray[$j] = $d;
}

 
// Print it out as JSON
$json_block = json_encode($newArray);
 
//echo $json_block ;  

$data_points = json_decode($json_block, true) ;

$count = 0 ;

$display_block = "<div class='card_deck'>" ;

foreach($data_points[0] as $label => $data_point) {
	if($count < 6) {
		$display_block .= "<div class='card'><div class='card_top'>$label</div><div class='card_bottom'>$data_point</div></div>";
		++$count ; 
	}
}

$display_block .= "</div>" ;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title></title>
	<style type="text/css">		
		:root {
		  --brown_brown : #4e3629 ;
		  --brown_red : #c00404 ;
		  --brown_red_old : #ed1c24 ;
		  --brown_yellow : #ffc72c ;
		  --brown_gold : #ffc72c ; 
		  --brown_gray: #98a4ae;
		  --brown_emerald: #00b398;
		  --brown_navy: #003c71;
		  --brown_skyblue: #59CBEB;
		  --brown_taupe: #b7b09c;
		}
		
		#opener {
			font-size : 1.5em ; 
		}
		
		.card_deck {
			display : flex ;
			flex-flow : row wrap ;
			justify-content : space-around ;
			width : 100% ; 
		}
		
		.card {
			padding : 0px ; 
			font-family : Arial, Helvetica, sans-serif ;
			width : 25% ;
			height : auto ;
			margin : 20px ; 
			text-align : center ; 
			background-color : var(--brown_gold) ;
			box-sizing : border-box ;
			box-shadow : 0px 1px 3px #999 ; 
		}
		
		.card_top {
			background-color : var(--brown_red) ;
			color : #fff ;
			width : 100% ;
			font-weight : bold ;
			padding : 6px ;
			box-sizing : border-box ; 
			font-size : 1.8vw ;
		}
		
		.card_bottom {
			color : #000 ;
			width : 100% ;
			font-size : 2.5em ;
			padding : 6px ;
			box-sizing : border-box ; 
			font-size : 2.5vw ; 
		}
		
	</style>
</head>
<body>
<p id="opener">
	Text for the top
</p>

<?php echo $display_block ; ?>

</body>
</html>
