function winclose() {
  close();
}

function wclose() {
  window.opener.location.reload();
  close();
}

function reload()
  {
    location.reload();
  }

function newwin($url,x=800,y=800)
{
    NewWindow=window.open($url,'newwin','width='+x+',height='+y+',toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no');
    NewWindow.focus();
    void(0);
}

function block_save(id,$frame)
  {
    var vlr = $("#ct_title_"+id).val();
    var vlr2 = $("#ct_description_" + id).val();
    var data = { vlr: vlr, vlr2: vlr2 };
      $.post($path + "/ajax/block/save/" + id, data, function (data) {
        $("#" + $frame).html(data);
      });
    //$("#"+$frame).load($path + "/ajax/block/view/" + id);
  }


function block_edit(id, frame) {
  $("#" + frame).load($path + "/ajax/block/edit/" + id + "/" + frame);
}

function section_edit(id,frame)
  {
    alert($path + "/ajax/section/edit/" + id);
    $("#"+frame).load($path + "/ajax/section/edit/"+id);
  }

function new_section($sec,$ord)
  {
    $("#btn_new_block").hide();
    $("#block_edit").load($path + "/ajax/section/ajax_block_edit/" + $sec+"/"+$ord);
  }

function new_section_type($sec, $ord, $type) {
  $("#block_edit").load(
    $path + "/ajax/section/ajax_block_edit_type/" + $sec + "/" + $ord + '?type=' + $type
  );
}

function close_field(id, frame) {
  $("#" + frame).load($path + "/ajax/block/ajax_block_view/" + id);
}

function delete_field(id, frame) {
 if (isExecuted = confirm("Exclusion?"))
  {
    $("#" + frame).load($path + "/ajax/block/ajax_block_delete/" + id);
  }

}

function section_view($id,$frame)
  {
    $("#" + $frame).load($path + "/ajax/section/ajax_viewid/" + $id);
  }

function field_edit($table,$field,$id,$frame)
  {
    $("#"+$frame).load($path + "/ajax/field/edit/"+$table+"/"+$field+"/"+$id);
  }

function section_save()
  {
    var ord = $("#sc_order").val();
    var title = $("#sc_name").val();
    var path = $("#sc_path").val();
    var id = $("#sc_id").val();
    var prj = $("#sc_project").val();
    if (title == "") {
      alert("Titulo é obrigatório");
    } else {
      var data = { title: title, path: path, ord: ord, prj: prj };
      $.post($path + "/ajax/section/save/"+id,data,function(data){
        $("#form_section").html(data);
      });
    }
  }