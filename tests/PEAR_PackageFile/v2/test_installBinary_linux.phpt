--TEST--
PEAR_PackageFile_Parser_v2->installBinary()
--SKIPIF--
<?php
if (!getenv('PHP_PEAR_RUNTESTS')) {
    echo 'skip';
}
?>
--FILE--
<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'setup.php.inc';
require_once 'PEAR/ChannelFile.php';
$pathtopackagexml = dirname(__FILE__)  . DIRECTORY_SEPARATOR .
    'test_installBinary'. DIRECTORY_SEPARATOR . 'foo_win-1.1.0.tgz';
$pathtopackagexml2 = dirname(__FILE__)  . DIRECTORY_SEPARATOR .
    'test_installBinary'. DIRECTORY_SEPARATOR . 'foo_linux-1.1.0.tgz';
$GLOBALS['pearweb']->addHtmlConfig('http://www.example.com/foo_win-1.1.0.tgz', $pathtopackagexml);
$GLOBALS['pearweb']->addXmlrpcConfig('grob', 'package.getDownloadURL',
    array(array('channel' => 'grob', 'package' => 'foo_win', ), 'stable'),
    array('version' => '1.1.0',
          'info' =>
          '<?xml version="1.0"?>
<package version="2.0" xmlns="http://pear.php.net/dtd/package-2.0" xmlns:tasks="http://pear.php.net/dtd/tasks-1.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://pear.php.net/dtd/tasks-1.0
http://pear.php.net/dtd/tasks-1.0.xsd
http://pear.php.net/dtd/package-2.0
http://pear.php.net/dtd/package-2.0.xsd">
 <name>foo_win</name>
 <channel>grob</channel>
 <summary>Main Package</summary>
 <description>Main Package</description>
 <lead>
  <name>Greg Beaver</name>
  <user>cellog</user>
  <email>cellog@php.net</email>
  <active>yes</active>
 </lead>
 <date>2004-09-30</date>
 <version>
  <release>1.1.0</release>
  <api>1.0.0</api>
 </version>
 <stability>
  <release>stable</release>
  <api>stable</api>
 </stability>
 <license uri="http://www.php.net/license/3_0.txt">PHP License</license>
 <notes>test</notes>
 <contents>
  <dir name="/">
   <file baseinstalldir="/" name="main.php" role="php" />
  </dir> <!-- / -->
 </contents>
 <dependencies>
  <required>
   <php>
    <min>4.2</min>
    <max>6.0.0</max>
   </php>
   <pearinstaller>
    <min>1.4.0dev13</min>
   </pearinstaller>
   <os>
    <name>windows</name>
   </os>
  </required>
 </dependencies>
 <phprelease/>
</package>',
          'url' => 'http://www.example.com/foo_win-1.1.0'));
$GLOBALS['pearweb']->addHtmlConfig('http://www.example.com/foo_linux-1.1.0.tgz', $pathtopackagexml2);
$GLOBALS['pearweb']->addXmlrpcConfig('grob', 'package.getDownloadURL',
    array(array('channel' => 'grob', 'package' => 'foo_linux', ), 'stable'),
    array('version' => '1.1.0',
          'info' =>
          '<?xml version="1.0"?>
<package version="2.0" xmlns="http://pear.php.net/dtd/package-2.0" xmlns:tasks="http://pear.php.net/dtd/tasks-1.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://pear.php.net/dtd/tasks-1.0
http://pear.php.net/dtd/tasks-1.0.xsd
http://pear.php.net/dtd/package-2.0
http://pear.php.net/dtd/package-2.0.xsd">
 <name>foo_linux</name>
 <channel>grob</channel>
 <summary>Main Package</summary>
 <description>Main Package</description>
 <lead>
  <name>Greg Beaver</name>
  <user>cellog</user>
  <email>cellog@php.net</email>
  <active>yes</active>
 </lead>
 <date>2004-09-30</date>
 <version>
  <release>1.1.0</release>
  <api>1.0.0</api>
 </version>
 <stability>
  <release>stable</release>
  <api>stable</api>
 </stability>
 <license uri="http://www.php.net/license/3_0.txt">PHP License</license>
 <notes>test</notes>
 <contents>
  <dir name="/">
   <file baseinstalldir="/" name="main.php" role="php" />
  </dir> <!-- / -->
 </contents>
 <dependencies>
  <required>
   <php>
    <min>4.2</min>
    <max>6.0.0</max>
   </php>
   <pearinstaller>
    <min>1.4.0dev13</min>
   </pearinstaller>
   <os>
    <name>linux</name>
   </os>
  </required>
 </dependencies>
 <phprelease/>
</package>',
          'url' => 'http://www.example.com/foo_linux-1.1.0'));

$_test_dep->setPHPVersion('4.3.9');
$_test_dep->setPEARVersion('1.4.0a1');

$cf = new PEAR_ChannelFile;
$cf->setName('grob');
$cf->setServer('grob');
$cf->setSummary('grob');
$cf->setDefaultPEARProtocols();
$reg = &$config->getRegistry();
$reg->addChannel($cf);
$phpunit->assertNoErrors('channel add');

$a = new test_PEAR_Installer($fakelog);
$pf = new test_PEAR_PackageFile_v2;
$pf->setConfig($config);
$pf->setPackageType('extsrc');
$pf->addBinarypackage('foo_win');
$pf->setPackage('foo');
$pf->setChannel('grob');
$pf->setAPIStability('stable');
$pf->setReleaseStability('stable');
$pf->setAPIVersion('1.0.0');
$pf->setReleaseVersion('1.0.0');
$pf->setDate('2004-11-12');
$pf->setDescription('foo source');
$pf->setSummary('foo');
$pf->setLicense('PHP License');
$pf->setLogger($fakelog);
$pf->clearContents();
$pf->addFile('', 'foo.grop', array('role' => 'src'));
$pf->addBinarypackage('foo_linux');
$pf->addMaintainer('lead', 'cellog', 'Greg Beaver', 'cellog@php.net');
$pf->setNotes('blah');
$pf->setPearinstallerDep('1.4.0a1');
$pf->setPhpDep('4.2.0', '5.0.0');
$pf->setProvidesExtension('foo');

$phpunit->assertNotFalse($pf->validate(), 'first pf');

$dp = &newFakeDownloaderPackage(array());
$dp->setPackageFile($pf);
$b = array(&$dp);
$a->setDownloadedPackages($b);
$_test_dep->setOs('linux');
$pf->installBinary($a);
$phpunit->assertNoErrors('post-install linux');
$dld = $last_dl->getDownloadDir();
$cleandld = str_replace('\\\\', '\\', $last_dl->getDownloadDir());
if (OS_WINDOWS) {
    $phpunit->assertEquals(array (
      array (
        0 => 0,
        1 => 'Attempting to download binary version of extension "foo"',
      ),
      array (
        0 => 3,
        1 => '+ tmp dir created at ' . $dld,
      ),
      array (
        0 => 0,
        1 => 'Can only install grob/foo_win on Windows',
      ),
      array (
        0 => 1,
        1 => 'downloading foo_linux-1.1.0.tgz ...',
      ),
      array (
        0 => 1,
        1 => 'Starting to download foo_linux-1.1.0.tgz (723 bytes)',
      ),
      array (
        0 => 1,
        1 => '.',
      ),
      array (
        0 => 1,
        1 => '...done: 723 bytes',
      ),
      array (
        0 => 3,
        1 => '+ cp ' . $cleandld . DIRECTORY_SEPARATOR . 'foo_linux-1.1.0' . DIRECTORY_SEPARATOR .
            'foo.so ' . $ext_dir . DIRECTORY_SEPARATOR . '.tmpfoo.so',
      ),
      array (
        0 => 2,
        1 => 'md5sum ok: ' . $ext_dir . DIRECTORY_SEPARATOR . 'foo.so',
      ),
      array (
        0 => 3,
        1 => 'adding to transaction: rename ' . $ext_dir . DIRECTORY_SEPARATOR .
            '.tmpfoo.so ' . $ext_dir . DIRECTORY_SEPARATOR . 'foo.so 1',
      ),
      array (
        0 => 3,
        1 => 'adding to transaction: installed_as foo.so ' . $ext_dir . DIRECTORY_SEPARATOR .
            'foo.so ' . $ext_dir . ' ' . DIRECTORY_SEPARATOR
      ),
      array (
        0 => 2,
        1 => 'about to commit 2 file operations',
      ),
      array (
        0 => 3,
        1 => '+ mv ' . $ext_dir . DIRECTORY_SEPARATOR . '.tmpfoo.so ' .
            $ext_dir . DIRECTORY_SEPARATOR . 'foo.so',
      ),
      array (
        0 => 2,
        1 => 'successfully committed 2 file operations',
      ),
      array (
        0 => 0,
        1 => 'Download and install of binary extension "grob/foo_linux" successful',
      ),
    ), $fakelog->getLog(), 'log linux');
} else {
    $phpunit->assertEquals(array (
  0 => 
  array (
    0 => 0,
    1 => 'Attempting to download binary version of extension "foo"',
  ),
  1 => 
  array (
    0 => 0,
    1 => 'Can only install grob/foo_win on Windows',
  ),
  2 => 
  array (
    0 => 3,
    1 => '+ tmp dir created at ' . $dld,
  ),
  3 => 
  array (
    0 => 1,
    1 => 'downloading foo_linux-1.1.0.tgz ...',
  ),
  4 => 
  array (
    0 => 1,
    1 => 'Starting to download foo_linux-1.1.0.tgz (723 bytes)',
  ),
  5 => 
  array (
    0 => 1,
    1 => '.',
  ),
  6 => 
  array (
    0 => 1,
    1 => '...done: 723 bytes',
  ),
  7 => 
  array (
    0 => 3,
    1 => '+ cp ' . $cleandld . DIRECTORY_SEPARATOR . 'foo_linux-1.1.0' . DIRECTORY_SEPARATOR .
            'foo.so ' . $ext_dir . DIRECTORY_SEPARATOR . '.tmpfoo.so',
  ),
  8 => 
  array (
    0 => 2,
    1 => 'md5sum ok: ' . $ext_dir . DIRECTORY_SEPARATOR . 'foo.so',
  ),
  9 => 
  array (
    0 => 3,
    1 => 'adding to transaction: chmod 644 ' . $ext_dir . DIRECTORY_SEPARATOR . '.tmpfoo.so',
  ),
  10 => 
  array (
    0 => 3,
    1 => 'adding to transaction: rename ' . $ext_dir . DIRECTORY_SEPARATOR .
            '.tmpfoo.so ' . $ext_dir . DIRECTORY_SEPARATOR . 'foo.so 1',
  ),
  11 => 
  array (
    0 => 3,
    1 => 'adding to transaction: installed_as foo.so ' . $ext_dir . DIRECTORY_SEPARATOR .
            'foo.so ' . $ext_dir . ' ' . DIRECTORY_SEPARATOR
  ),
  12 => 
  array (
    0 => 2,
    1 => 'about to commit 3 file operations',
  ),
  13 => 
  array (
    0 => 3,
    1 => '+ chmod 644 ' . $ext_dir . DIRECTORY_SEPARATOR . '.tmpfoo.so',
  ),
  14 => 
  array (
    0 => 3,
    1 => '+ mv ' . $ext_dir . DIRECTORY_SEPARATOR . '.tmpfoo.so ' .
            $ext_dir . DIRECTORY_SEPARATOR . 'foo.so',
  ),
  15 => 
  array (
    0 => 2,
    1 => 'successfully committed 3 file operations',
  ),
  16 => 
  array (
    0 => 0,
    1 => 'Download and install of binary extension "grob/foo_linux" successful',
  ),
 ), $fakelog->getLog(), 'log linux');
}
$phpunit->assertEquals(array (
  0 => 
  array (
    0 => 'setup',
    1 => 'self',
  ),
  1 => 
  array (
    0 => 'saveas',
    1 => 'foo_linux-1.1.0.tgz',
  ),
  2 => 
  array (
    0 => 'start',
    1 => 
    array (
      0 => 'foo_linux-1.1.0.tgz',
      1 => '723',
    ),
  ),
  3 => 
  array (
    0 => 'bytesread',
    1 => 723,
  ),
  4 => 
  array (
    0 => 'done',
    1 => 723,
  ),
), $fakelog->getDownload(), 'dl log');
$phpunit->assertFileExists($ext_dir . DIRECTORY_SEPARATOR . 'foo.so', 'not installed');
echo 'tests done';
?>
--EXPECT--
tests done