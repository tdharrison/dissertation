<?
include_once("templates/config.php");
include_once("templates/header.html");
?>
<p>Home Page</p>
<?

# Check and see if this is our first run
# If it is, then initialise the db and create an admin user

if(checkFirstRun()):
    if(isset($_POST["submit"])):
        # proccess a form submitted for the admin user
        if(!($_POST["password"] == $_POST["password2"])):
            echo "<p>Your passwords did not match</p>";
            exit;
        endif;
        $query = $userColl->findOne(array('login' => $_POST['login']));
  
        if(empty($query)):
            newUser($_POST["login"], $_POST["password"], $_POST["name"], true, createAPIKey());
            cleanMemberSession($_POST["login"], $_POST["password"], $_POST["name"]);
            header("Location: index.php");
         else:
            echo '<p>Username already exists, please choose another username.</p>';
         endif;
    else:
?>
        <form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">
        <fieldset>
        <legend>
            Create an Admin User
        </legend>
        <table>
        <tr>
        <td>
            Email/Login:
        </td>
        <td>
            <input type="text" name="login" value="<?php print isset($_POST["login"]) ? $_POST["login"] : "" ; ?>" maxlength="15">
        </td>
        </tr>
        <tr>
        <td>
          Name:
        </td>
        <td>
            <input type="text" name="name" value="<?php print isset($_POST["name"]) ? $_POST["name"] : "admin"; ?>" maxlength="15">
        </td>
        </tr>
        <tr>
        <td>
          Password:
        </td>
        <td>
            <input type="password" name="password" value="" maxlength="15">
        </td>
        </tr>
        <tr>
        <td>
          Confirm password:
        </td>
        <td>
          <input type="password" name="password2" value="" maxlength="15">
        </td>
        </tr>
        <tr>
        <td>
          &nbsp;
        </td>
        <td>
        <input name="submit" type="submit" value="Submit">
        </td>
        </tr>
        </table>
        </fieldset>
        </form>
<?
    endif;
else:
# If the user is not logged in, give them links to do so
# If they are logged in, give them the assessment link
if(!loggedIn()):?>
    <a href="join.php">Register</a> |
    <a href="login.php">Login</a> |
  <?else:?>
    <fieldset>
        <legend>
            Available Actions
        </legend>
            <ul>
                <li>Take the <a href="assessment.php">Student Assessment</a>.</li>
<?
# If they are logged in, and their login is an administrative login
# Give them additional options.
if (isUserAdmin($_SESSION["login"])):
    print "<li>Generate a new <a href='key.php'>API Key</a>.</li>";
    print "<li>View the <a href='viewQuestions.php'>list of questions</a>.</li>";
    print "<li>Add a <a href='newQuestion.php'>new question</a>.</li>";
    print "<li>View the <a href='users.php'>list of users</a>.</li>";
endif;   
?>
            </ul>
    </fieldset>
    <a href="logout.php">Logout</a>
  <?
    endif;
endif;

include_once("templates/footer.html");
?>
