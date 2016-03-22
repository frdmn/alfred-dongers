<?php

// Include Alfred PHP lib
require_once('workflow.class.php');

// Function to render the result XML
function render_results($input_array){
  $i = 1;
  $w = new Workflows();
  $results = array();
  foreach ($input_array as $input_item) {
    $temp = array(
        'uid'          => $i,
        'arg'          => $input_item,
        'title'        => $input_item,
    );
    array_push($results, $temp);
    $i++;
  }
  // Return XML
  print $w->toXML($results);
}


// Read and store cached dongers
$donger_cache = $_SERVER['HOME']."/.donger.cache";

// Check if ~/donger.cache exists
if (!file_exists($donger_cache)) {
  $errors[] = 'Warning: no "~/.donger.cache" file found!';
  $errors[] = 'Run "php parser/parser.php > ~/.donger.cache" at least once!';
  render_results($errors);
  exit;
}

$donger_raw = json_decode(file_get_contents($donger_cache));
// Initalize some empty arrays
$catgories = array();
$dongers = array();

// Check for arguments (show only specified category or list categories)
if (isset($argv[1])) {
  // If argument is "list" => list categories
  if ($argv[1] == "list") {
    foreach (array_keys(get_object_vars($donger_raw)) as $category) {
      $catgories[] = $category;
    }
    render_results(array_unique($catgories));
  // If argument is "category" => show dongers of specific category
  } else {
    foreach ($donger_raw->$argv[1] as $donger) {
      $dongers[] = $donger;
    }
    render_results($dongers);
  }
} else {
  // No arguments => show all dongers
  foreach ($donger_raw as $category) {
    foreach ($category as $donger) {
      $dongers[] = $donger;
    }
  }
  render_results($dongers);
}

?>
