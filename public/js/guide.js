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

function section_edit(id,frame)
  {
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