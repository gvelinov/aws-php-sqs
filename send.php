<?php
include "vendor/autoload.php";

use Aws\Sqs\SqsClient;

$config = [
    'region' => 'eu-west-1',
    'version' => 'latest',
    'profile' => 'default',
];

$params = [
    'DelaySeconds' => 5,
    'MessageAttributes' => [
        "Title" => [
            'DataType' => "String",
            'StringValue' => isset($argv[1]) ? $argv[1] : "The Hitchhiker's Guide to the Galaxy"
        ]
    ],
    'MessageBody' => isset($argv[2]) ? $argv[2] : "Information about current NY Times fiction bestseller",
    'QueueUrl' => 'https://sqs.eu-west-1.amazonaws.com/515764178588/php-sdk-test'
];

$sqs = new SqsClient($config);

try {
    $result = $sqs->sendMessage($params);
    echo $result->toArray()['@metadata']['statusCode'];
    echo "\nSent...\n";
} catch (\Aws\Exception\AwsException $e) {
    var_dump($e->getMessage());
}