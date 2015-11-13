<?php

function scraping_meck() {
    // create HTML DOM
    $html = file_get_html('http://meckok.se/lunch');
	// get prices
    $item['priceTypeEarlyBird'] = $html->find('div[class="menucard-content-container"]',0)->find('strong', 0)->plaintext;
    $item['priceEarlyBird'] = $html->find('div[class="menucard-content-container"]',0)->find('em', 0)->plaintext;
    $item['priceTypeBird'] = $html->find('div[class="menucard-content-container"]',0)->find('strong', 1)->plaintext;
    $item['priceBird'] = $html->find('div[class="menucard-content-container"]',0)->find('em', 1)->plaintext;
    $item['priceTypeLateBird'] = $html->find('div[class="menucard-content-container"]',0)->find('strong', 2)->plaintext;
    $item['priceLateBird'] = $html->find('div[class="menucard-content-container"]',0)->find('em', 2)->plaintext;
	$ret[] = $item;

    // get Mon-Fri + soup + sallad
    $countDays = 0;
    foreach($html->find('div[class="post-content"]') as $daily) {

        // if the days have reached 6, it means we made it to the soup and sallad
        if ($countDays < 5) {
			// get day
			$item['day'] = trim($daily->find('h3', 0)->plaintext);
			// get menu
			$item['menu'] = trim($daily->find('p', 0)->plaintext);

			$ret[] = $item;
		}

        // if the days have reached 6, it means we made it to the soup and sallad
        if ($countDays == 5) {
			// get menu
			// nothing to do in this case
		}

        // increase the counter
        $countDays++;

    }

    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}

function printOut_meck($weekday = -1, $cli = true) {
	$ret = scraping_meck();

	// show results on cli
	$countDays = 0;
	if ($cli) {
		echo "MECK\n";
		echo "*********\n";
		foreach($ret as $v) {
			if($countDays == 0) {
				echo $v['priceTypeEarlyBird']."\t".$v['priceEarlyBird']."\n";
				echo $v['priceTypeBird']."\t".$v['priceBird']."\n";
				echo $v['priceTypeLateBird']."\t".$v['priceLateBird']."\n";
				echo "\n----------------------\n";
			}
			if($countDays > 0 && $countDays < 6 && $weekday == -1 || $weekday == $countDays - 1) {
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
		echo "<div class='restaurantName'>MECK</div>";
		foreach($ret as $v) {
			if($countDays == 0) {
				echo "<div class='priceContainer'><div class='priceListTitle'>Prices</div><div class='space'></div><div class='priceList'>";
				echo "<div class='priceType'>".$v['priceTypeEarlyBird']."</div><div class='dishPrice'>".$v['priceEarlyBird']."</div>";
				echo "<div class='priceType'>".$v['priceTypeBird']."</div><div class='dishPrice'>".$v['priceBird']."</div>";
				echo "<div class='priceType'>".$v['priceTypeLateBird']."</div><div class='dishPrice'>".$v['priceLateBird']."</div>";
				echo "</div></div>";
			}
			echo "<div class='dayContainer'>";
			if($countDays > 0 && $countDays < 6 && $weekday == -1 || $weekday == $countDays - 1) {
				echo "<div class='day'>".$v['day']."</div>";
				echo "<div class='dishDesc'>".$v['menu']."</div>";
			}
			echo "</div>";
			if($countDays == 6) {
				// nothing to do in this case
			}
			$countDays++;
		}
		echo "</div>";
	}
}

?>
