<?php
function scraping_redFellas() {
    // create HTML DOM
    $html = file_get_html('http://emporia.redfellas.com/meny');
    // get Mon-Fri + soup + sallad
    $countDays = 0;

    foreach($html->find('div[class="course-content"]') as $daily){
      // get title
      $item['dishCategory'] = trim ($daily->find('h3',0)->plaintext);
      $item['dishPrice'] = trim ($daily->find('h3',1)->plaintext);
      $item['dishDesc'] = trim ($daily->find('p[class="text"]',0)-> plaintext);

      $ret[] = $item;
      $countDays++;
		}

    $item['contributedBy'] = "Ilham Hussein, Therése Brändström and Casandra Galante Borg";

    // clean up memory
    $html->clear();
    unset($html);
    return $ret;
}
function printOut_redFellas($weekday = -1, $cli = true) {
	$ret = scraping_redFellas();
//print_r($ret);
	// show results on cli
	if ($cli) {
		echo "RedFellas\n";
		echo "*********\n";
		foreach($ret as $v) {
				echo $v['title']."\n----------------------\n";
				echo $v ['priceRed']."\n";
				echo $v ['descRed']."\n";

				echo "\n----------------------\n";
		}
	} else {
		echo "<div class='restaurantContainer'>";
		echo "<div class='restaurantName'>RedFellas</div>";
		foreach($ret as $v) {
			if($weekday != -1) {
        echo "<div class='dishType'>".$v['dishCategory']."</div>";
				echo "<div class='dishDesc'>".$v['dishDesc']."</div>";
				echo "<div class='dishPrice'>".$v['dishPrice']."</div>";
			}
		}
		echo "</div>";
	}
}
 ?>
