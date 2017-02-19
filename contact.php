<?php 
if(isset($_SERVER["HTTP_REFERER"])){
define("access",true);
}
require_once('config.php');
$conn = connect();
$id = $_GET['id'];
$sql = "SELECT * FROM addr_contact WHERE CID = $id";
$query = $conn->query($sql);
$result = $query->fetch_array();
$conn->close();
?>
<div class="container showContact">
    <div class="row">
        <div class="panel panel-info" style="width: 560px;">
            <div class="panel-heading">
                <h3 class="panel-title">ข้อมูลส่วนตัว</h3>
            </div>
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 res_fname">
                    <p>ชื่อ : <?=$result[1]?></p>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 res_lname">
                    <p>นามสกุล : <?=$result[2]?></p>
                </div>
            </div>
            <div class="row">      
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 res_org">
                    <p>บริษัท / สังกัด : <?=$result[3]?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 res_email">
                    <p>E-mail : <?=$result[4]?></p>
                </div>
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="panel panel-info" style="width: 560px;">
              <div class="panel-heading">
                    <h3 class="panel-title">Note</h3>
              </div>
              <div class="panel-body res_note">
                    <?=$result[5]?>
              </div>
        </div>
    </div>  
    <div class="row">
        <div class="panel panel-warning" style="width: 560px;">
              <div class="panel-heading">
                    <h3 class="panel-title">เบอร์โทรศัพท์</h3>
              </div>
              <div class="panel-body">  
                    <?PHP printPhone($id); ?>         
             </div>
        </div>
    </div>
    
    <div class="row" style="margin-left: 230px;">
            <button type="button" class="btn btn-warning editContent" >
            <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> แก้ไข</button>
    </div>
         
</div>

<div class="container editContact" style="display:none">
    <div class="row">
        <div class="panel panel-info" style="width: 560px;">
            <div class="panel-heading">
                <h3 class="panel-title">ข้อมูลส่วนตัว</h3>
            </div>
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 res_fname">
                    ชื่อ : <input type="text" name="edit[]" class="form-control" required="required" placeholder="ชื่อผู้ติดต่อ" value="<?=$result[1]?>">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 res_lname">
                    นามสกุล : <input type="text" name="edit[]" class="form-control" required="required" placeholder="นามสกุล"value="<?=$result[2]?>">
                </div>
            </div>
            <div class="row">      
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 res_org">
                    บริษัท / สังกัด : <input type="text" name="edit[]" class="form-control" required="required" placeholder="ที่ทำงาน/หน่วยงานที่สังกัด"value="<?=$result[3]?>">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 res_email">
                    E-mail : <input type="text" name="edit[]" class="form-control" required="required" placeholder="E-mail"value="<?=$result[4]?>">
                </div>
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="panel panel-info" style="width: 560px;">
              <div class="panel-heading">
                    <h3 class="panel-title">Note</h3>
              </div>
              <div class="panel-body res_note">
                    <textarea name="edit[]"  class="form-control eadd_info" rows="3" required><?=$result[1]?></textarea>
              </div>
        </div>
    </div>  
    <div class="row">
        <div class="panel panel-warning" style="width: 560px;">
              <div class="panel-heading">
                    <h3 class="panel-title">เบอร์โทรศัพท์</h3>
              </div>
              <div class="panel-body scrollable2">  
                    <?PHP printPhoneEdit($id); ?>      
             </div>
        </div>
    </div>     
</div>









