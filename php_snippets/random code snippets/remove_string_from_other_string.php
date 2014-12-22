<?php
$prefix = 'bla_';
$str = 'bla_string_bla_bla_bla';
echo '<hr>Before<hr>';
var_dump($str);
$str = preg_replace('/^' . preg_quote($prefix, '/') . '/', '', $str);
echo '<hr>After<hr>';
var_dump($str);
