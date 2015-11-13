<?php
function scraping_mandosteakhouse() {
	$html = file_get_html('http://www.mandosteakhouse.com/index.php?option=com_content&view=article&id=47&Itemid=53&lang=sv');

    // get permanent menu
    $item['weekly'] = $html->find('div[id="maincolumn"]',0)->find('table[class="contentpaneopen"]',0)->find('h2', 0)->plaintext;
    $item['weeklyMenu'] = $html->find('div[id="maincolumn"]',0)->find('table[class="contentpaneopen"]',0)->find('p', 0)->plaintext;
    $ret[] = $item;

    // get Mon-Fri
  	for ($x = 1; $x <= 9; $x+=1) {
  	 	$item['menu'] = $html->find('div[id="maincolumn"]',0)->find('table[class="contentpaneopen"]',0)->find('td', 0)->find('p', $x)->plaintext;
  	 	$ret[] = $item;
    }

		$item['contributedBy'] = "Julia Persson et al";
		$ret[] = $item;

     // clean up memory
     $html->clear();
     unset($html);

    return $ret;
	}


function printOut_mandosteakhouse($weekday = -1, $cli = true) {
	$ret = scraping_mandosteakhouse();

	// show results on cli
	$countDays = 0;
	if ($cli) {
		echo "MANDOS STEAKHOUSE\n";
		echo "*********\n";
		foreach($ret as $v) {
      if($countDays == 0) {
  			echo $v['weekly']."\n";
        echo $v['weeklyMenu']."\n";
			}
			if($countDays > 0 && $countDays < 6 && $weekday == -1 || $weekday == $countDays - 1) {
				echo $v['menu']."\n";
			}
			if($countDays == 6) {
				// nothing to do in this case
			}
			$countDays++;
		}
	} else {
		echo "<div class='restaurantContainer'>";
		echo "<div class='restaurantName'>MANDOS STEAKHOUSE</div>";
		foreach($ret as $v) {
			if($countDays == 0) {
			// nothing to do
      echo "<div class='day'>".$v['weekly']."</div>";
      echo "<div class='dishDesc'>".$v['weeklyMenu']."</div>";
			}
			echo "<div class='dayContainer'>";

			if($countDays > 0 && $countDays < 6 && $weekday == -1 || $weekday == $countDays - 1) {
			     echo "DAGENS:";
           echo "<br>";
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
