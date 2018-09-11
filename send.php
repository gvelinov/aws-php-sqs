<?php
include "vendor/autoload.php";
$config = include "config.php";

use Aws\Sqs\SqsClient;

$params = [
    'DelaySeconds' => 5,
    'MessageAttributes' => [
        "Title" => [
            'DataType' => "String",
            'StringValue' => isset($argv[1]) ? $argv[1] : "The Hitchhiker's Guide to the Galaxy"
        ]
    ],
    'MessageBody' => isset($argv[2]) ? $argv[2] : "Information about current NY Times fiction bestseller",
    'QueueUrl' => $config['queueUrl']
];

$sqs = new SqsClient($config['client']);

try {
    $result = $sqs->sendMessage($params);
    echo $result->toArray()['@metadata']['statusCode'];
    echo "\nSent...\n";
} catch (\Aws\Exception\AwsException $e) {
    var_dump($e->getMessage());
}