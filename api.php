<?
include_once("templates/config.php");

$output = new DomDocument('1.0');
$output->preseveWhiteSpace = false;
$output->formatOutput = true;

$apiOutput = $output->createElement('apiOutput');
$apiOutput = $output->appendChild($apiOutput);

// check for a valid userid

if(isset($_GET['userid']) and isset($_GET['apikey']))
{
    $userId = $_GET['userid'];
    $apiKey = $_GET['apikey'];

    // use a switch...case statement to process the API requests

    // API options
    // getQuestionList

    switch ($_GET['action'])
    {
        case 'getQuestionList':
            $questionRoot = $output->createElement('questionList');
            $questionRoot = $apiOutput->appendChild($questionRoot);
            foreach(getQuestionList() as $question)
            {
                $questionData = $output ->createElement('question');
                $questionData = $questionRoot -> appendChild($questionData);

                $questionId = $output->createElement('id', $question['_id']);
                $questionId = $questionData -> appendChild($questionId);

                $questionTitle = $output->createElement('title', $question['title']);
                $questionTitle = $questionData -> appendChild($questionTitle);

                $questionText = $output ->createElement('text', $question['text']);
                $questionText = $questionData -> appendChild($questionText);

                $questionType = $output -> createElement('type', $question['type']);
                $questionType = $questionData -> appendChild($questionType);

                $answersRoot = $output -> createElement('answers');
                $answersRoot = $questionData -> appendChild($answersRoot);

                foreach($question['answers'] as $answer)
                {
                    if ($answer != '')
                    {
                        // skip the answers that don't have anything set
                        $answerData = $output -> createElement('answer', $answer);
                        $answerData = $answersRoot -> appendChild($answerData);
                    }
                }
            }
            break;
    }
}
else
{
    // If 'GET' is not set, return an error

    $error = $output->createElement('error');
    $error = $apiOutput->appendChild($error);
    
    $message = $output->createElement('message');
    $message = $error->appendChild($message);

    $value = $output->createTextNode("Userid or API key not set");
    $value = $message->appendChild($value);
}

$xmlOutput = $output->saveXML();
print $xmlOutput

?>

