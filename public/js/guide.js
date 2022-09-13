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