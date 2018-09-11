# Basic AWS PHP SDK for SQS usage

Simple example how you can use AWS PHP SDK for sending and pulling messages from SQS.git 

#### Config
Use config.php to set your setting like region, sqs url and others.

#### Send
Run this through CLI to send a message to the configured SQS queue. Optionally you can set
two parameters - title and body.
```
php send.php "My msg title" "My body"
``` 

#### Receive
This script pulls messages from the queue. Simply run it with _php receive.php_
