<?php
function scraping_orkanen() {
    // create HTML DOM
    $html = file_get_html('http://www.mhmatsalar.se/');
	// get prices
    $item['times'] = $html->find('div[id="orkanen"]',0)->find('div[class="col-md-8"]',0)->find('h2', 1)->plaintext;
    $item['prices'] = $html->find('div[id="orkanen"]',0)->find('div[class="col-md-8"]',0)->find('p', 0)->plaintext;

    // sallad
    $item['soupAndSallad'] = $html->find('div[id="orkanen"]',0)->find('div[class="col-md-8"]',0)->find('p', 1)->plaintext;
	$ret[] = $item;

    // get Mon-Fri
	for ($x = 2; $x <= 12; $x+=2) {
		$item['day'] = $html->find('div[id="orkanen"]',0)->find('div[class="col-md-8"]',0)->find('p', $x)->plaintext;
		$item['menu'] = $html->find('div[id="orkanen"]',0)->find('div[class="col-md-8"]',0)->find('p', $x+1)->plaintext;
		$ret[] = $item;
    }

    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}

function printOut_orkanen($weekday = -1, $cli = true) {
	$ret = scraping_orkanen();

	// show results on cli
	$countDays = 0;
	if ($cli) {
		echo "ORKANEN\n";
		echo "*********\n";
		foreach($ret as $v) {
			if($countDays == 0) {
				echo $v['times']."\n";
				echo $v['prices']."\n";
				echo $v['soupAndSallad']."\n";
				echo "\n----------------------\n";
			}
			if($countDays > 0 && $countDays < 6  && $weekday == -1 || $weekday == $countDays - 1) {
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
		echo "<div class='restaurantName'>ORKANEN</div>";
		foreach($ret as $v) {
			if($countDays == 0) {
				echo "<div class='priceContainer'><div class='priceListTitle'>Prices</div>";
				echo "<div class='times'>".$v['times']."</div>";
				echo "<div class='dishPriceLine'>".$v['prices']."</div>";
				echo "<div class='dishDesc'>".$v['soupAndSallad']."</div>";
				echo "</div>";
			}
			echo "<div class='dayContainer'>";
			if($countDays > 0 && $countDays < 6  && $weekday == -1 || $weekday == $countDays - 1) {
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
