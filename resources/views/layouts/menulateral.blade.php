<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/aiom.css">

<style>
body {font-family: "Lato", sans-serif;}

.sidebar {
  height: 100%;
  width: 160px;
  position: fixed;

  top: 0;
  left: 0;
  background-color: #2E282A;
  overflow-x: hidden;
  padding-top: 16px;
}

.sidebar a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 20px;
  color: #818181;
  display: block;
}

.sidebar a:hover {
  color: #f1f1f1;
}

.main {
  margin-left: 160px; /* Same as the width of the sidenav */
  padding: 0px 10px;
}

@media screen and (max-height: 450px) {
  .sidebar {padding-top: 15px;}
  .sidebar a {font-size: 18px;}
}
</style>
</head>
<body>

<div class="sidebar">
  <a href="#home"><i class="fa fa-fw fa-home"></i> Inicio</a>
  <a href="#services"><i class="fa fa-fw fa-wrench"></i> Perfil</a>
  <a href="#clients"><i class="fa fa-fw fa-heart"></i>Favoritos</a>
  <a href="#contact"><i class="fa fa-fw fa-music"></i>Playlist</a>
  <a href="#contact"><i class="fa fa-fw fa-database"></i>Mi música</a>
</div>

<div class="main">
  @yield('content')
</div>

{{-- <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script>
    var swiper = new Swiper(".mySwiper", {
      slidesPerView: 3,
      spaceBetween: 30,
      slidesPerGroup: 1,
      breakpoints: {
       768: {
          slidesPerView: 2,
        },

        991: {
          slidesPerView: 3,
        },
      },
      loop: true,
      navigation:{
        nextEl:".swiper-button-next",
        prevEl: ".swiper-button-prev",
      }


    });

  </script> --}}
     
</body>
</html> 
