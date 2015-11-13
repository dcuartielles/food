<?php
function scraping_lagrappa() {
        $html = file_get_html('http://lagrappa.se/meny/lunch-meny/');

        $item['day'] = $html->find('div[class="et_pb_column et_pb_column_1_3 et_pb_column_1"]', 0)->find('p', 0)->plaintext;
        $item['menu'] = $html->find('div[class="et_pb_column et_pb_column_1_3 et_pb_column_1"]', 0)->find('p', 1)->plaintext;

        $item['weeklyItalian'] = $html->find('div[class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_center  et_pb_text_6"]', 0)->find('p', 0)->plaintext;
        $item['menuItalian'] = $html->find('div[class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_center  et_pb_text_6"]', 0)->find('p', 1)->plaintext;

        $item['weeklyVegetarian'] = $html->find('div[class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_center  et_pb_text_8"]', 0)->find('p', 0)->plaintext;
        $item['menuVegetarian'] = $html->find('div[class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_center  et_pb_text_8"]', 0)->find('p', 1)->plaintext;

        $item['weeklyBusiness'] = $html->find('div[class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_center  et_pb_text_7"]', 0)->find('p', 0)->plaintext;
        $item['menuBusiness'] = $html->find('div[class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_center  et_pb_text_7"]', 0)->find('p', 1)->plaintext;

        $ret[] = $item;

        $item['day'] = $html->find('div[class="et_pb_column et_pb_column_1_3 et_pb_column_1"]', 0)->find('p', 2)->plaintext;
        $item['menu'] = $html->find('div[class="et_pb_column et_pb_column_1_3 et_pb_column_1"]', 0)->find('p', 3)->plaintext;
        $ret[] = $item;

        $item['day'] = $html->find('div[class="et_pb_column et_pb_column_1_3 et_pb_column_1"]', 0)->find('p', 4)->plaintext;
        $item['menu'] = $html->find('div[class="et_pb_column et_pb_column_1_3 et_pb_column_1"]', 0)->find('p', 5)->plaintext;
        $ret[] = $item;

        $item['day'] = $html->find('div[class="et_pb_column et_pb_column_1_3 et_pb_column_2"]', 0)->find('p', 0)->plaintext;
        $item['menu'] = $html->find('div[class="et_pb_column et_pb_column_1_3 et_pb_column_2"]', 0)->find('p', 1)->plaintext;
        $ret[] = $item;

        $item['day'] = $html->find('div[class="et_pb_column et_pb_column_1_3 et_pb_column_2"]', 0)->find('p', 2)->plaintext;
        $item['menu'] = $html->find('div[class="et_pb_column et_pb_column_1_3 et_pb_column_2"]', 0)->find('p', 3)->plaintext;
        $ret[] = $item;

        $item['contributedBy'] = "Anton Ornberg et al";

        $ret[] = $item;

        $html->clear();
        unset($html);

        return $ret;
}

function printOut_lagrappa($weekday = -1, $cli = true) {
        $ret = scraping_lagrappa();

        $countDays = 0;
        if ($cli) {
          echo "LA GRAPPA\n";
          echo "*********\n";
          foreach($ret as $item) {
            if($countDays == 0) {
              echo $item['weeklyItalian']."\n";
              echo $item['menuItalian']."\n";
              echo $item['weeklyVegetarian']."\n";
              echo $item['menuVegetarian']."\n";
              echo $item['weeklyBusiness']."\n";
              echo $item['menuBusiness']."\n";
            }
            if($countDays > 0 && $countDays < 6 && $weekday == -1 || $weekday == $countDays - 1) {
              echo $item['day']."\n";
              echo $item['menu']."\n";
              echo "\n----------------------\n";
            }
            $countDays++;
          }
        } else {
          echo "<div class='restaurantContainer'>";
          echo "<div class='restaurantName'>LA GRAPPA</div>";

          foreach($ret as $item) {
            if($countDays == 0) {
              echo "<div class='day'>".$item['weeklyItalian']."</div><div class='dishDesc'>".$item['menuItalian']."</div>";
              echo "<div class='day'>".$item['weeklyVegetarian']."</div><div class='dishDesc'>".$item['menuVegetarian']."</div>";
              echo "<div class='day'>".$item['weeklyBusiness']."</div><div class='dishDesc'>".$item['menuBusiness']."</div>";
            }
            if($countDays > 0 && $countDays < 6 && $weekday == -1 || $weekday == $countDays - 1) {
              echo "<div class='day'>".$item['day']."</div>";

              //echo "<div class='dayContainer'>";
              echo "<div class='dishDesc'>".$item['menu']."</div>";
              echo "</div>";
            }

            $countDays++;
          }
        echo "</div>";
      }
}
 ?>
