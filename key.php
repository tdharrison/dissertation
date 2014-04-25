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
<form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">
  <fieldset>
  <legend>
      Generate API Key
  </legend>
  <table>
  <tr>
<?
if(isset($_POST["submit"])):
    # Add an API key for the selected user
    $newKey = insertAPIKeyforUser($_POST["login"]);
    if(!$newKey):
        print "Updating the API key for user " . $_POST["login"] . " failed.";
    else:
        print "New API key for user " . $_POST["login"] . " is: " . $newKey;
    endif;
endif;
?>
   <td>
    <select name="login">
    <?
      foreach(getUserList(false) as $login)
      {
        print "<option value=\"".$login."\">".$login."</option>";
      }
    ?>
    </select>
   </td>
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
