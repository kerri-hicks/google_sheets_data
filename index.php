<?php
//header('Content-type: application/json');
 
// get the CSV feed
$feed = "https://docs.google.com/spreadsheets/d/e/2PACX-1vR9Vk_RN_0stizEdJEMoXMO-b-NQAh8IYt7HtkGFTQ_VjQSRbnKAju64TK_eI1w1ZddkTScw0t9zTAv/pub?gid=1298374022&single=true&output=csv" ;
 
// define arrays
$keys = array() ;
$newArray = array() ;
 
// Function to convert CSV into associative array
function csvToArray($file, $delimiter) { 
  if (($handle = fopen($file, 'r')) !== FALSE) { 
    $i = 0 ; 
    while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) { 
      for ($j = 0; $j < count($lineArray) ; $j++) { 
        $arr[$i][$j] = $lineArray[$j] ; 
      } 
      $i++ ; 
    } 
    fclose($handle) ; 
  } 
  return $arr ; 
} 
 
// make the array
$data = csvToArray($feed, ',') ;
 
// set number of elements (minus 1 because we shift off the first row)
$count = count($data) - 1 ;
 
// use first row for names  
$labels = array_shift($data) ;  
 
foreach ($labels as $label) {
  $keys[] = $label ;
}
 
// Add Ids, just in case we want them later
$keys[] = 'id' ;
 
for ($i = 0 ; $i < $count ; $i++) {
  $data[$i][] = $i ;
}
 
// Bring it all together
for ($j = 0 ; $j < $count ; $j++) {
  $d = array_combine($keys, $data[$j]) ;
  $newArray[$j] = $d ;
}

 
// Print it out as JSON, in case it might be useful elsewhere to have some JSON
// $json_block = json_encode($newArray);
// $newNewArray = json_decode($json_block, true) ;

$count = 0 ;

$display_block = "<div class='card_deck'>" ;

foreach($newArray[0] as $card_label_label => $card_data_data_point) {
	if($count < 6) {
		if($count == 0) {
			$display_block .= '<h3 class="poster_section_head">About Reserves</h3>' ;
		}elseif($count == 3){
			$display_block .= '<h3 class="poster_section_head">About Books</h3>' ;
		}
		$display_block .= "<div class='card'><div class='card_data'>$card_data_data_point</div><div class='card_label'>$card_label_label</div></div>" ;
		++$count ; 
	}
}

$display_block .= "</div>" ;

?>


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
			font-family : Minion Pro, sans-serif ;
			width : 25% ;
			height : auto ;
			margin : 0px 20px ; 
			text-align : center ; 
			box-sizing : border-box ;
		}
		
		.card_label {
			font-size: 1.6vw;
			color: #5b5b5b;
			margin: 0 0 1em;
			padding : 6px ;
			box-sizing : border-box ; 
		}
		
		.card_data {
			color : #000 ;
			font-family: CircularStd,sans-serif;
			font-weight: 700;
			font-size: 3vw;
			margin: 0 .15em;
			padding : 6px ;
			box-sizing : border-box ; 
		}
		
		.poster_section_head {
			width : 100% ; 
			text-align : center ;
			margin : 15px 0px 0px 0px ; 
			font-size : 2.2vw ;
			font-family : Minion Pro ;
		}
		
		#opener {
			margin-top : 30px ; 
			color : var(--brown_red) ;
			font-weight : bold ; 
			text-align : center ;
			font-size : 4vw ;
			font-family : Minion Pro ;
		}
		
		hr.stats_poster {
			width : 90% ; 
			height : 4px ; 
			color : var(--brown_gold) ; 
			background-color : var(--brown_gold) ; 
			border-width : 0 ;
		}
		
		#statsframe {
			width : 90% ; 
			margin : auto ; 
		}
	</style>
<div id="statsframe">
	<h2 id="opener">
		Library Statistics
	</h2>

	<hr class="stats_poster" />
	<?php echo $display_block ; ?>
	<hr class="stats_poster" />
</div>
