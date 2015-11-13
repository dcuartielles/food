<?php
function scraping_thaithai(){
	$html = file_get_html('http://thai-thai.se/menu');

	for ($x = 1; $x <= 12; $x++) {
		$item['dasFood'] = trim($html->find('div[id="container"]',0)->find('h3', $x)->plaintext, "&nbsp");
		$item['dasPrice'] = trim($html->find('div[id="container"]',0)->find('span', $x-1)->plaintext, "&nbsp");
		$item['dasDesc'] = trim($html->find('div[id="container"]',0)->find('p', $x)->plaintext, "&nbsp");
		$ret[] = $item;
    }
		    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}


function printOut_thaithai($weekday = -1, $cli = true){
	$ret = scraping_thaithai();

	echo "<div class='restaurantContainer'>";
	echo "<div class='restaurantName'>Thai Thai</div>";
	echo "Menu v. ";
	echo date('W');
	echo "\n";
	echo "</br>";

	foreach($ret as $v) {
		echo "<div class='dishType'>".$v['dasFood']."</div>";
		echo "<div class='dishDesc'>".$v['dasDesc']."</div>";
		echo "<div class= 'dishPrice'>".$v['dasPrice'].":-</div>";
	}
	echo "</div>";
}
 ?>
