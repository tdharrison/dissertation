<?
ob_start();
error_reporting(E_ALL);
try
{
  $m = new Mongo();
  $db = $m->modeler;
  $userColl = $db->users;
  $adminColl = $db->admin;
  $questionsColl = $db->questions;
}
catch (MongoConnectionException $e)
{
  die('Error connecting to MongoDB server');
} 
catch (MongoException $e) {
  die('Error: ' . $e->getMessage());
}
include_once("functions.php");
session_start();
$questionsDirectory = "modeler"
?>
<?//var_dump($_SESSION);var_dump($_POST);?>
