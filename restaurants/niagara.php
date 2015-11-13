<?php
function scraping_niagara() {
    // create HTML DOM
    $html = file_get_html('http://restaurangniagara.se/lunch/');
	// get preinfo
    // $item['key'] = $html->find('div[class="menucard-content-container"]',0)->find('em', 2)->plaintext;
	// $ret[] = $item;

    // get Mon-Fri
    $countDays = 0;
    foreach($html->find('div[class="lunch"]') as $daily) {
			foreach($daily->find('table') as $dailyMenu) {
				// get day
				$day = trim($daily->find('h3', $countDays)->plaintext);

				// get menu
				foreach($dailyMenu->find('tr') as $menuRow) {
					$item['day'] = $day;
					$item['dayNumber'] = $countDays;
					$item['dishCategory'] = trim($menuRow->find('td', 0)->plaintext);
					$item['dishDesc'] = trim($menuRow->find('td', 1)->plaintext);
					$item['dishPrice'] = trim($menuRow->find('td', 2)->plaintext);

					$ret[] = $item;
				}

				// increase the counter
				$countDays++;
			}
	}




    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}

function printOut_niagara($weekday = -1, $cli = true) {
	$ret = scraping_niagara();

	// show results on cli
	$countDays = 0;
	if ($cli) {
		echo "NIAGARA\n";
		echo "*********\n";
		$init = -1;
		foreach($ret as $v) {
			if ($v['dayNumber'] == $weekday || $weekday == -1) {
				if ($init != $v['day']) {
					if ($init != -1) echo "\n----------------------\n";
					echo $v['day']."\n----------------------\n";
					$init = $v['day'];
				}
				echo $v['dishCategory']."\t";
				echo $v['dishDesc']."\t";
				echo $v['dishPrice']."\n";
			}
		}
	} else {
		echo "<div class='restaurantContainer'>";
		echo "<div class='restaurantName'>NIAGARA</div>";
		$init = -1;
		foreach($ret as $v) {
			if ($v['dayNumber'] == $weekday || $weekday == -1) {
				if ($init != $v['day']) {
					if ($init != -1) echo "</div>";
					echo "<div class='day'>".$v['day']."</div>";
					echo "<div class='dayContainer'>";
					$init = $v['day'];
				}
				echo "<div class='dishType'>".$v['dishCategory']."</div>";
				echo "<div class='dishDesc'>".$v['dishDesc']."</div>";
				echo "<div class='dishPrice'>".$v['dishPrice']."</div>";
			}
		}
		echo "</div></div>";
	}
}
 ?>
