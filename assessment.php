<?
include_once("templates/config.php");
include_once("templates/header.html");
if (!loggedIn()):
# Always drop them on the index page if they're not logged in
    header('Location: index.php');
endif;
?>
    <fieldset>
        <legend>
            Student Assessment
        </legend>

<?
       if(isset($_GET['question_id']))
       {
           $question = getQuestion($_GET['question_id']);
           # display the form
           print "<h3>" . $question['title'] . "</h3>";
           print "<p>" . $question['text'] . "</p>";
           print "<form name=\"questionForm\" method=\"post\" action=\"".$_SERVER["PHP_SELF"]."\">";

           print "<input type=\"hidden\" name=\"id\" value=\"".$_GET['question_id']."\">";

           foreach($question['answers'] as $answer)
           {
               if($answer !="")
               {
                  print "<input type=\"".$question['type']."\" name=\"answer[]\" value=\"".$answer."\">" . $answer . "<br>";
               }
           }
?>
<br>
<input type="submit" value="Submit" name="submit">
</form>
<?
    }
    elseif(isset($_POST["submit"]))
    {
        $result = insertAnswer($_SESSION["login"], $_POST["id"], $_POST["answer"]);
        if($result)
        {
            print("Response successfully submitted.<br>");
            print("Return to the <a href=\"".$_SERVER["PHP_SELF"]."\">Assessment Page</a>. ");
        }
        else
        {
            print ("There was an error when submitting your responses.");
        }
    }
    else
    {
?>
            There are <?print getQuestionCount()?> question(s) in the Student Assessment section. The answers to the questions will determine the best time of day for you to study.<br><br>
            According to your previous answers, the best time(s) for you to study is/are:<br><br>
            You can go back and answer any of the questions again:
            <ul>
<?
        foreach(getQuestionList() as $question)
        {
            print"<li><a href=\"".$_SERVER["PHP_SELF"]."?question_id=".$question["_id"]."\">".$question["title"]."</a></li>";
        }
        
?>
            </ul>
<?
        }
        #endif;
?>
 
    </fieldset>
    <a href="index.php">Home</a>&nbsp;|&nbsp;
    <a href="logout.php">Logout</a>
<?
include_once("templates/footer.html");
?>
