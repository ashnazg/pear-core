--TEST--
System::_parseArgs with quoted values
--SKIPIF--
<?php
if (!getenv('PHP_PEAR_RUNTESTS')) {
    echo 'skip ';
}
?>
--FILE--
<?php

require_once 'System.php';

$args = '-t \'R:\applications\PHP 5.3\tmp\' -d pear';
$opts = System::_parseArgs($args, 't:d');
var_export($opts); echo "\n";

$args = '-t "R:\applications\PHP 5.3\tmp" -d pear';
$opts = System::_parseArgs($args, 't:d');
var_export($opts); echo "\n";

$args = '-t \'/tmp/pear install/temp\' -d pear';
$opts = System::_parseArgs($args, 't:d');
var_export($opts); echo "\n";

$args = '-t "/tmp/pear install/temp" -d pear';
$opts = System::_parseArgs($args, 't:d');
var_export($opts); echo "\n";

?>
--EXPECT--
array (
  0 => 
  array (
    0 => 
    array (
      0 => 't',
      1 => 'R:\\applications\\PHP 5.3\\tmp',
    ),
    1 => 
    array (
      0 => 'd',
      1 => NULL,
    ),
  ),
  1 => 
  array (
    0 => 'pear',
  ),
)
array (
  0 => 
  array (
    0 => 
    array (
      0 => 't',
      1 => 'R:\\applications\\PHP 5.3\\tmp',
    ),
    1 => 
    array (
      0 => 'd',
      1 => NULL,
    ),
  ),
  1 => 
  array (
    0 => 'pear',
  ),
)
array (
  0 => 
  array (
    0 => 
    array (
      0 => 't',
      1 => '/tmp/pear install/temp',
    ),
    1 => 
    array (
      0 => 'd',
      1 => NULL,
    ),
  ),
  1 => 
  array (
    0 => 'pear',
  ),
)
array (
  0 => 
  array (
    0 => 
    array (
      0 => 't',
      1 => '/tmp/pear install/temp',
    ),
    1 => 
    array (
      0 => 'd',
      1 => NULL,
    ),
  ),
  1 => 
  array (
    0 => 'pear',
  ),
)
