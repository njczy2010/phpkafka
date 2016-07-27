# phpkafka
php send message (json) to kafka  


prepare kafka and phpkafka environment:  
[http://www.cnblogs.com/njczy2010/p/5711729.html][1]  

or  

Kafka入门经典教程

[http://www.aboutyun.com/thread-12882-1-1.html][2]


二、环境搭建


Step 1: 下载Kafka

[https://www.apache.org/dyn/closer.cgi?path=/kafka/0.8.1/kafka_2.9.2-0.8.1.1.tgz][3]

点击下载最新的版本并解压.


    tar -xzf kafka_2.9.2-0.8.1.1.tgz
    cd kafka_2.9.2-0.8.1.1

Step 2: 启动服务

Kafka用到了Zookeeper，所有首先启动Zookper，下面简单的启用一个单实例的Zookkeeper服务。可以在命令的结尾加个&符号，这样就可以启动后离开控制台。

    bin/zookeeper-server-start.sh config/zookeeper.properties &

[2013-04-22 15:01:37,495] INFO Reading configuration from: config/zookeeper.properties (org.apache.zookeeper.server.quorum.QuorumPeerConfig)
...



现在启动Kafka:

    bin/kafka-server-start.sh config/server.properties

[2013-04-22 15:01:47,028] INFO Verifying properties (kafka.utils.VerifiableProperties)
[2013-04-22 15:01:47,051] INFO Property socket.send.buffer.bytes is overridden to 1048576 (kafka.utils.VerifiableProperties)
...


Step 3: 创建 topic

创建一个叫做“test”的topic，它只有一个分区，一个副本。

    bin/kafka-topics.sh --create --zookeeper localhost:2181 --replication-factor 1 --partitions 1 --topic test

可以通过list命令查看创建的topic:

    bin/kafka-topics.sh --list --zookeeper localhost:2181

test

除了手动创建topic，还可以配置broker让它自动创建topic.

Step 4:发送消息.

Kafka 使用一个简单的命令行producer，从文件中或者从标准输入中读取消息并发送到服务端。默认的每条命令将发送一条消息。

运行producer并在控制台中输一些消息，这些消息将被发送到服务端：

    bin/kafka-console-producer.sh --broker-list localhost:9092 --topic test

This is a message  
This is another message  

ctrl+c可以退出发送。

Step 5: 启动consumer

Kafka also has a command line consumer that will dump out messages to standard output.
Kafka也有一个命令行consumer可以读取消息并输出到标准输出：

    bin/kafka-console-consumer.sh --zookeeper localhost:2181 --topic test --from-beginning

This is a message
This is another message

你在一个终端中运行consumer命令行，另一个终端中运行producer命令行，就可以在一个终端输入消息，另一个终端读取消息。
这两个命令都有自己的可选参数，可以在运行的时候不加任何参数可以看到帮助信息。

php kafka:

[http://www.alliedjeep.com/18625.htm][4]

 

1、安装librdkafka

cd /usr/local/src #进入安装包存放目录

    wget https://github.com/edenhill/librdkafka/archive/master.zip #下载
    
    mv master.zip librdkafka-master.zip #修改包名
    
    unzip librdkafka-master.zip #解压
    
    cd librdkafka-master #进入安装文件夹
    
    ./configure #配置
    
    make #编译
    
    make install #安装

2、安装phpkafka

    cd /usr/local/src #进入安装包存放目录
    
    wget https://github.com/EVODelavega/phpkafka/archive/master.zip #下载
    
    mv master.zip phpkafka-master.zip #修改包名
    
    unzip phpkafka-master.zip #解压
    
    cd phpkafka-master #进入安装文件夹
    
    /usr/local/php/bin/phpize #加载php扩展模块
    
    ./configure --enable-kafka --with-php-config=/usr/local/php/bin/php-config #配置
    
    make #编译
    
    make install #安装

3、修改php配置文件

    vi /usr/local/php/etc/php.ini #打开php配置文件，在最后一行添加下面的代码
    
    extension="kafka.so"
    
    :wq! #保存退出

 

[https://github.com/EVODelavega/phpkafka][5]

Requirements:

Download and install librdkafka. Run sudo ldconfig to update shared libraries.

Installing PHP extension:

    phpize
    ./configure --enable-kafka
    make
    sudo make install
    sudo sh -c 'echo "extension=kafka.so" >>
    /etc/php5/conf.d/kafka.ini'
    #For CLI mode:
    sudo sh -c 'echo "extension=kafka.so" >>
    /etc/php5/cli/conf.d/20-kafka.ini'

Examples:

    // Produce a message
    $kafka = new Kafka("localhost:9092");
    $kafka->produce("topic_name", "message content");
    //get all the available partitions
    $partitions = $kafka->getPartitionsForTopic('topic_name');
    //use it to OPTIONALLY specify a partition to consume from
    //if not, consuming IS slower. To set the partition:
    $kafka->setPartition($partitions[0]);//set to first partition
    //then consume, for example, starting with the first offset,
    consume 20 messages
    $msg = $kafka->consume("topic_name", Kafka::OFFSET_BEGIN, 20);
    var_dump($msg);//dumps array of messages

php kafka 例子：

[https://github.com/njczy2010/phpkafka][6]

    <?php
    $root = dirname(__file__);
    require_once("$root/config.php");
    $kafka = new Kafka("localhost:9092");
        function create_message() {	
        $num = mt_rand(0,9);
        $host = $GLOBALS["G_CONFIG"]["host"]["$num"];
        $client_ip = "" . mt_rand(0,255) . "." . mt_rand(0,255) .
        "." . mt_rand(0,255) . "." . mt_rand(0,255);
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


  [1]: http://www.cnblogs.com/njczy2010/p/5711729.html
  [2]: http://www.aboutyun.com/thread-12882-1-1.html
  [3]: https://www.apache.org/dyn/closer.cgi?path=/kafka/0.8.1/kafka_2.9.2-0.8.1.1.tgz
  [4]: http://www.alliedjeep.com/18625.htm
  [5]: https://github.com/EVODelavega/phpkafka
  [6]: https://github.com/njczy2010/phpkafka