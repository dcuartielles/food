<?php
function scraping_thapthim() {
    // create HTML DOM
    $html = file_get_html('http://thapthim.dinstudio.se/empty_8.html');
	// get prices
    $item['times'] = trim($html->find('div[class="ParagraphContainer"]',0)->find('h1', 0)->plaintext, "&nbsp;");
    $item['prices'] = str_replace("/", ", ", trim($html->find('div[class="ParagraphContainer"]',0)->find('h1', 1)->plaintext, "&nbsp;"));
    $item['soupAndSallad'] = trim($html->find('div[class="ParagraphContainer"]',0)->find('h1', 12)->plaintext, "&nbsp;");
    $ret[] = $item;

    // get Mon-Fri
    $countDays = 0;
    $x = 15;
	while ($countDays < 5) {
		// trick to detect an empty string, that happens to come with the ascii 38
		//var_dump($x." - ".ord($html->find('div[class="ParagraphContainer"]',0)->find('h1', $x)->plaintext));
		while (trim($html->find('div[class="ParagraphContainer"]',0)->find('h1', $x)->plaintext, "&nbsp;") == false) {$x++;};
		$item['day'] = $html->find('div[class="ParagraphContainer"]',0)->find('h1', $x)->innertext;
		$item['dayNumber'] = $countDays;
		$item['dishCategory_0'] = $html->find('div[class="ParagraphContainer"]',0)->find('h1', $x+1)->plaintext;
		$item['dishDesc_0'] = $html->find('div[class="ParagraphContainer"]',0)->find('h1', $x+2)->plaintext;
		$item['dishCategory_1'] = $html->find('div[class="ParagraphContainer"]',0)->find('h1', $x+3)->plaintext;
		$item['dishDesc_1'] = $html->find('div[class="ParagraphContainer"]',0)->find('h1', $x+4)->plaintext;
		$ret[] = $item;
		$countDays++;
		$x+=5;
    }

    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}

function printOut_thapthim($weekday = -1, $cli = true) {
	$ret = scraping_thapthim();

	// show results on cli
	$countDays = 0;
	if ($cli) {
		echo "THAPTHIM\n";
		echo "*********\n";
		foreach($ret as $v) {
			if($countDays == 0) {
				echo $v['times']."\n";
				echo $v['prices']."\n";
				echo $v['soupAndSallad']."\n";
				echo "\n----------------------\n";
			}
			if($countDays >= 0 && $countDays < 5  && $weekday == -1 || $weekday == $countDays) {
				echo $v['day']."\n----------------------\n";
				echo $v['dishCategory_0']."\n";
				echo $v['dishDesc_0']."\n";
				echo $v['dishCategory_1']."\n";
				echo $v['dishDesc_1']."\n";
				echo "\n----------------------\n";
			}
			if($countDays == 6) {
				// nothing to do in this case
			}
			$countDays++;
		}
	} else {
		echo "<div class='restaurantContainer'>";
		echo "<div class='restaurantName'>THAPTHIM</div>";
	//	print_r($ret);
		foreach($ret as $v) {
			if($countDays == 0) {
				echo "<div class='priceContainer'><div class='priceListTitle'>Prices</div>";
				echo "<div class='times'>".$v['times']."</div>";
				echo "<div class='times'>".$v['prices']."</div>";
				echo "<div class='dishDesc'>".$v['soupAndSallad']."</div>";
				echo "</div>";
			}
			if($countDays >= 0 && $countDays < 5  && $weekday == -1 || $weekday == $v['dayNumber']) {
				echo "<div class='dayContainer'>";
				echo "<div class='dishDesc'>".$v['day']."</div>";
				echo "<div class='dishType'>".$v['dishCategory_0']."</div>";
				echo "<div class='dishDesc'>".$v['dishDesc_0']."</div>";
				echo "<div class='dishType'>".$v['dishCategory_1']."</div>";
				echo "<div class='dishDesc'>".$v['dishDesc_1']."</div>";
				echo "</div>";
			}
			$countDays++;
		}
		echo "</div>";
	}
}
 ?>
