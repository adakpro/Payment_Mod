
var timeleft = 25;
var downloadTimer = setInterval(function(){
  if(timeleft <= 0){
    clearInterval(downloadTimer);
	window.location.replace("/");
  }
  document.getElementById("progressBar").value = 25 - timeleft;
  document.getElementById("progresslabel").innerHTML = timeleft;
  timeleft -= 1;
}, 1000);