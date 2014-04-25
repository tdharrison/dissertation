<?
include_once("templates/config.php");
include_once("templates/header.html");
if(loggedIn()):
header('Location: members.php');
endif;
if(isset($_POST["submit"])):
	if(!($_POST["password"] == $_POST["password2"])):
		echo "<p>Your passwords did not match</p>";
		exit;
	endif;
	
    $query = $userColl->findOne(array('login' => $_POST['login']));

	if(empty($query)):
		newUser($_POST["login"], $_POST["password"], $_POST["name"], false, false);
		cleanMemberSession($_POST["login"], $_POST["password"], $_POST["name"]);
		header("Location: members.php");
	else:
	  echo '<p>Username already exists, please choose another username.</p>';
	endif;
endif;
?>
<form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">
  <fieldset>
  <legend>
      Register
  </legend>
  <table>
  <tr>
    <td>
      Login:
    </td>
    <td>
      <input type="text" name="login" value="<?php print isset($_POST["login"]) ? $_POST["login"] : "" ; ?>"maxlength="15">
    </td>
  </tr>
  <tr>
    <td>
        Name:
    </td>
    <td>
        <input type="text" name="name" value="<?php print isset($_POST["name"]) ? $_POST["name"] : ""; ?>"maxlength="15">
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
include_once("templates/footer.html");
?>
