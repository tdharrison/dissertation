<?
// API functions 
function validAPIuser($userId, $apiKey)
{
    global $userColl;
    $result = $userColl->findOne(array('login' => $userId, 'apikey'=>$apiKey));
 
    if(result)
    {
        return(true);
    }
    else
    {
        return(false);
    }
}

// Website functions below
function getQuestion($questionId)
{
    global $questionsColl;

    $results = $questionsColl->findOne(array('_id' => new MongoId($questionId)));
    return($results);
}
function getQuestionCount()
{
    global $questionsColl;
    $results = $questionsColl->find();
    $length = $results->count();
    return($length);
    
}
function getKeyForUser($user)
{
    global $userColl;
    $result = $userColl->findOne(array('login' => $user));

    if($result)
    {
        return($result['apikey']);
    }
    else
    {
        return(false);
    }
}
function insertQuestion($question)
{
    global $questionsColl;
    $questionsColl->insert(array('title' => $question['questionTitle'], 'text' => $question['questionText'], 'type' => $question['questionType'], 'answers' => array($question['answerOne'],$question['answerTwo'],$question['answerThree'],$question['answerFour'],$question['answerFive'],$question['answerSix'])));

    $result = $questionsColl->findOne(array('title'=>$question['questionTitle']));

    if($result):
        return true;
    else:
        return false;
    endif;
}
function getQuestionList()
{
    global $questionsColl;
    $questions = array();
    $results = $questionsColl->find();
    return $results;
}
function getUserList($fullInfo)
{
    global $userColl;
    $users = array();
    $results = $userColl->find();
    if($fullInfo):
        return $results;
    else:
        foreach($results as $result)
        {
            array_push($users, $result['login']);
        }
        return $users;
    endif;
}
function checkFirstRun()
{
    global $userColl;
    $result = $userColl->findOne(array('admin' => true));

    if ($result):
        # return false if this isn't our first run
        return(false);
    else:
        return(true);
    endif;
}

function isUserAdmin($login)
{
    global $userColl;
    $result = $userColl->findOne(array('login' => $login, 'admin' => true));

    if ($result):
        # will return true if there is a user with a name of $name and 'admin' 
        # and a status of 'true'
        return(true);
    else:
        return(false);
    endif;
}

function insertAPIKeyforUser($login)
{
    global $userColl;
    $newAPIKey = createAPIKey();

    $result = $userColl->update(array('login' => $login), array('$set'=>array('apikey'=> $newAPIKey)));
    # Check and make sure that the API key was inserted
    $apiCheckResult = $userColl->findOne(array('login' => $login, 'apikey' => $newAPIKey));
    if($apiCheckResult):
        return($newAPIKey);
    else:
        return(false);
    endif;
}

function createAPIKey()
{
    return (uniqid());
}
function insertAnswer($login, $question, $answer)
{
    global $userColl;
    $result = $userColl->update(
                                array('login' => $login),
                                #array('$set' => array('question' => array($question=>$answer))),
                                array('$set' => array('question.'.$question => $answer)),
                                array("upsert" => true)
                                );

    return $result;
}
function newUser($login, $password, $name,$admin,$apikey)
{
    global $userColl;
    $userColl->insert(array('login' => $login, 'password' => md5($password), 'name' => $name, 'admin' => $admin, 'apikey'=> $apikey));
    return true;
}


function checkPass($login, $password) 
{
    global $userColl;
    $result = $userColl->findOne(array('login' => $login, 'password' => md5($password)));
    if($result):
        return true;
    endif;
}

function cleanMemberSession($login, $password, $name)
{
    $_SESSION["login"]=$login;
    $_SESSION["password"]=$password;
    $_SESSION["loggedIn"]=true;
    $_SESSION["name"]=$name;
}

function flushMemberSession()
{
    unset($_SESSION["login"]);
    unset($_SESSION["password"]);
    unset($_SESSION["loggedIn"]);
    unset($_SESSION["name"]);
    session_destroy();
    return true;
}

function loggedIn()
{
    if($_SESSION['loggedIn']):
        return true;
    else:
        return false;
    endif;
}

?>

