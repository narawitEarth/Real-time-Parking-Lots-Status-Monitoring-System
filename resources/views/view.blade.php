<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Theme Made By www.w3schools.com - No Copyright -->
  <title>PARKING</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <link href="{{ asset('css/view.css') }}" rel="stylesheet">

  <style>
      body {
    font: 20px Montserrat, sans-serif;
    line-height: 1.8;
    color: #f5f6f7;
  }
  p {font-size: 16px;}
  .margin {margin-bottom: 45px;}
  .bg-1 {
    background-color:#48997e; /* Green */
    color: #ffffff;
  }
  .bg-2 {
    background-color: #474e5d; /* Dark Blue */
    color: #ffffff;
  }
  .bg-3 {
    background-color: #ffffff; /* White */
    color: white;
  }
  .bg-4 {
    background-color: #2f2f2f; /* Black Gray */
    color: #fff;
  }
  .container-fluid {
    padding-top: 25px;
    padding-bottom: 65px;
  }
#navbar {
  background-color: white;
}
#navbar a {
  float: left;
  display: block;
  color: black;
  text-align: center;
  padding: 14px;
  text-decoration: none;
}
.content {
  padding: 10px;
}
.sticky {
  position: fixed;
  top: 0;
  width: 100%;
}
.sticky + .content {
  padding-top: 60px;
}
.sidenav {
  width: 150px;
  position: fixed;
  z-index: 1;
  top: 100px;
  left: 10px;
  background: #eee;
  overflow-x: hidden;
  padding: 8px 0;
}

.sidenav a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 15x;
  color: black;
  display: block;
}

.sidenav a:hover {
  color: #064579;
}


  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <div class="container" id="navbar">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    <a class="navbar-brand" href="{{route('project.view')}}">PARKING</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#vd" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">VIDEO</a></li>
        <li><a href="#jq" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">CHATBOT</a></li>
        <li><a href="#map" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">MAP</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- First Container -->
<div class="sidenav">
  <a href="{{route('project.view')}}">ATADA LOT1</a>
  <a href="{{route('project.view2')}}">ATADA LOT2</a>
</div>
@foreach ($park as $p)
<div class="container-fluid bg-1 text-center" id="vd">
  <h1 class="margin">ลานจอดรถหอพักอาทาด้า 1</h1>
  <video width="700" height="400" autoplay="autoplay">
        <source src="assets\img\upload\vdo.mp4"  />
  </video>
  {{-- <img name="main" id="main" width="700" height="400" src="http://192.168.43.150:58545/videostream.cgi?user=admin&pwd=TApop123"> --}}
    <h3>จำนวนที่จอดรถทั้งหมด 8 || จำวนวนที่ว่าง {{$p->detect}}</h3>
    {{-- <h4>{{$p->time}}</h4> --}}
    <div>
    <body onload="startTime()">
        <div id="txt"></div></body>
    <p id="date"></p>
    </div>
    {{-- <img name="main" id="main" width="800" height="450" src="http://192.168.43.150:58545/videostream.cgi?user=admin&pwd=TApop123"> --}}
</div>
@endforeach
<!-- Second Container -->
<div class="container-fluid bg-2 text-center" id="jq">
  <h3 class="margin">LINE CHATBOT</h3>
  <h4 class="margin">สามารถสอบถามที่ว่างของที่จอดรถผ่าน Line chatbot ได้เช่นกันครับ</h4>
  <img src="<?php echo asset('assets/img/chat.png')?>"style="display:inline" alt="" width="300" height="300">
</div>

<!-- Third Container (Grid) -->
<div class="container-fluid bg-3 text-center" id="map">
  <h1 style="color:#2f2f2f">MAP</h1>
  <iframe src="https://www.google.com/maps/d/u/0/embed?mid=1Kk3W9eJ7fJlOJXkBqLK50d2HNmPUeB_o" width="640" height="480"></iframe>
  </div>
</div>

<!-- Footer -->
<footer class="container-fluid bg-2 text-center">
  <p><a href=""></a></p>
</footer>


<script>
    function myFunction() {
  var x = document.getElementById("navDemo");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}
// When the user scrolls the page, execute myFunction
window.onscroll = function() {myFunction()};
var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;
function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('txt').innerHTML =
  h + ":" + m + ":" + s;
  var t = setTimeout(startTime, 500);
}
function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}
n =  new Date();
y = n.getFullYear();
m = n.getMonth() + 1;
d = n.getDate();
document.getElementById("date").innerHTML = m + "/" + d + "/" + y;
</script>
</body>
</html>

