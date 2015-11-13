<?php
function scraping_valfarden() {
    // create HTML DOM
    $html = file_get_html('http://valfarden.nu/dagens-lunch/');
	// get prices
    $item['times'] = $html->find('div[class="single_inside_content"]',0)->find('h2', 0)->plaintext;
    $item['prices'] = "";


    // get Mon-Fri
	for ($x = 4; $x <= 14; $x+=2) {
		$item['day'] = $html->find('div[class="single_inside_content"]',0)->find('p', $x)->innertext;
		$item['menu'] = $html->find('div[class="single_inside_content"]',0)->find('p', $x+1)->plaintext;
		$ret[] = $item;
    }

    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}

function printOut_valfarden($weekday = -1, $cli = true) {
	$ret = scraping_valfarden();

	// show results on cli
	$countDays = 0;
	if ($cli) {
		echo "VALFARDEN\n";
		echo "*********\n";
		foreach($ret as $v) {
			if($countDays == 0) {
				echo $v['times']."\n";
				echo $v['prices']."\n";
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
		echo "<div class='restaurantName'>VALFARDEN</div>";
		foreach($ret as $v) {
			if($countDays == 0) {
				echo "<div class='priceContainer'><div class='priceListTitle'>Prices</div>";
				echo "<div class='times'>".$v['times']."</div>";
				echo "<div class='dishPriceLine'>".$v['prices']."</div>";
				echo "</div>";
			}
			echo "<div class='dayContainer'>";
			if($countDays >= 0 && $countDays < 5  && $weekday == -1 || $weekday == $countDays) {
				echo "<div class='dishDesc'>".$v['day']."</div>";
				echo "<div class='dishDesc'>".$v['menu']."</div>";
			}
			echo "</div>";
			$countDays++;
		}
		echo "</div>";
	}
}

 ?>
