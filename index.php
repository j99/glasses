<?php

ini_set('display_errors', true);
define('PATH', dirname(__FILE__) . '/');
header('Content-Type: text/plain');

require 'lib/glasses.php';
require 'test/search.php';

$pro = new Glasses();
$pro->rule('owned', 'from:(:any)', array('Search', 'from'));
$pro->rule('user', '@(:any)', array('Search', 'user'));
$pro->rule('hashtag', '#(:any)', array('Search', 'hashtag'));
$pro->rule('welcome', 'hello world', array('Search', 'welcome'));
// $pro->parse('from:jason');
// $pro->parse('@kiley');
// $pro->parse('#ily');
// $pro->parse('from:jason #ily');
$pro->parse('#ily #fun');
$pro->parse('from:jason @kiley #ily');
$pro->parse('hello world');