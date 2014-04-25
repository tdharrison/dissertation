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
     User list
  </legend>
  <table border=1>
  <tr>
   <th>Login</th>
   <th>Name</th>
   <th>Is Admin</th>
   <th>API Key</th>
  </tr>
    <?
      foreach(getUserList(true) as $user)
      {
        print "<tr>";
        print "<td>".$user['login']."</td>";
        print "<td>".$user['name']."</td>";
        print "<td>".$user['admin']."</td>";
        print "<td>".$user['apikey']."</td>";
      }
    ?>
</table>
</fieldset>

<?
print("<a href=\"index.php"."\">Home</a> | ");
print("<a href=\"logout.php"."\">Logout</a>");
include_once("templates/footer.html");
?>
