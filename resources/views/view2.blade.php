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
  <meta name="viewport" content="width=device-width, initial-scale=1">

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
@media only screen and (min-width: 600px){
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
}
@media only screen and (min-width: 600px){
.sidenav a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 17px;
  color: black;
  display: block;
}
}
@media only screen and (min-width: 600px){
.sidenav a:hover {
  color: #064579;
}
}
@media screen and (min-width: 600px) {
    iframe {
        /* max-width: 100% !important; */
        width: 590px !important;
        height: 350px !important;
    }
}
#scroll {
  width:600px;
  height:600px;
  border:1px solid white;
  overflow:auto;

}

#parentDiv{
  width:115px;
  height:100px;
  overflow:auto;
  border: 2px black solid;
}
  </style>

<script text="text/javascript">
    $(document).ready(function(){
	$('#scroll').scrollTop($('#scroll')[0].scrollHeight);

    });
</script>

  <script type='text/javascript'>
    $(document).ready(function(){
     setInterval(fetchRecords, 3000);
      // Fetch all records
 //      $('#but_fetchall').click(function(){
   //  fetchRecords();
 //      });
    });

    function fetchRecords(){
      $.ajax({
        url: 'post-data2/',
        type: 'get',
        dataType: 'json',
        success: function(response){

          var len = 0;
          $('#userTable tbody').empty(); // Empty <tbody>
          if(response['data'] != null){
            len = response['data'].length;
          }

          if(len > 0){
            for(var i=0; i<len; i++){
              var detect = response['data'][i].detect;

              var tr_str = "<tr>" +
                  "<td align='center'>จำนวนที่จอดรถ 3 ที่ว่าง " + detect + " ที่</td>" +
              "</tr>";

              $("#userTable tbody").append(tr_str);
            }
          }else if(response['data'] != null){
             var tr_str = "<tr>" +
                 "<td align='center'></td>" +
                 "<td align='center'>"+response['data'].detect +"</td>" +
             "</tr>";

             $("#userTable tbody").append(tr_str);
          }else{
             var tr_str = "<tr>" +
                 "<td align='center' colspan='4'>No record found.</td>" +
             "</tr>";

             $("#userTable tbody").append(tr_str);
          }
          //setTimeout(update, 5000);
        }
      });
    }
    </script>
    {{-- //////////////////////////////data log///////////////////////////////// --}}
   <script type='text/javascript'>
    $(document).ready(function(){
     setInterval(log, 3000);
    });

    function log(){
      $.ajax({
        url: 'log-data2/',
        type: 'get',
        dataType: 'json',
        success: function(response){

          var len = 0;
          $('#ee tbody').empty(); // Empty <tbody>
          if(response['data'] != null){
            len = response['data'].length;
          }

          if(len > 0){
            for(var i=0; i<len; i++){
              var id = response['data'][i].id;
              var detect = response['data'][i].detect;
              var time = response['data'][i].time;
              var tr_str = "<tr>" +
                  "<td align='center'>" + id + " </td>" +
                  "<td align='center'>" + detect + " </td>" +
                  "<td align='center'>" + time + " </td>" +
              "</tr>";

              $("#ee tbody").append(tr_str);
            }
          }else if(response['data'] != null){
             var tr_str = "<tr>" +
                 "<td align='center'></td>" +
                 "<td align='center'>"+response['data'].detect +"</td>" +
             "</tr>";

             $("#ee tbody").append(tr_str);
          }else{
             var tr_str = "<tr>" +
                 "<td align='center' colspan='4'>No record found.</td>" +
             "</tr>";

             $("#ee tbody").append(tr_str);
          }
          //setTimeout(update, 5000);
        }
      });
    }
    </script>
</head>
<body>

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
  <a href="{{route('project.view')}}">ATADA LOT1 ||</a>
  <a href="{{route('project.view2')}}">ATADA LOT2 ||</a>
</div>
@foreach ($park2 as $p2)
<div class="container-fluid bg-1 text-center "id="vd">
    <h1 class="margin" style="font-size:1cm">ลานจอดรถหอพัก ATADA 2</h1>
    {{-- <iframe width="560" height="315" src="https://www.youtube.com/embed/lJ7p7TU047Y?channel=UCV1aXH_T6lQ-il9ewg9NMxg&autoplay=1&mute=1&enablejsapi=1" frameborder="0" allowfullscreen></iframe> --}}
    <iframe width="350" height="300" src="https://www.youtube.com/embed/3ZF2B-CRgxA?channel=UCV1aXH_T6lQ-il9ewg9NMxg&autoplay=1&mute=1&enablejsapi=1" frameborder="0" allowfullscreen></iframe>

  {{-- <video width="700" height="400" autoplay="autoplay">
        <source src="assets\img\upload\vdo.mp4"  />
  </video> --}}
  <table id='userTable'class="container-fluid bg-1 text-center" style="font-size:2ch">
    <thead>
     <tr>
       <th></th>
     </tr>
    </thead>
    <tbody></tbody>
   </table>
  {{-- <img name="main" id="main" width="800" height="450" src="http://192.168.43.150:58545/videostream.cgi?user=admin&pwd=TApop123"> --}}
    {{-- <h3>จำนวนที่จอดรถทั้งหมด 8 || จำวนวนที่ว่าง {{$p2->detect}}</h3> --}}
    <div>
            <body onload="startTime()">
                <div id="txt"></div></body>
            <p id="date"></p>
            </div>
    {{-- <h4>{{$p->time}}</h4> --}}
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
  {{-- <iframe src="https://www.google.com/maps/d/u/0/embed?mid=1Kk3W9eJ7fJlOJXkBqLK50d2HNmPUeB_o" width="640" height="480"></iframe> --}}
  <iframe src="https://www.google.com/maps/d/u/0/embed?mid=1Kk3W9eJ7fJlOJXkBqLK50d2HNmPUeB_o" width="350" height="300"></iframe>
  </div>
</div>

{{-- fourth (Grid) --}}

<div class="container-fluid bg-4 text-center" id="datalog">
    <h1 style="color:white">Data logger</h1>
    <div id="parentDiv" >
        <div>
        <table id='ee'class="table table-bordered" style="font-size:1.5ch">
            <thead>
             <tr>
               <th> ID </th>
               <th> DETECT </th>
               <th> TIME </th>
             </tr>
            </thead>
            <tbody></tbody>
           </table>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="container-fluid bg-2 text-center">
  <p><a href=""></a></p>


  <div id="parentDiv">
    <div class="people">1</div>
    <div class="people">2</div>
    <div class="people">3</div>
    <div class="people">4</div>
    <div class="people">5</div>
    <div class="people">6</div>
    <div class="people">7</div>
    <div class="people">8</div>
    <div class="people">9</div>
  </div>


</footer>

<script>

    $(document).ready(function(){
	$('#parentDiv').scrollTop($('#parentDiv')[0].scrollHeight);

    });
</script>

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

