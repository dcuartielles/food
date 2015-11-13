<?php
function scraping_rootz() {
    // create HTML DOM
    $html = file_get_html('http://rootzberlin.tumblr.com/');

    //Date
        $item['date'] = $html->find('section[id="posts"]',0)->find('div',0)->find('article', 0)->find('div', 0)->find('section[class="post"]', 0)->find('div[class="post-content"]', 0)->find('h2', 0)->plaintext;

    //Soups
    $item['soups'] = $html->find('section[id="posts"]',0)->find('div',0)->find('article', 0)->find('div', 0)->find('section[class="post"]', 0)->find('div[class="post-content"]', 0)->find('div[class="body-text"]', 0)->find('p', 0)->plaintext;

    //special
   $item['special'] = $html->find('section[id="posts"]',0)->find('div',0)->find('article', 0)->find('div', 0)->find('section[class="post"]', 0)->find('div[class="post-content"]', 0)->find('div[class="body-text"]', 0)->find('p', 1)->plaintext;

    //burger
   $item['burger'] = $html->find('section[id="posts"]',0)->find('div',0)->find('article', 0)->find('div', 0)->find('section[class="post"]', 0)->find('div[class="post-content"]', 0)->find('div[class="body-text"]', 0)->find('p', 2)->plaintext;

    //today
    $theday= getdate();
    $printed_date = "".$theday['mday'].".".$theday['mon'].".".$theday['year']."";
    $item['thisday'] = $printed_date;


    //put it in the return-array
    $ret[] = $item;
    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}

function printOut_rootz($weekday = -1, $cli = true) {
        $ret = scraping_rootz();
//      echo $ret['burger'];
        // show results on cli
        $countDays = 0;
        if ($cli) {
          foreach($ret as $v) {
            if($v['date'] == $v['thisday']){
                echo "rootz";
                echo "*********\n";
                echo "<div class='date'><h4>Date:\t".$v['date']."</h4></div>";
                echo "<div class='soups'>".$v['soups']."</div>";
                echo "<div class='special'><br>".$v['special']."</div>";
                echo "<div class='burger'><br>".$v['burger']."<br></div>";
            }
          }
        } else {
          echo "<div class='restaurantContainer'>";
          echo "<div class='restaurantName'>ROOTZ BERLIN</div>";
          foreach($ret as $v) {
            if($countDays == 0) {
              //Check if a new post is up today, if not, print out a message
              if($v['date'] == $v['thisday']){
                echo "<div class='date'><h4>Date:\t".$v['date']."</h4></div>";
                echo "<div class='soups'>".$v['soups']."</div>";
                echo "<div class='special'><br>".$v['special']."</div>";
                echo "<div class='burger'><br>".$v['burger']."<br></div>";
                // echo "<div class='thisday'><br>".$v['thisday']."</div>";
                echo "</div>";
              }else{
                echo "<div class='no_daily'><br>Sorry, no daily specials today, try the regular menu. <br>love u</div>";
              }
            }
            echo "</div>";
          }
          echo "</div>";
        }
}
 ?>
