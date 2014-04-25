<?
include_once("templates/config.php");
include_once("templates/header.html");
if(loggedIn()):
header('Location: members.php');
endif;
if(isset($_POST["submit"])):
  if(!($row = checkPass($_POST["login"], $_POST["password"]))):
    echo "<p>Incorrect login/password, try again</p>";
    exit;
  endif;
  cleanMemberSession($_POST["login"], $_POST["password"]);
  header("Location: members.php");
endif;
?>
	<form name="loginform" method="post" action="<?=$_SERVER["PHP_SELF"]; ?>">
	<fieldset>
	<legend>Login</legend>
	<table>
	<tr>
	<td><label for="login">Email:</label></td><td><input name="login" value="<?= isset($_POST["login"]) ? $_POST["login"] : "" ; ?>" type="text" id="username" size="30" /></td>
	</tr>
	<tr>
	<td><label for="password">Password:</label></td><td><input name="password" type="password" id="password" size="30" /></td>
	</tr>
	<tr>
	<td class="submit"></td><td><input name="submit" type="submit" value="Submit" /></td>
	</tr>
	</table>
	</fieldset>
	</form>
<?
include_once("templates/footer.html");
?>
