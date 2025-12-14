--TEST--
PEAR_RunTest --STDIN--
--SKIPIF--
<?php
if (!getenv('PHP_PEAR_RUNTESTS')) {
    echo 'skip';
}
?>
--STDIN--
hello world
--FILE--
<?php
$fp = fopen('php://stdin', 'r');
$contents = fread($fp, 8192);
fclose($fp);
var_export(trim($contents));
?>
--EXPECT--
 'hello world'
