<?PHP 
if(isset($_SERVER["HTTP_REFERER"])){
    define("access",true);
}
require_once('config.php');
if(isset($_GET['mode']) && $_GET['mode'] == 'delete' )
{
    delete_sql($_POST['id']);
}
else if($_POST['inp'][0] && $_GET['mode'] == 'insert')
{   
    insert_sql($_POST['inp'],$_POST['phone']);
}
else if($_POST['inp'][0] && $_GET['mode'] == 'edit')
{
    update_sql($_POST['inp'],$_POST['phone'],$_POST['pid'],$_GET['id']);
}
else
print_r($GLOBALS);
?>