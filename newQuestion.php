<?
include_once("templates/config.php");
include_once("templates/header.html");
if(!loggedIn()):
    header('Location: index.php');
endif;
if (!isUserAdmin($_SESSION["login"])):
    header('Location: index.php');
endif;
if(isset($_POST["submit"])):
    if (insertQuestion($_POST)):
        print "The question was added to the database";
    else:
        print "The question could not be added to the database";
    endif;
endif;
?>
<form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">
  <fieldset>
  <legend>
     Add a Question
  </legend>
  <table>
  <tr>
   <td span=2>
    You can add a new question to the database below.
   <input type='text' name='questionTitle' value='Question Title' size=30> 
   <textarea name='questionText' rows=4 cols=45>
Type your question here. 
   </textarea>
   </td>
  </tr>
  <tr>
  <td>
    Pick a question type:<br>
    <input type='radio' name='questionType' value='Radio' checked=True>Radio Boxes.<br>
    <input type='radio' name='questionType' value='Checkbox'>Checkboxes.
  </td>
  <td>
  &nbsp;
  </td>
  </tr>
  <tr>
  <td span=2>
    Possible Responses
  </td>
  </tr>
  <tr>
  <td>
      <input type="text" name="answerOne" size=30>
      <input type="text" name="answerTwo" size=30>
      <input type="text" name="answerThree" size=30>
  </td>
  <td>
      <input type="text" name="answerFour" size=30>
      <input type="text" name="answerFive" size=30>
      <input type="text" name="answerSix" size=30>
  </td>
  </tr>
  <tr>
  <td>
   <input name="submit" type="submit" value="Submit">
  </td>
  </tr>
</table>
</fieldset>
</form>
<?
print("<a href=\"index.php"."\">Home</a> | ");
print("<a href=\"logout.php"."\">Logout</a>");
include_once("templates/footer.html");
?>
