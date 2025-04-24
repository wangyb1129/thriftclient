<?php
namespace Thrift\Client;
use Thrift\Transport\TSocket;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Protocol\TMultiplexedProtocol;
use Thrift\Client\GenericArgs;
use Thrift\Client\GenericClient;
use Illuminate\Support\Facades\Queue;

class ThriftClient
{
    protected $host;
    protected $port;

    public function __construct($host = '127.0.0.1', $port = 9090)
    {
        $this->host = $host;
        $this->port = $port;
    }
    public function call($serviceName, $methodName, $jsonParams)
    {
            // 同步调用
            $transport = new TSocket($this->host, $this->port);
            $transport->open();
            $protocol = new TBinaryProtocol($transport);
            $multiplexedProtocol = new TMultiplexedProtocol($protocol, $serviceName);
            $client = new GenericClient($multiplexedProtocol);
            $args = new GenericArgs(['jsonParams' => $jsonParams]);
            try {
                $result = $client->handle($methodName,$args);
                $transport->close();
                return $result;
            } catch (\Exception $e) {
                $transport->close();
                throw $e;
            }
    }
}
