<?php

$root = dirname(__file__);

require_once("$root/config.php");

$kafka = new Kafka("localhost:9092");

$partitions = $kafka->getPartitionsForTopic('test');
$kafka->setPartition($partitions[0]);//set to first partition

echo "get offset\n";
while(1) {
	$msg = $kafka->consume("test", Kafka::OFFSET_END);
	//print_r($msg);
	//echo "\n";
	$offsets = array_keys($msg);
	if( @$offsets ){
		$offset = $offsets[0];
		print_r($msg);
		break;
		echo "\n";
	}
	var_dump($msg);
	usleep(150);
}

echo "next\n";

while(1) {
	$partitions = $kafka->getPartitionsForTopic('test');
//use it to OPTIONALLY specify a partition to consume from
//if not, consuming IS slower. To set the partition:
	$kafka->setPartition($partitions[0]);//set to first partition
//then consume, for example, starting with the first offset, consume 20 messages
	//$msg = $kafka->consume("test", Kafka::OFFSET_BEGIN,$offset);
	$msg = $kafka->consume("test",$offset + 1);
	//$msg = $kafka->consume("test", Kafka::OFFSET_LA);
	//var_dump($msg);
	$offsets = array_keys($msg);
	if( @$offsets ){
		if ($offset < $offsets[0]) {
			$offset = $offsets[0];
			print_r($msg);
			echo "\n";
		}
		//$offset = $offsets[0];
		//print_r($offset);
		//echo "\n";
	}
	//print_r($msg);
	//echo "\n";
	usleep(150);
}
//var_dump($msg);//dumps array of messages
?>
