<?php
include "vendor/autoload.php";

use Aws\Sqs\SqsClient;

$queueUrl = "https://sqs.eu-west-1.amazonaws.com/515764178588/php-sdk-test";

$client = new SqsClient([
    'profile' => 'default',
    'region' => 'eu-west-1',
    'version' => 'latest'
]);

try {
    $result = $client->receiveMessage([
        'MaxNumberOfMessages' => 1,
        'MessageAttributeNames' => ['All'],
        'QueueUrl' => $queueUrl, // REQUIRED
        'WaitTimeSeconds' => 0,
    ]);

    if ($result->get('Messages') && count($result->get('Messages')) > 0) {
        echo "I received a message:\n[Title] " . $result->get('Messages')[0]['MessageAttributes']['Title']['StringValue'] . PHP_EOL;
        echo "[Body] ". $result->get('Messages')[0]['Body'] . PHP_EOL;


        echo "\nDeleting..." . PHP_EOL;

        $client->deleteMessage([
            'QueueUrl' => $queueUrl, // REQUIRED
            'ReceiptHandle' => $result->get('Messages')[0]['ReceiptHandle'] // REQUIRED
        ]);

        echo "Done." . PHP_EOL;
    } else {
        echo "No messages in queue." . PHP_EOL;
    }
} catch (\Aws\Exception\AwsException $e) {
    error_log($e->getMessage());
}