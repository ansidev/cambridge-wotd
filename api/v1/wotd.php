<?php
require_once('../../lib/wotd.php');

header('Content-Type: application/json');

$wotd = get_wotd();

// Response data
echo json_encode($wotd);

?>