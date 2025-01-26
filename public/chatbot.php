require 'vendor/autoload.php'; // If using Composer for Dialogflow SDK

use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Dialogflow\V2\QueryInput;
use Google\Cloud\Dialogflow\V2\TextInput;

function handleUserMessage($message) {
    $sessionId = 'unique-session-id';
    $sessionsClient = new SessionsClient();
    $session = $sessionsClient->sessionName('your-project-id', $sessionId);

    // Create text input
    $textInput = new TextInput();
    $textInput->setText($message);
    $textInput->setLanguageCode('en');

    // Create query input
    $queryInput = new QueryInput();
    $queryInput->setText($textInput);

    // Detect intent
    $response = $sessionsClient->detectIntent($session, $queryInput);
    $queryResult = $response->getQueryResult();

    return $queryResult->getFulfillmentText();
}
