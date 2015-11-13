<?php
// made by Jesper Andersson jeppe.design and Freyja Bjornsdottir bjornsdottir.com
function scraping_fredag49(){
  $html = file_get_html("http://www.freda49.se/lunch-malmo.html");

  $item[time] = $html->find('p',3);
  $item[price] = $html->find('p',5);
  $ret[] = $item;

  $x = 0;

  while ($x < 21) {
    $item[day] = $html->find('p',10+$x);
    $x++;
    $item[husman] = $html->find('p',10+$x);
    $x++;
    $item[halsa] = $html->find('p',10+$x);
    $x++;
    $item[veg] = $html->find('p',10+$x);
    $x++;
    $x++;

    $ret[] = $item;
  }

  $item['contributedBy'] = "Freyja and Jesper";
  $ret[] = $item;

  return $ret;

}

function printOut_fredag49($weekday = -1, $cli = true){

  $ret = scraping_fredag49();

  $countDays = 0;

  echo "<div class='restaurantContainer'>";
  echo "<div class='restaurantName'>FREDA49</div>";

  echo "<div class='priceContainer'><div class='priceListTitle'>Prices</div>";
  echo $ret[0]['price'];
  echo $ret[0]['time'];
  echo "</div>";

  echo $ret[$weekday+1]['day'];
  echo $ret[$weekday+1]['halsa'];
  echo $ret[$weekday+1]['husman'];
  echo $ret[$weekday+1]['veg'];
  echo "</div>";

}
?>
