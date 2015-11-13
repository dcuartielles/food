<?php
include_once('simple_html_dom.php');

// include all of the restaurants in the corresponding folder
foreach (glob("restaurants/*.php") as $filename)
{
    include $filename;
}

$debug = "";



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
/*
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
  printOut_lagrappa($dayOfWeek, false);
  echo "</div><div class='column'>";
  printOut_mandosteakhouse($dayOfWeek, false);
  echo "</div><div class='column'>";
  printOut_kottbaren($dayOfWeek, false);
  echo "</div><div class='column'>";
  printOut_fredag49($dayOfWeek, false);
  echo "</div><div class='column'>";
  printOut_malmoopera($dayOfWeek, false);
  echo "</div><div class='column'>";
  printOut_redfellas($dayOfWeek, false);
  echo "</div><div class='column'>";
  printOut_rootz($dayOfWeek, false);
  echo "</div><div class='column'>";
  printOut_thaithai($dayOfWeek, false);
  echo "</div><div class='column'>";
  */
	printOut_sture($dayOfWeek, false);
}

echo "</div></div>";
echo "<div class='debug'>".$debug."</div>";
echo "</body></html>";

?>
