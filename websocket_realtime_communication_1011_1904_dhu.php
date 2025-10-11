<?php
// 代码生成时间: 2025-10-11 19:04:22
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

// WebSocket服务类
class WebSocketServer implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    // 当连接时触发
    public function onOpen(ConnectionInterface $conn) {
        // 将新连接的客户端存储起来
        $this->clients->attach($conn);
    }

    // 当连接关闭时触发
    public function onClose(ConnectionInterface $conn) {
        // 从客户端存储中移除
        $this->clients->detach($conn);
    }

    // 当接收到消息时触发
    public function onMessage(ConnectionInterface $from, $msg) {
        foreach ($this->clients as $client) {
            $client->send($msg); // 广播消息
        }
    }

    // 当发生错误时触发
    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }

    // 当发生不在上述情况的错误时触发
    public function onCall(ConnectionInterface $conn, $id, $payload) {
        // 未实现，关闭连接
        $conn->close();
    }
}

// 设置监听端口和启动服务
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new WebSocketServer()
        )
    ),
    8080
);

$server->run();
