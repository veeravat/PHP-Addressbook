<?php 
if(isset($_SERVER["HTTP_REFERER"])){
define("access",true);
}
defined("access") or die(header('HTTP/1.0 403 Forbidden'));
?>
	$(".contact-list").click(function() {
	    var id = parseInt(this.id);
	    updateContact(id);
	});

	$(document).delegate(".editContent", "click", function() {
	    $(".showContact").hide();
	    $(".add_contact").hide();
	    $(".editContact").show();
	    $(".deleteEdit").show();
	    $(".saveEdit").show();
	    updateVar();
	});
	$(document).delegate(".saveEdit", "click", function() {
	    pid = $("input[name='pid[]']")
	        .map(function() { return $(this).val(); }).get();
	    $(".centered").block({
	        centerX: false,
	        centerY: true,
	        message: $('#loading'),
	        css: {
	            border: 'none',
	            backgroundColor: 'transparent'
	        }
	    });
	    $.post("save.php?mode=edit&id=" + global_id, {
	            'inp[]': evalues,
	            'phone[]': ephonenumber,
	            'pid[]': pid
	        },
	        function(data, status) {
	            updateList();
	            $('.show-info').html(data);
	            $(".centered").unblock();
	        });
	});

	$(document).delegate(".deleteEdit", "click", function() {
	    $(".centered").block({
	        centerX: false,
	        centerY: true,
	        message: $('#loading'),
	        css: {
	            border: 'none',
	            backgroundColor: 'transparent'
	        }
	    });
	    $.post("save.php?mode=delete", {
	            'id': global_id
	        },
	        function(data, status) {
	            updateList();
	            $('.show-info').html(data);
	            $(".centered").unblock();
	        });
	});

	$('#add_contact_modal').on('hidden.bs.modal', function() {
	    //window.location.reload();
	});

	function updateContact(id) {

	    $(".saveEdit").hide();
	    $(".deleteEdit").hide();
	    $(".add_contact").show();
	    $('.tbinfo').block({
	        centerX: false,
	        centerY: true,
	        message: $('#loading'),
	        css: {
	            border: 'none',
	            backgroundColor: 'transparent'
	        }
	    });
	    $.ajax({
	        url: "contact.php?id=" + parseInt(id)
	    }).done(function(data) { // data what is sent back by the php page
	        $('.show-info').html(data); // display data
	        $('.tbinfo').unblock();
	        global_id = id;
	        //alert(global_id);
	    });
	}
	$(document).keyup(function(event) {
	    updateVar();
	    $(".Output").val(values + "\\\n" + phonenumber);
	    if ($(".search").val()) {
	        var searched = 1;
	        //$('.list').html('Searching...'); // Show "Downloading..."
	        // Do an ajax request
	        $.ajax({
	            url: "list.php?q=" + $(".search").val()
	        }).done(function(data) { // data what is sent back by the php page
	            $('.list').html(data); // display data
	        });
	    }
	    if (searched = 1 && !$(".search").val()) {
	        updateList();
	    }

	});

	function updateList() {
	    $.ajax({
	        url: "list.php?s"
	    }).done(function(data) { // data what is sent back by the php page
	        $('.list').html(data); // display data
	    });

	}

	function updateVar() {
	    values = $("input[name='inp[]']")
	        .map(function() { return $(this).val(); }).get();
	    values.push($(".add_info").val());
	    values.push($(".sex_inp").val());
	    evalues = $("input[name='edit[]']")
	        .map(function() { return $(this).val(); }).get();
	    evalues.push($(".eadd_info").val());
	    phonenumber = $("input[name='phone[]']")
	        .map(function() { return $(this).val(); }).get();
	    ephonenumber = $("input[name='ephone[]']")
	        .map(function() { return $(this).val(); }).get();
	    pid = $("input[name='pid[]']")
	        .map(function() { return $(this).val(); }).get();
	}