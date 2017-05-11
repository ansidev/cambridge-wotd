<?php
require_once('simple_html_dom.php');

define("WOTD_URL", "http://dictionary.cambridge.org/dictionary/english");
define("WOTD_HTML_CSS_CLASS", ".wotd-hw");
define("WOTD_LINK_CSS_CLASS", ".with-icons__content > a");

// Get Cambridge Word of the day
function get_wotd() {
  // Create DOM from URL or file
  $html = str_get_html(file_get_contents(WOTD_URL));
  if ($html === false) {
    return [
      'error' => 500,
      'message' => 'Could not get word of the day. Please contact ansidev@gmail.com for supporting.'
    ];
  }
  // Find word of the day
  $wotd_html    = $html->find(WOTD_HTML_CSS_CLASS);
  $wotd_meaning = $wotd_html[0]->next_sibling();
  $wotd_link    = $html->find(WOTD_LINK_CSS_CLASS);

  // Build WOTD object
  $wotd = [
    'word'    => $wotd_html[0]->plaintext,
    'meaning' => $wotd_meaning->plaintext,
    'url'     => $wotd_link[0]->href
  ];

  return $wotd;
}

?>