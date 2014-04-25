<?
include_once("templates/config.php");
include_once("templates/header.html");

if(!loggedIn()):
header('Location: index.php');
endif;
print("<fieldset>");
print("<legend>User Information</legend>");
print("Welcome to the members page <b>".$_SESSION["login"]."</b><br>\n");
print("Your password is: <b>".$_SESSION["password"]."</b><br>\n");
print("Your name is: <b>".$_SESSION["name"]."</b><br>\n");
if(getKeyForUser($_SESSION["login"]) != false)
{
    print("Your API key is: <b>" . getKeyForUser($_SESSION["login"]) . " </b><br>\n");
}
print("</fieldset>");
print("<a href=\"index.php"."\">Home</a> | ");
print("<a href=\"logout.php"."\">Logout</a>");

include_once("templates/footer.html");

?>

