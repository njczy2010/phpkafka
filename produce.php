<?php

$root = dirname(__file__);

require_once("$root/config.php");

$kafka = new Kafka("localhost:9092");

function create_message() {	
	$remote_addr = "" . mt_rand(0,255) . "." . mt_rand(0,255) . "." . mt_rand(0,255) . "." . mt_rand(0,255);

	$remote_user = $GLOBALS["G_CONFIG"]["remote_user"]["0"];

	$time_iso8601 = $GLOBALS["G_CONFIG"]["time_iso8601"]["0"];

	$num = mt_rand(0,10);
	$http_host = $GLOBALS["G_CONFIG"]["http_host"]["$num"];

	$api_id = mt_rand(0,1000);

	$api_path_id = mt_rand(0,100000);

	$caller_id = mt_rand(0,1000);

	$num2 = mt_rand(0,7);
	$request_method = $GLOBALS["G_CONFIG"]["request_method"]["$num2"];

	$num3 = mt_rand(0,0);
	$request_uri = $GLOBALS["G_CONFIG"]["request_uri"]["$num3"];

	$num4 = mt_rand(0,0);
	$orignal_uri = $GLOBALS["G_CONFIG"]["orignal_uri"]["$num4"];

	$request_time = (double)mt_rand(0,1000) / 1000;

	$status = 100 * mt_rand(2,5) + mt_rand(0,5);

	$upstream_addr = "" . mt_rand(0,255) . "." . mt_rand(0,255) . "." . mt_rand(0,255) . "." . mt_rand(0,255) . ":8080";

	$upstream_status = 100 * mt_rand(2,5) + mt_rand(0,5);

	$upstream_response_time = (double)mt_rand(0,1000) / 1000;

	$request_length = mt_rand(0,1000);

	$body_bytes_sent = mt_rand(0,100);

	$http_referer = $GLOBALS["G_CONFIG"]["http_referer"]["0"];

	$http_user_agent = $GLOBALS["G_CONFIG"]["http_user_agent"]["0"];

	$http_x_forwarded_for = $GLOBALS["G_CONFIG"]["http_x_forwarded_for"]["0"];

	$upstream_cache_status = $GLOBALS["G_CONFIG"]["upstream_cache_status"]["0"];

	$hostname = md5(mt_rand() );
	$message = array (
		"remote_addr" => $remote_addr,
		"remote_user" => $remote_user,
		"time_local" => $time_iso8601,
		"http_host" => $http_host,
		"api_id" => $api_id,
		"api_path_id" => $api_path_id,
		"caller_id" => $caller_id,
		"method" => $request_method,
		"request_uri" => $request_uri,
		"uri" => $orignal_uri,
		"request_time" => $request_time,
		"status" => $status,
		"upstream_addr" => $upstream_addr,
		"upstream_status" => $upstream_status,
		"upstream_response_time" => $upstream_response_time,
		"request_length" => $request_length,
		"body_bytes_sent" => $body_bytes_sent,
		"http_referer" => $http_referer,
		"http_user_agent" => $http_user_agent,
		"http_x_forwarded_for" => $http_x_forwarded_for,
		"upstream_cache_status" => $upstream_cache_status,
		"hostname" => $hostname,
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
