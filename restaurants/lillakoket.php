<?php
function scraping_lillakoket() {
    // create HTML DOM
    $html = file_get_html('http://lillakoket.com/menu-category/lunch-meny/');
	// get preinfo
    // $item['key'] = $html->find('div[class="menucard-content-container"]',0)->find('em', 2)->plaintext;
	// $ret[] = $item;

    // get Mon-Fri
    $countDays = 0;
    foreach($html->find('div[class="menu_category"]') as $daily) {
			foreach($daily->find('article') as $dailyMenu) {
				// get day
				$item['day'] = trim($daily->find('h3', $countDays)->plaintext);
				$item['dayNumber'] = $countDays;
				$item['dishPrice'] = "85:-";
				$item['menu'] = trim($daily->find('p', 0)->innertext);

				$ret[] = $item;

				//increase counter
				$countDays++;
			}
	}




    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}

function printOut_lillakoket($weekday = -1, $cli = true) {
	$ret = scraping_lillakoket();

	// show results on cli
	$countDays = 0;
	if ($cli) {
		echo "LILLA KOKET\n";
		echo "*********\n";
		foreach($ret as $v) {
			if($countDays == 0) {
				echo "\n----------------------\n";
			}
			if($countDays >= 0 && $countDays < 5  && $weekday == -1 || $weekday == $countDays) {
				echo $v['day']."\n----------------------\n";
				echo $v['menu'];
				echo "\n----------------------\n";
			}
			if($countDays == 6) {
				// nothing to do in this case
			}
			$countDays++;
		}
	} else {
		echo "<div class='restaurantContainer'>";
		echo "<div class='restaurantName'>LILLA KOKET</div>";
			if($countDays == 0) {
				echo "<div class='priceContainer'><div class='priceListTitle'>Prices</div>";
				echo "<div class='dishPriceLine'>".$ret[0]['dishPrice']."</div>";
				echo "</div>";
			}
		foreach($ret as $v) {
			echo "<div class='dayContainer'>";
			if($countDays >= 0 && $countDays < 5  && $weekday == -1 || $weekday == $countDays) {
				echo "<div class='day'>".$v['day']."</div>";
				echo "<div class='dishDesc'>".$v['menu']."</div>";
			}
			echo "</div>";
			$countDays++;
		}
		echo "</div>";
	}
}

 ?>
