<?php

ini_set('display_errors', true);
header('Content-Type: text/plain');

require '../lib/glasses.php';
require './search.php';

$pro = new Glasses();
$pro->rule('owned', 'from:(:any)', array('Search', 'from'));
$pro->rule('user', '@(:any)', array('Search', 'user'));
$pro->rule('hashtag', '#(:any)', array('Search', 'hashtag'));
$pro->rule('welcome', 'hello world', array('Search', 'welcome'));
$pro->parse('from:jason @kiley #ily');
$pro->parse('hello world');