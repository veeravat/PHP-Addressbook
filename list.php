<table class="table table-striped table-hover">
   <tbody>
<?php 
if((isset($_SERVER["HTTP_REFERER"]) )&& (isset($_GET['q']) || isset($_GET['s']))){
    define("access",true);
    require_once('config.php');
}
defined("access") or die(header('HTTP/1.0 403 Forbidden'));
$conn = connect();

if(isset($_GET['q']))
{
    $search = $conn->real_escape_string($_GET['q']);
    $sql = "SELECT * FROM contact  WHERE (
            fname LIKE '%$search%' OR
            lname LIKE '%$search%' OR
            organization LIKE '%$search%' OR
            email LIKE '%$search%'
            )
    ";
}
else {$sql = "SELECT * FROM contact";}
$query = $conn->query($sql);
while($result = $query->fetch_array())
    show_list($result);
?>        
    </tbody>
</table>