--TEST--
leveldb - options open options
--SKIPIF--
<?php include 'skipif.inc'; ?>
--FILE--
<?php

include "leveldb.inc";
cleanup_leveldb_on_shutdown();

$leveldb_path = dirname(__FILE__) . '/leveldb_options.test-db';

try {
	$db = new LevelDB($leveldb_path, array("create_if_missing" => false));
} catch(LevelDBException $e) {
	echo $e->getMessage() . "\n";
}

try {
	$db = new LevelDB($leveldb_path, array("max_open_files" => 10));
	$db->set("key", "value");
	var_dump($db->get("key"));
} catch(LevelDBException $e) {
	echo $e->getMessage() . "\n";
}

$db->close();
try {
	$db = new LevelDB($leveldb_path, array("error_if_exists" => true));
} catch(LevelDBException $e) {
	echo $e->getMessage() . "\n";
}
?>
==DONE==
--EXPECTF--
Invalid argument: %s: does not exist (create_if_missing is false)
string(5) "value"
Invalid argument: %s: exists (error_if_exists is true)
==DONE==
