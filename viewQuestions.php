<?
include_once("templates/config.php");
include_once("templates/header.html");
if(!loggedIn()):
    header('Location: index.php');
endif;
if (!isUserAdmin($_SESSION["login"])):
    header('Location: index.php');
endif;
?>
  <fieldset>
  <legend>
     Question list
  </legend>
  <table border=1>
  <tr>
   <th>ID</th>
   <th>Question</th>
    <?
      foreach(getQuestionList() as $question)
      {
        print "<tr>";
        print "<td>".$question["_id"]."</td>";
        print "<td>".$question["title"]."</td>";
        print "</tr>";
      }
    ?>
</table>
</fieldset>

<?
print("<a href=\"index.php"."\">Home</a> | ");
print("<a href=\"logout.php"."\">Logout</a>");
include_once("templates/footer.html");
?>
