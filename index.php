<?php

require_once 'vendor/autoload.php';

echo '<h1>Get: </h1>';
echo '<pre>';
print_r($_GET);
echo '</pre>';
echo '<h1>Post: </h1>';
echo '<pre>';
print_r($_POST);
echo '</pre>';

echo '<pre>';
print_r($_SERVER);
echo '</pre>';