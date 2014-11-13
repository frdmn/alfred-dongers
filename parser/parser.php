<?php
// Include SimpleHTMLDOM class
require('simplehtmldom.php');

// Init empty array
$dongers = array();
$categories = array();

/*
 * Parse available categories
 */

// Initial request to parse available categories
$html = file_get_html('http://dongerlist.com');

// Store DOM in variable
$parsed_categories = $html->find('a.list-2-anchor');

// Push to array
foreach ($parsed_categories as $parsed_category) {
  // Push all elements except the "All" one to array
  if ($parsed_category->plaintext != "All") {
    array_push($categories, $parsed_category->plaintext);
  }
}

/*
 * Parse dongers per category
 */

// For each available category
foreach ($categories as $category) {
  // Parse available pages for specific cateogory
  $html = file_get_html('http://dongerlist.com/category/'.$category);

  // Find available pages
  $page_current = $html->find('.wp-pagenavi .current', 0);
  $page_last = $html->find('.wp-pagenavi .last', 0);

  // Check if pagination available
  if ($page_current && $page_last) {
    // While theres a new page available
    while ($page_current <= $page_last) {
    // Pagination found => multiple pages for that specific category
    $html = file_get_html('http://dongerlist.com/category/'.$category.'/page/'.$page_current);
      foreach($html->find('.list-1-item') as $donger) {
        // Create tiny array per each donger to save meta data like category
        $item['donger'] = $donger->find('.donger', 0)->plaintext;
        $item['category'] = strtolower($category);
        // Push to $dongers[] array
        array_push($dongers, $item);
      }
      // Continue with next page
      $page_current++;
    }
  } else {
    // No pagination => only one page of dongers
    foreach($html->find('.list-1-item') as $donger) {
        // Create tiny array per each donger to save meta data like category
        $item['donger'] = $donger->find('.donger', 0)->plaintext;
        $item['category'] = strtolower($category);
        // Push to $dongers[] array
        array_push($dongers, $item);
    }
  }
}

// Encode as json
echo json_encode($dongers);

?>
