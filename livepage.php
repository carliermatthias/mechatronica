<?php
session_start();
require 'includes/config/cmdlist.php';
$cmd=cmdlist::getInstance();
	
if($_SESSION["loggedin"])
	{
	 include ('includes/templates/headertemplate.php');
	 $id = $db->getId($_SESSION['email']);
	 

?>

<div class="topnav" id="myTopnav">
  <a href="homepage.php" >Home</a>
  <a href="newRoute.php">Add New Route</a>
  <a href="livepage.php" class="active">Live Traject Page</a>
  <a href="">Sensor Data</a>
  <a href="settings.php">Account Settings</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
  
    <i class="fa fa-bars"></i>
  </a>
</div>

<script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}

function sendRequest(page){
  var request = new XMLHttpRequest();
  request.open("GET", page);
  request.onreadystatechange=function(){
      if(request.readyState==4){
          if(request.status==200){
          } else alert ("HTTP error");
      }
  }
  request.send();
}

$(document).ready(function(){
      $("#up")
      .mousedown(function() {
        sendRequest("/gpio_control/up.php");
        document.getElementById("up").style.opacity = 0.2;  
      })
      .mouseout(function() {
         sendRequest("/gpio_control/stop.php");
         document.getElementById("up").style.opacity = 1; 
       })
      .mouseup(function() {
         sendRequest("/gpio_control/stop.php");
         document.getElementById("up").style.opacity = 1;  
      });
      
      $("#down")
      .mousedown(function() {
        sendRequest("/gpio_control/down.php");
        document.getElementById("down").style.opacity = 0.2;  
      })
      .mouseout(function() {
         sendRequest("/gpio_control/stop.php");
         document.getElementById("down").style.opacity = 1; 
       })
      .mouseup(function() {
         sendRequest("/gpio_control/stop.php");
         document.getElementById("down").style.opacity = 1;  
      });

      $("#left")
      .mousedown(function() {
        sendRequest("/gpio_control/left.php");
        document.getElementById("left").style.opacity = 0.2;  
      })
      .mouseout(function() {
         sendRequest("/gpio_control/stop.php");
         document.getElementById("left").style.opacity = 1; 
       })
      .mouseup(function() {
         sendRequest("/gpio_control/stop.php");
         document.getElementById("left").style.opacity = 1;  
      });

      $("#right")
      .mousedown(function() {
        sendRequest("/gpio_control/right.php");
        document.getElementById("right").style.opacity = 0.2;  
      })
      .mouseout(function() {
         sendRequest("/gpio_control/stop.php");
         document.getElementById("right").style.opacity = 1; 
       })
      .mouseup(function() {
         sendRequest("/gpio_control/stop.php");
         document.getElementById("right").style.opacity = 1;  
      });
      
      $("#rotate_left")
      .mousedown(function() {
        sendRequest("/gpio_control/rotate_left.php");
        document.getElementById("rotate_left").style.opacity = 0.2;  
      })
      .mouseout(function() {
         sendRequest("/gpio_control/stop.php");
         document.getElementById("rotate_left").style.opacity = 1; 
       })
      .mouseup(function() {
         sendRequest("/gpio_control/stop.php");
         document.getElementById("rotate_left").style.opacity = 1;  
      });
      
      $("#rotate_right")
      .mousedown(function() {
        sendRequest("/gpio_control/rotate_right.php");
        document.getElementById("rotate_right").style.opacity = 0.2;  
      })
      .mouseout(function() {
         sendRequest("/gpio_control/stop.php");
         document.getElementById("rotate_right").style.opacity = 1; 
       })
      .mouseup(function() {
         sendRequest("/gpio_control/stop.php");
         document.getElementById("rotate_right").style.opacity = 1;  
      });
  });
  
  var fired = false;
  
  window.addEventListener("keydown", function (event) {
  if (event.defaultPrevented) {
    return; // Do nothing if the event was already processed
  }

  switch (event.key) {
    case "ArrowDown":
       if(!fired) {
        fired = true;
        document.getElementById("down").style.opacity = 0.2;
        sendRequest("/gpio_control/down.php");
        }
      break;
    case "ArrowUp":
      if(!fired) {
        fired = true;
        document.getElementById("up").style.opacity = 0.2;
        sendRequest("/gpio_control/up.php");
        } 
      break;
    case "ArrowLeft":
      if(!fired) {
        fired = true;
        document.getElementById("left").style.opacity = 0.2;
        sendRequest("/gpio_control/left.php");
        }   
      break;
    case "ArrowRight":
      if(!fired) {
        fired = true;
        document.getElementById("right").style.opacity = 0.2;
        sendRequest("/gpio_control/right.php"); 
      }  
      break;
    case "4":
      if(!fired) {
        fired = true;
        document.getElementById("rotate_left").style.opacity = 0.2;
        sendRequest("/gpio_control/rotate_left.php"); 
      }  
      break;
    case "6":
      if(!fired) {
        fired = true;
        document.getElementById("rotate_right").style.opacity = 0.2;
        sendRequest("/gpio_control/rotate_right.php"); 
      }  
      break;
    default:
      return; // Quit when this doesn't handle the key event.
  }

  // Cancel the default action to avoid it being handled twice
  event.preventDefault();
}, true);

  window.addEventListener("keyup", function (event) {
  if (event.defaultPrevented) {
    return; // Do nothing if the event was already processed
  }

  switch (event.key) {
    case "ArrowDown":
      fired = false;
      sendRequest("/gpio_control/stop.php"); 
      document.getElementById("down").style.opacity = 1;  
      break;
    case "ArrowUp":
      fired = false;
      sendRequest("/gpio_control/stop.php"); 
      document.getElementById("up").style.opacity = 1;  
      break;
    case "ArrowLeft":
      fired = false;
      sendRequest("/gpio_control/stop.php"); 
      document.getElementById("left").style.opacity = 1;  
      break;
    case "ArrowRight":
      fired = false;
      sendRequest("/gpio_control/stop.php"); 
      document.getElementById("right").style.opacity = 1;  
      break;
    case "4":
      fired = false;
      sendRequest("/gpio_control/stop.php"); 
      document.getElementById("rotate_left").style.opacity = 1;  
      break;
    case "6":
      fired = false;
      sendRequest("/gpio_control/stop.php"); 
      document.getElementById("rotate_right").style.opacity = 1;  
      break;
    default:
      return; // Quit when this doesn't handle the key event.
  }

  // Cancel the default action to avoid it being handled twice
  event.preventDefault();
}, true);


</script>

<div class="grid-container">
  <div class="item1">
    <img src="pictures/forward_left.png" alt="rotate_left" id="rotate_left" style="heigth:60px;width:60px">
  </div>
  <div class="item2">
    <img src="pictures/keyUP.png" alt="up" id="up" style="heigth:60px;width:60px">
  </div>
  <div class="item3">
    <img src="pictures/forward_right.png" alt="rotate_right" id="rotate_right" style="heigth:60px;width:60px">
  </div>  
  <div class="item4">
    <img src="pictures/keyLEFT.png" alt="left" id="left" style="heigth:60px;width:60px">
  </div>
  <div class="item5">
    <img src="pictures/keyDOWN.png" alt="down" id="down" style="heigth:60px;width:60px">    
  </div>
  <div class="item6">
    <img src="pictures/keyRIGHT.png" alt="right" id="right" style="heigth:60px;width:60px">
  </div>
</div>





<?php
include ('includes/templates/footertemplate.php');
}

else
{
	include ('includes/templates/not_logged_in.php'); 
}
?>