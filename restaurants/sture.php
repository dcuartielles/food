<?php
function scraping_sture(){


	    // create HTML DOM
    $html = file_get_html('http://www.sture.me/extra/lunchmeny');
	// get prices
    $item['times'] = $html->find('div[class="container"]',0)->find('b', 2)->plaintext;
	$item['price'] = $html->find('div[class="container"]',0)->find('b', 3)->plaintext;
	$item['kaffe'] = $html->find('div[class="container"]',0)->find('b', 10)->plaintext;
    $item['prices'] = "";

	//*[@id="content"]/div/div/b[3]
    // get Mon-Fri

	$dayOfWeek = getDayOfWeek('CET');

	for ($x = 8; $x <= 16; $x+=2) {



		if($dayOfWeek==0){
			$y = 0;
		}

		else if($dayOfWeek==1){

			$y = 2;
		}

		else if($dayOfWeek==2){

			$y = 4;
		}

		else if($dayOfWeek==3){

			$y = 6;
		}

		else if($dayOfWeek==4){

			$y = 8;
		}

		$item['day'] = $html->find('div[class="container"]',0)->find('text', 8+$y)->innertext;
		$item['menu'] = $html->find('div[class="container"]',0)->find('text', 9+$y)->plaintext;
		$ret[] = $item;
    }

    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}

function printOut_sture($weekday = -1, $cli = true){

	$ret = scraping_sture();

	// show results on cli
	$countDays = 0;
	if ($cli) {
		echo "STURE\n";
		echo "*********\n";
		foreach($ret as $v) {
			if($countDays == 0) {


				echo $v['times']."\n";
				echo $v['price']."\n";
				echo $v['prices']."\n";
				echo "\n----------------------\n";

			}
			if($countDays >= 0 && $countDays < 5  && $weekday == -1 || $weekday == $countDays) {
				echo $v['day']."\n----------------------";
				echo $v['menu'];
				echo "\n----------------------\n";
				echo $v['kaffe'];
			}
			if($countDays == 6) {
				// nothing to do in this case
			}
			$countDays++;
		}
	} else {
		echo "<div class='restaurantContainer'>";
		echo "<div class='restaurantName'>STURE</div>";
		foreach($ret as $v) {
			if($countDays == 0) {
				echo "<div class='priceContainer'><div class='priceListTitle'>Prices</div>";
				echo "<div class='times'>".$v['times']."</div>";
				echo "<div class='price'>".$v['price']."</div>";
				echo "<div class='dishPriceLine'>".$v['prices']."</div>";
				echo "<div class='kaffe'>".$v['kaffe']."</div>";
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
