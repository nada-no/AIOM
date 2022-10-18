<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>All In One Music</title>
             <!-- bootstrap link -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/aiom.css">
             <!-- swiper css link -->
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />


    </head>
    <body>
        <div class="container container-nomargin">
            <div class="row">
                <div class="col-4 lateral">
                    <h3>Nombre de Usuario</h3>
                    <ul>
                        <li><a href="#">Favoritos</a></li>
                        <li><a href="#">Playlists</a></li>
                        <li><a href="/upload/song">Mi música</a></li>
                        <li><a href="#">Mi perfil</a></li>
                    </ul>
                </div>
                <div class="col-8">

                    @yield('content')

                </div>
                
              </div>
        </div>
        <footer class="reproductor">
            {{-- reproductor --}}
        </footer>

     <!-- bootstrap  -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

  <!-- swiper-bundle -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

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

  </script>

    </body>
</html>