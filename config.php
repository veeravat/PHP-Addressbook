<?PHP
defined("access") or die(header('HTTP/1.0 403 Forbidden'));


Global $connection;
// find environment
if($connect = getenv('MYSQLCONNSTR_mysqlConnection') != NULL){
    $conn_array = array();
    $parts = explode(";", $connect);
    foreach($parts as $part){
        $temp = explode("=", $part);
        $conn_array[$temp[0]] = $temp[1];
    }
    $connection['Hostname'] = $conn_array['Data Source'];
    $connection['Username'] = $conn_array['User Id'];
    $connection['Password'] = $conn_array['Password'];
    $connection['Database'] = $conn_array['Database'];
}
else{
    $connection['Hostname'] = '[Enter your Host name here]';
    $connection['Username'] = '[Enter your Usermane  here]';
    $connection['Password'] = '[Enter your Password  here]';
    $connection['Database'] = '[Enter your DB name here]';
}


function connect()
{
    global $connection;
    $conn = new mysqli($connection['Hostname'],
                    $connection['Username'],
                    $connection['Password'],
                    $connection['Database']);

    if ($conn->connect_errno) {
		die($conn->connect_error) ;
	}
    return $conn;
}

function reconnect($conn)
{  
    $conn->close();
    global $connection;
    $conn = new mysqli($connection['Hostname'],
                    $connection['Username'],
                    $connection['Password'],
                    $connection['Database']);

    if ($conn->connect_errno) {
		die($conn->connect_error) ;
	}
    return $conn;
}

function insert_sql($data,$phone)
{
    $conn = connect();
    $cid = getlatestID($conn,'addr_contact','CID')+1;
    $sql = "INSERT INTO addr_contact (CID,fname, lname, organization, email, note, sex) 
    VALUES ('".$cid."','".$conn->real_escape_string($data[0])."','".$conn->real_escape_string($data[1])."','".$conn->real_escape_string($data[2])."','".$conn->real_escape_string($data[3])."','".$conn->real_escape_string($data[4])."','".$conn->real_escape_string($data[5])."')";
    $result = $conn->query($sql) or die("Query Failed! SQL: $sql - Error: ".$conn->error);
    if($result)
    {
        $conn = reconnect($conn);
        $num = count($phone);
        for($i=0;$i<$num;$i++)
        {
            $pid = getlatestID($conn,'addr_phone','PID')+1;
            $sql = "INSERT INTO addr_phone (PID,CID, tel_number) 
            VALUES ('".$pid."','".$cid."','".$phone[$i]."')";
            $result = $conn->query($sql) or die("Query Failed! SQL: $sql - Error: ".$conn->error);
        }
    }

    $conn->close();
}

function update_sql($data,$phone,$pid,$id)
{
    $conn = connect();
    $sql = "UPDATE  addr_contact SET 
            fname = '".$conn->real_escape_string($data[0])."', lname = '".$conn->real_escape_string($data[1])."', 
            organization = '".$conn->real_escape_string($data[2])."', email = '".$conn->real_escape_string($data[3])."', 
            note = '".$conn->real_escape_string($data[4])."'  
            WHERE CID = '".$id."' ";
    $result = $conn->query($sql) or die("Query Failed! SQL: $sql - Error: ".$conn->error);
    if($result)
    {
        $conn = reconnect($conn);
        $num = count($phone);
        for($i=0;$i<$num;$i++)
        {
            $sql = "UPDATE  addr_phone SET tel_number = '".$phone[$i]."'WHERE PID = '".$pid[$i]."' ";
            $result = $conn->query($sql) or die("Query Failed! SQL: $sql - Error: ".$conn->error);
        }
    }
    $conn->close();
}

function delete_sql($id)
{
    $conn = connect();
    $sql = "DELETE  FROM addr_contact 
                    WHERE CID = '".$conn->real_escape_string($id)."' ";
    $result = $conn->query($sql) or die("Query Failed! SQL: $sql - Error: ".$conn->error);
    if($result)
    {
        $sql = "DELETE  FROM addr_phone 
                        WHERE CID = '".$conn->real_escape_string($id)."' ";
        $result = $conn->query($sql) or die("Query Failed! SQL: $sql - Error: ".$conn->error);
    }
    $conn->close();
}

function getlatestID($conn,$table,$field)
{
    $sql = "SELECT MAX($field)
            FROM $table";
    $result = $conn->query($sql);
    if($result->num_rows){
        $value = $result->fetch_array();
        return is_array($value) ? $value[0] : "";
    }else{
        return 0;
    }
}

function show_list($data)
{
    echo '        <tr class="contact-list" onclick="updateContact(\''.$data[0].'\')" id="'.$data[0].'" style="cursor: pointer;" >
            <td align="center">
                <div class="'.$data[6].'"></div> 
            </td>
            <td valign="baseline">
                '.$data[1].' '.$data[2].'<br>
				'.$data[3].'
            </td>
        </tr>';
}

function random_str()
{
    $name_length = 7;
    $alpha_numeric = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    return substr(str_shuffle(str_repeat($alpha_numeric, $name_length)), 0, $name_length);
}
function printPhone($id)
{
    $i=0;
    $conn = connect();
    $sql = "SELECT * FROM addr_phone WHERE CID = $id";
    $query = $conn->query($sql);
    while($result = $query->fetch_array())  
        echo '<span class="glyphicon glyphicon-phone res_phone['.$i++.']" aria-hidden="true"></span> : '.$result['tel_number'].'  <br>'; 
    $conn->close();
}
function printPhoneEdit($id)
{
    $i=0;
    $conn = connect();
    $sql = "SELECT * FROM addr_phone WHERE CID = $id";
    $query = $conn->query($sql);
    while($result = $query->fetch_array()){  
        echo'<input type="tel" maxlength="10" name="ephone[]" class="form-control" value="'.$result['tel_number'].'" required="required" placeholder="เบอร์โทรศัพท์">';   
        echo'<input type="hidden" name="pid[]" class="form-control" value="'.$result['PID'].'">';
    }
    $conn->close();
}

?>


