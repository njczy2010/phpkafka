<?php

$G_ROOT = dirname(__FILE__);

##JSON format
# {"remote_addr":"123.59.102.50","remote_user":"-","time_local":"2016-08-01T17:01:00+08:00","http_host":"e4fe210f8.bsclink.com","api_id":"193","api_path_id":"1153","caller_id":"0","method":"GET","request_uri":"/monitor?format=json&service=halfasync&nginx_ip=123.59.102.47","uri":"/monitor","request_time":"0.152","status":"200","upstream_addr":"124.239.189.15:8080","upstream_status":"200","upstream_response_time":"0.152","request_length":"120","body_bytes_sent":"38","http_referer":"-","http_user_agent":"-","http_x_forwarded_for":"-","upstream_cache_status":"MISS","hostname":"bgp-beijing-beijing-1-123-59-102-47"}

# {"remote_addr":"$remote_addr","remote_user":"$remote_user","time_local":"$time_iso8601","http_host":"$http_host","api_id":"$api_id","api_path_id":"$api_path_id","caller_id":"$caller_id","method":"$request_method","request_uri":"$request_uri","uri":"$orignal_uri","request_time":"$request_time","status":"$status","upstream_addr":"$upstream_addr","upstream_status":"$upstream_status","upstream_response_time":"$upstream_response_time","request_length":"$request_length","body_bytes_sent":"$body_bytes_sent","http_referer":"$http_referer","http_user_agent":"$http_user_agent","http_x_forwarded_for":"$http_x_forwarded_for","upstream_cache_status":"$upstream_cache_status","hostname":"$hostname"}

$G_CONFIG["remote_user"] = array (
	"0" => "-",
);

$G_CONFIG["time_iso8601"] = array (
	"0" => "2016-08-01T17:01:00+08:00",
);

$G_CONFIG["http_host"] = array (
	"0" => "www.baidu.com",
	"1" => "pubads.g.doubleclick.net",
	"2" => "win.fcai.com",
	"3" => "www.12377.cn",
	"4" => "jubao.12377.cn",
	"5" => "mp.weixin.qq.com",
	"6" => "www.fengjr.com",
	"7" => "weidian.com",
	"8" => "www.taiwan.cn",
	"9" => "news.dayoo.com",
);

$G_CONFIG["request_method"] = array (
	"0" => "GET",
	"1" => "POST",
	"2" => "PUT",
	"3" => "DELETE",
	"4" => "PATCH",
	"5" => "OPTIONS",
	"6" => "COPY",
	"7" => "HEAD",
);

$G_CONFIG["request_uri"] = array (
	"0" => "/monitor?format=json&service=halfasync&nginx_ip=123.59.102.47",
);

$G_CONFIG["orignal_uri"] = array (
	"0" => "/monitor",
);

$G_CONFIG["http_referer"] = array (
	"0" => "-",
);

$G_CONFIG["http_user_agent"] = array (
	"0" => "-",
);

$G_CONFIG["http_x_forwarded_for"] = array (
	"0" => "-",
);

$G_CONFIG["upstream_cache_status"] = array (
	"0" => "MISS",
);

?>
