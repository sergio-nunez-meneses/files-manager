<?php

// server protocol
$protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
// domain name
$domain = $_SERVER['SERVER_NAME'];
// concatenate variables to get the base url
$base_url = "${protocol}://${domain}";

?>
