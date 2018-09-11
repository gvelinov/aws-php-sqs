<?php
include "vendor/autoload.php";
$config = include "config.php";

use Aws\Sqs\SqsClient;

$client = new SqsClient($config['client']);

try {
    $result = $client->receiveMessage([
        'MaxNumberOfMessages' => 1,
        'MessageAttributeNames' => ['All'],
        'QueueUrl' => $config['queueUrl'], // REQUIRED
        'WaitTimeSeconds' => 0,
    ]);

    if ($result->get('Messages') && count($result->get('Messages')) > 0) {
        echo "I received a message:\n[Title] " . $result->get('Messages')[0]['MessageAttributes']['Title']['StringValue'] . PHP_EOL;
        echo "[Body] ". $result->get('Messages')[0]['Body'] . PHP_EOL;


        echo "\nDeleting..." . PHP_EOL;

        $client->deleteMessage([
            'QueueUrl' => $config['queueUrl'], // REQUIRED
            'ReceiptHandle' => $result->get('Messages')[0]['ReceiptHandle'] // REQUIRED
        ]);

        echo "Done." . PHP_EOL;
    } else {
        echo "No messages in queue." . PHP_EOL;
    }
} catch (\Aws\Exception\AwsException $e) {
    error_log($e->getMessage());
}