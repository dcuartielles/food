<?php
function scraping_malmoopera() {
    // create HTML DOM
    $html = file_get_html('http://www.malmoopera.se/mat-och-dryck/lunchmeny');
	// get prices
    $item['prices'] = $html->find('div[id="main-content"]',0)->find('div[class="ds-1col"]',0)->find('p', 3)->plaintext;


    // get Mon-Fri
	for ($x = 5; $x <= 14; $x+=1) {
		$item['menu'] = $html->find('div[id="main-content"]',0)->find('div[class="ds-1col"]',0)->find('p', $x-1)->innertext;
		$ret[] = $item;
    }

    $item['contributedBy'] ="David, Lura, and Robert";
    $ret[] = $item;

    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}

function printOut_malmoopera($weekday = -1, $cli = true) {
	$ret = scraping_malmoopera();

	// show results on cli
	$countDays = 0;
	if ($cli) {
		echo "MALMOOPERA\n";
		echo "*********\n";
		foreach($ret as $v) {
			if($countDays == 0) {
				echo $v['times']."\n";
				echo $v['prices']."\n";
				echo "\n----------------------\n";
			}
			if($countDays > 0 && $countDays < 6  && $weekday == -1 || $weekday == $countDays - 1) {
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
		echo "<div class='restaurantName'>MALMÖ OPERA</div>";
		foreach($ret as $v) {
			if($countDays == 0) {
				echo "<div class='priceContainer'><div class='priceListTitle'>Note</div>";
//				echo "<div class='times'>".$v['times']."</div>";
				echo "<div class='dishPriceLine'>".$v['prices']."</div>";
				echo "</div>";
			}
			echo "<div class='dayContainer'>";
			if($countDays > 0 && $countDays < 6  && $weekday == -1 || $weekday == $countDays - 1) {
        // I fixed to dishDesc because it allows using the inned styling for titles and so on
				echo "<div class='dishDesc'>".$v['menu']."</div>";
			}
			echo "</div>";
			if($countDays >= 6) {
        echo "<div class='dishDesc'>".$v['menu']."</div>";
			}
			$countDays++;
		}
		echo "</div>";
	}
}

 ?>
