<?php
require('simplehtmldom.php');

$html = file_get_html('http://dongerlist.com');

$array_limit="50";

// Find available pages
$page_current = trim($html->find('.wp-pagenavi .current', 0)->plaintext);
$page_last = trim($html->find('.wp-pagenavi .last', 0)->plaintext);
$page_random = rand($page_current, $page_last);

$html = file_get_html('http://dongerlist.com/page/'.$page_random);

// Init empty array
$dongers[] = array();
$i = 0;

foreach($html->find('.list-1-item') as $donger) {
  $plaintext = $donger->find('.donger', 0)->plaintext;
  if ($array_limit > $i) {
    array_push($dongers, $plaintext);
    $i++;
  } else {
    echo "[INFO] Array limit exceeded (".$array_limit." > ".$i.")";
    return 1;
  }
}

var_dump($dongers);

?>
