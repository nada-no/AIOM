@extends('layouts.lateral')

@section('content')
    <div class="container mt-5">
        <h2>Playlists</h2>

        <button class="accordion" id="accordion">Crear nueva playlist</button>
        <div class="panel form-group">
          <form action="/addPlaylist" method="post" enctype="multipart/form-data">
            @csrf
            <input type="text" placeholder="Nombre de la playlist" name="nombre" id="name" required>
            <input type="file" name="cover">
            <input type="submit" value="Crear" class="btn btn-primary">
          </form>
        </div>

        <div class="d-flex flex-row justify-content-around flex-wrap mt-5">

            @forelse ($playlists as $playlist)
            <div class="card m-2">
                @if ($playlist->cover != null)
                    <img class="card-img-top cover-size" src="storage/playlist/covers/{{ $playlist->cover }}"
                        alt="Card image cap">
                @else
                    <img class="card-img-top cover-size" src="img/default-playlist.jpeg" alt="Card image cap">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $playlist->name }}</h5>
                    <a href="/playlists/{{ $playlist->id }}" class="btn btn-primary text-white">Ir a la playlist</a>
                </div>
            </div>

            @empty
                <p>No tienes playlist guardadas aún</p>
            @endforelse

        </div>
    </div>
    <script>
        var acc = document.getElementById("accordion");
        acc.addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    </script>
@endsection
