$(document).ready(function(){
	 function uploadFile(e)
  {
    $("#progressBar1").width("0%");
    e.preventDefault();
    var file = $("#inputFile1")[0].files[0];
    var data = new FormData();
    data.append("fichiercsv",file);
    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress",progressHandler,false);
    ajax.addEventListener("load",completeHandler,false);
    ajax.addEventListener("error",errorHandler,false);
    ajax.addEventListener("abort",abortHandler,false);
    ajax.open("POST","upload.php");
    ajax.send(data);
  }
  function progressHandler(event)
  {
      var percent = (event.loaded/event.total)*100;
      $("#progressBar1").width(Math.round(percent)+"%");
      $("#result").html(Math.round(percent)+"% Terminé");
  }

  function completeHandler(event)
  {
    $("#messages").html(event.target.responseText);
    window.location='list.php';
  }

  function errorHandler(event)
  {
    console.log("erreur");
    $("#messages").html(event.target.responseText);
  }

  function abortHandler(event)
  {
    $("#messages").html(event.target.responseText);
  }

  $("#btnUpload").on("click",uploadFile);
});