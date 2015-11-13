<?php
function scraping_kottbaren() {
  // create HTML DOM
  $html = file_get_html('http://kottbaren.se/malmo/lunch/');

  // get prices
  $item['times'] = $html->find('div[id="post1016"]',0)->find('div[class="postText"]',0)->find('p', 1)->plaintext;
  $item['prices'] = $html->find('div[id="post1016"]',0)->find('div[class="postText"]',0)->find('p', 3)->plaintext;

  // sallad
  $item['soupAndSallad'] = $html->find('div[id="post1016"]',0)->find('div[class="postText"]',0)->find('p', 4)->plaintext;
  $ret[] = $item;

  // get Mon-Fri
  for ($x = 6; $x <= 14; $x+=1) {
    $item['menu'] = $html->find('div[id="post1016"]',0)->find('div[class="postText"]',0)->find('p', $x)->innertext;
    $ret[] = $item;
  }

  $item['contributedBy'] = " Mikaela Ronnqvist et al";
  $ret[] = $item;

  // clean up memory
  $html->clear();
  unset($html);

  return $ret;

}

function printOut_kottbaren($weekday = -1, $cli = true) {
  $ret = scraping_kottbaren();

  // show results on cli
  $countDays = 0;
  if ($cli) {
    echo "Köttbaren\n";
    echo "*********\n";
    foreach($ret as $v) {
      if($countDays == 0) {
        echo $v['times']."\n";
        echo $v['prices']."\n";
        echo $v['soupAndSallad']."\n";
        echo "\n----------------------\n";
      }
      if($countDays > 0 && $countDays < 6 && $weekday == -1 || $weekday == $countDays - 1) {
        echo $v['menu']."\n";
        echo "\n----------------------\n";
      }
      if($countDays == 6) {
        // print out the weekly sallad
        echo $v['menu']."\n";
        echo "\n----------------------\n";
      }
      $countDays++;
    }
  } else {
    echo "<div class='restaurantContainer'>";
    echo "<div class='restaurantName'>Köttbaren</div>";
    foreach($ret as $v) {
      if($countDays == 0) {
        echo "<div class='priceContainer'><div class='priceListTitle'>Prices</div>";
        echo "<div class='times'>".$v['times']."</div>";
        echo "<div class='dishPriceLine'>".$v['prices']."</div>";
        echo "<div class='dishDesc'>".$v['soupAndSallad']."</div>";
        echo "</div>";
      }
      echo "<div class='dayContainer'>";
      if($countDays > 0 && $countDays < 6 && $weekday == -1 || $weekday == $countDays - 1) {
        echo "<div class='dishDesc'>".$v['menu']."</div>";
      }
      echo "</div>";
      if($countDays == 6) {
        // printout the weekly sallad
        echo "<div class='dishDesc'>".$v['menu']."</div>";
      }
      $countDays++;
    }
    echo "</div>";
  }
}
 ?>
