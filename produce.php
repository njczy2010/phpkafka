<?php

$root = dirname(__file__);

require_once("$root/config.php");

$kafka = new Kafka("localhost:9092");

function create_message() {	
	$num = mt_rand(0,9);
	$host = $GLOBALS["G_CONFIG"]["host"]["$num"];

	$client_ip = "" . mt_rand(0,255) . "." . mt_rand(0,255) . "." . mt_rand(0,255) . "." . mt_rand(0,255);

	$num2 = mt_rand(0,7);
	$method = $GLOBALS["G_CONFIG"]["method"]["$num2"];

	$ua = $GLOBALS["G_CONFIG"]["ua"]["0"];

	$refer = $GLOBALS["G_CONFIG"]["refer"]["0"];

	$product = "/" . md5(mt_rand() );
	$message = array (
		"host" => $host,
		"client_ip" => $client_ip,
		"method" => $method,
		"product" => $product,
		"ua" => $ua,
		"product" => $product,
	);
	$json = json_encode($message);
	print_r($json);
	echo "\n";
	return $json;
}

while(1) {
	$json = create_message();
	$kafka->produce("test", $json);
	//get all the available partitions
	$partitions = $kafka->getPartitionsForTopic('test');
//use it to OPTIONALLY specify a partition to consume from
//if not, consuming IS slower. To set the partition:
	$kafka->setPartition($partitions[0]);//set to first partition
//then consume, for example, starting with the first offset, consume 20 messages
	$msg = $kafka->consume("test", Kafka::OFFSET_BEGIN, 20);
	usleep(300);
}
//var_dump($msg);//dumps array of messages
?>
