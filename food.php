<?php
include_once('simple_html_dom.php');

$debug = "";

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

function printOut_noWork($cli = true) {
	
	if ($cli) {
		echo "It's a no-food day, what if you went home to eat?";
	} else {
		echo "<div class='restaurantContainer'>";
		echo "<div class='restaurantName'>GOTTA BE WEEKEND</div>";
		echo "<div class='dayContainer'>";
		echo "It's a no-food day, what if you went home to eat?";
		echo "</div></div>";		
	}
}

function getDayOfWeek($pTimezone)
{

    $userDateTimeZone = new DateTimeZone($pTimezone);
    $UserDateTime = new DateTime("now", $userDateTimeZone);

    $offsetSeconds = $UserDateTime->getOffset(); 
    //echo $offsetSeconds;

    return gmdate("w", time() + $offsetSeconds) - 1;
}

// -----------------------------------------------------------------------------
// test it!

$dayOfWeek = getDayOfWeek('CET');

echo "<html><head><title>F * O * O * D</title>";
echo "<link rel='stylesheet' type='text/css' href='food.css'>";
echo '<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>';
echo "</head><body>";
echo "<div id='tableContainer'><div class='column'>";

// make sure to give alternatives for the weekend
if ($dayOfWeek > 4 || $dayOfWeek < 0) {
	printOut_noWork(false);
} else {
	printOut_miamarias($dayOfWeek, false);
	echo "</div><div class='column'>";
	printOut_meck($dayOfWeek, false);
	echo "</div><div class='column'>";
	printOut_niagara($dayOfWeek, false);
	echo "</div><div class='column'>";
	printOut_orkanen($dayOfWeek, false);
	echo "</div><div class='column'>";
	printOut_lillakoket($dayOfWeek, false);
	echo "</div><div class='column'>";
	printOut_valfarden($dayOfWeek, false);
	echo "</div><div class='column'>";
	printOut_thapthim($dayOfWeek, false);
	echo "</div><div class='column'>";
	printOut_sture($dayOfWeek, false;
}

echo "</div></div>";
echo "<div class='debug'>".$debug."</div>";
echo "</body></html>";

?>
