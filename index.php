<?PHP 
define("access",true);
require_once('config.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Address Book</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Latest compiled and minified CSS & JS -->
<link rel="stylesheet" media="screen" href="css/bootstrap.css">
<link rel="stylesheet" media="screen" href="css/mycss.css">
<script src="//code.jquery.com/jquery.js"></script>
<script src="//malsup.github.io/jquery.blockUI.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="js/myfunction.js.php"></script>
<script>
var values = new Array();
var phonenumber = new Array();
var evalues = new Array();
var ephonenumber = new Array();
var pid = new Array();
var global_id;

$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="col-xs-6"><div class="input-group"><span class="input-group-addon" id="sizing-addon1"><span class="glyphicon glyphicon-phone" aria-hidden="true"></span></span><input type="tel" maxlength="10" name="phone[]" class="form-control" required="required" placeholder="เบอร์โทรศัพท์"><span class="input-group-btn remove_field" id="sizing-addon1"><button type="button" class="btn btn-danger remove_field"><span class="remove_field glyphicon glyphicon-remove" aria-hidden="true"></span></button></span></div></div>'); //add input box
        }
    });
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
        if(x < 0){x=0};
    })

    $( ".form-submit" ).click(function() {
		  $('div.input-form').block({ 
				centerX: false, 
				centerY: true, 
                message:  $('#loading'),
				css: {
						border:     'none',
						backgroundColor:'transparent'
					}
            }); 
		updateVar();
    $.post("save.php?mode=insert",
        {
          'inp[]' : values, 'phone[]' : phonenumber
        },
        function(data, status){
          $("#form_add").trigger('reset');
          $('div.input-form').unblock();
          $('#add_contact_modal').modal('hide');
          updateList();
        });

    });
});



</script>
</head>
<body>

<div class="shadow centered">

<div class="alert alert-info" style="text-align: center">
  <strong>Address Book</strong> 
</div>
<br>
<table border="0" class="table table-responsive table-bordered">
  <thead>
      <tr class="info">
        <th valign="middle" width="300">
          <div class="input-group">
            <input type="text" class="form-control search" placeholder="Search for...">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">
              <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
              </button>
            </span>
          </div><!-- /input-group -->

        </th>
        <th>
          <div align="right">
            <button type="button" id="add_contact" class="btn btn-success add_contact"data-toggle="modal" href='#add_contact_modal'>
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> เพิ่มรายชื่อ
            </button>
            <button type="button" id="Edit" class="btn btn-info saveEdit" style="display:none;">
              <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> บันทึกข้อมูล
            </button>
            <button type="button" id="Delete" class="btn btn-danger deleteEdit" style="display:none;">
              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> ลบข้อมูล
            </button>
          </div>
        </th>
      </tr>
  </thead>
  <tbody>
    <tr>
      <td height="600" width="300">
        <div class="scrollable list">
            <?PHP require_once("list.php") ?>
        </div>
      </td>
        
      <td class="tbinfo"><div class="show-info"> </div>  
 
      </td>
    </tr>
  </tbody>
</table>
<div class="modal fade" id="add_contact_modal">
  <div class="modal-dialog">
    <div class="modal-content input-form">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">เพิ่มรายชื่อผู้ติดต่อใหม่</h4>
      </div>
      <div class="modal-body">
        <form action="" id="form_add" method="POST" role="form">
          <div class="form-group">
            <div class="row">
              <div class="col-xs-6">
                <div class="input-group">
                  <span class="input-group-addon" id="sizing-addon1">ชื่อ</span>
                  <input type="text" id="firstname" name="inp[]" class="form-control" required="required" placeholder="ชื่อผู้ติดต่อ">
                </div>
              </div>
              <div class="col-xs-6">
                <div class="input-group">
                  <span class="input-group-addon" id="sizing-addon1">นามสกุล</span>
                  <input type="text" id="lastname" name="inp[]" class="form-control" required="required" placeholder="นามสกุล">
                </div>
              </div>
          </div>
          <br>
          <div class="row">
              <div class="col-xs-6">
                <div class="input-group">
                  <span class="input-group-addon" id="sizing-addon1">ที่ทำงาน</span>
                  <input type="text" id="work"  name="inp[]" class="form-control" required="required" placeholder="ที่ทำงาน/หน่วยงานที่สังกัด">
                </div>
              </div>
              <div class="col-xs-6">
                <div class="input-group">
                  <span class="input-group-addon" id="sizing-addon1">E-mail</span>
                  <input type="text" id="email" name="inp[]" class="form-control" required="required" placeholder="E-mail">
                </div>
              </div>
          </div>
          <br>
          <div class="input_fields_wrap row">
            <div class="col-xs-6">
              <div class="input-group">
                <span class="input-group-addon" id="sizing-addon1">
                  <span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
                </span>
                <input type="tel" maxlength="10" name="phone[]" class="form-control" required="required" placeholder="เบอร์โทรศัพท์">
                <span class="input-group-btn " id="sizing-addon1">
                  <button type="button" class="btn btn-success add_field_button">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                  </button>
                </span>
              </div>
            </div>
          </div>
          <br> 
          </div>
          <div class="row">
              <div class="col-xs-12">
                <div class="input-group">
                  <span class="input-group-addon" id="sizing-addon1">รายละเอียดเพิ่มเติม</span>
                  <textarea  id="note" name="inp[]"  class="form-control add_info" rows="3" required></textarea>
                </div>
              </div>
          </div>         <br>
          <div class="row">
              <div class="col-xs-4">
                <div class="input-group">
                  <span class="input-group-addon" id="sizing-addon1">เพศ</span>
                    <select name="inp[]" id="input" class="form-control sex_inp" required>
                      <option value="" disabled selected>เลือกเพศ</option>
                      <option value="male" >-- ผู้ชาย --</option>
                      <option value="female" >-- ผู้หญิง --</option>
                    </select>
                </div>
              </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
      <div class="Output"></div
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary form-submit">เพิ่มข้อมูล</button>
      </div>
    </div>
  </div>
</div>
</div>
<div id="loading" style="display:none;">
    <img src="images/loading.gif" width="200" />
</div>

</body>
</html>