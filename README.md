# Logjam Dispatcher
Basic client to dispatch log messages to logjam using ZeroMQ.

## Dispatch Message

````php

use LogjamDispatcher\Dispatcher\ZmqDispatcher;
use LogjamDispatcher\Logjam\Message;

$dispatcher = new ZmqDispatcher(array('tcp://my.broker'), 'myapp', 'dev');

$message = new Message();
// fill message object

$message->setMethod('GET');
//.....

$dispatcher->dispatch($message);

````

### Initialize dispatcher with custom ZMQSocket

````php

$dispatcher = new ZmqDispatcher(array('tcp://my.broker'), 'myapp', 'dev', ZmqDispatcher::createZmqSocket());

````


### Filtered Request Informations

````php
use LogjamDispatcher\Http\FilteredRequestInformationDecorator;
use LogjamDispatcher\Http\RequestInformation;

$message = new Message();

// ....

$requestInformation = new RequestInformation();
$requestInformation->setBodyParameters(array(
    'password' => 'foo-bar123'
));

$requestInformation = new FilteredRequestInformationDecorator($requestInformation, array('password'), '*****');

print_r($requestInformation->getBodyParameters());
// outputs: Array([password] => *****)


$message->setRequestInformation($requestInformation);

//....

````


### Fullyfilled Message Example


````php
use LogjamDispatcher\Logjam\Message;
use LogjamDispatcher\Dispatcher\Expression;

$message = new Message();

$requestInformation = new RequestInformation();
$requestInformation
    ->setMethod('GET')
    ->setHeaders(array('Accept' => 'Nothing', 'Feels' => 'BadMan'))
    ->setBodyParameters(array('action' => 'submit'))
    ->setQueryParameters(array('page' => '15', 'offset' => '213123'))
    ->setUrl('my.app.page/products');
    

$message
    ->setAction('MyApp::MyController#MyAction')
    ->setAdditionalData(array('stuff' => 'theUserDid'))
    ->setCallerAction('') //value of http request header X-Logjam-Action (if present)
    ->setCallerId('')     //value of http request header X-Logjam-Caller-Id (if present)
    ->setDbCalls(12)
    ->setDbTime(123123.123)
    ->setExceptions(array($thisStupidExceptionIGot))
    ->setHost('my.app.host')
    ->setIp('123.321.123.321')
    ->setRequestId(new RequestId())
    ->setRequestInformation($requestInformation)
    ->setRequestStartedAt($myStartTimeDateTimeObject)
    ->setRequestEndedAt($myEndTimeDateTimeObject)
    ->setResponseCode(200)
    ->setSeverity(Expression\Severity::INFO)
    ->setUserId(0);
````

### Log Exceptions

````php
if ($dispatcher->hasExceptions) {
    $exceptions = $dispatcher->getExceptions();
    // Do stuff with them
}
````