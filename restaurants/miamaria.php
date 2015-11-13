<?php

function scraping_miamarias() {
    // create HTML DOM
    $html = file_get_html('http://miamarias.nu/');

    // get Mon-Fri + soup + sallad
    $countDays = 0;
    foreach($html->find('div[class="et_slidecontent"]') as $daily) {

        // if the days have reached 6, it means we made it to the soup and sallad
        if ($countDays < 5) {
			// get day
			$item['day'] = trim($daily->find('strong', 0)->plaintext);
			// get menu
			$item['fish'] = trim($daily->find('table', 0)->find('td', 0)->plaintext);
			$item['fishPrice'] = trim($daily->find('table', 0)->find('td', 1)->plaintext);
			$item['fishDish'] = trim($daily->find('table', 0)->find('td', 2)->plaintext);
			$item['meat'] = trim($daily->find('table', 0)->find('td', 4)->plaintext);
			$item['meatPrice'] = trim($daily->find('table', 0)->find('td', 5)->plaintext);
			$item['meatDish'] = trim($daily->find('table', 0)->find('td', 6)->plaintext);
			$item['veg'] = trim($daily->find('table', 0)->find('td', 8)->plaintext);
			$item['vegPrice'] = trim($daily->find('table', 0)->find('td', 9)->plaintext);
			$item['vegDish'] = trim($daily->find('table', 0)->find('td', 10)->plaintext);

			$ret[] = $item;
		}

        // if the days have reached 6, it means we made it to the soup and sallad
        if ($countDays == 5) {
			// get menu
			$item['soup'] = trim($daily->find('strong', 0)->plaintext);
			$item['soupDish'] = trim($daily->find('table', 0)->find('td', 0)->plaintext);
			$item['soupPrice'] = trim($daily->find('table', 0)->find('td', 1)->plaintext);
			$item['sallad'] = trim($daily->find('strong', 2)->plaintext);
			$item['salladDish'] = trim($daily->find('table', 1)->find('td', 0)->plaintext);
			$item['salladPrice'] = trim($daily->find('table', 1)->find('td', 1)->plaintext);

			$ret[] = $item;
		}

        // increase the counter
        $countDays++;

    }

    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}

function printOut_miamarias($weekday = -1, $cli = true) {
	$ret = scraping_miamarias();

	// show results on cli
	$countDays = 0;
	if ($cli) {
		echo "MIAMARIAS\n";
		echo "*********\n";
		foreach($ret as $v) {
			if($countDays < 5 && $weekday == -1 || $weekday == $countDays) {
				echo $v['day']."\n----------------------\n";
				echo $v['fish'].", ";
				echo $v['fishDish']."\t";
				echo $v['fishPrice']."\n";
				echo $v['meat'].", ";
				echo $v['meatDish']."\t";
				echo $v['meatPrice']."\n";
				echo $v['veg'].", ";
				echo $v['vegDish']."\t";
				echo $v['vegPrice']."\n";
				echo "\n----------------------\n";
			}
			if($countDays == 5) {
				echo $v['soup'].", ";
				echo $v['soupDish']."\t";
				echo $v['soupPrice']."\n";
				echo $v['sallad'].", ";
				echo $v['salladDish']."\t";
				echo $v['salladPrice']."\n";
				echo "\n----------------------\n";
			}
			$countDays++;
		}
	} else {
		echo "<div class='restaurantContainer'>";
		echo "<div class='restaurantName'>MIAMARIAS</div>";
		foreach($ret as $v) {
			if($countDays < 5 && $weekday == -1 || $weekday == $countDays) {
				echo "<div class='day'>".$v['day']."</div>";
				echo "<div class='dayContainer'>";
				echo "<div class='dishType'>".$v['fish']."</div>";
				echo "<div class='dishDesc'>".$v['fishDish']."</div>";
				echo "<div class='dishPrice'>".$v['fishPrice']."</div>";
				echo "<div class='dishType'>".$v['meat']."</div>";
				echo "<div class='dishDesc'>".$v['meatDish']."</div>";
				echo "<div class='dishPrice'>".$v['meatPrice']."</div>";
				echo "<div class='dishType'>".$v['veg']."</div>";
				echo "<div class='dishDesc'>".$v['vegDish']."</div>";
				echo "<div class='dishPrice'>".$v['vegPrice']."</div>";
				echo "</div>";
			}
			if($countDays == 5) {
				echo "<div class='dishType'>".$v['soup']."</div>";
				echo "<div class='dishDesc'>".$v['soupDish']."</div>";
				echo "<div class='dishPrice'>".$v['soupPrice']."</div>";
				echo "<div class='dishType'>".$v['sallad']."</div>";
				echo "<div class='dishDesc'>".$v['salladDish']."</div>";
				echo "<div class='dishPrice'>".$v['salladPrice']."</div>";;
			}
			$countDays++;
		}
		echo "</div>";
	}
}
?>
