@extends('layouts.lateral')

@section('content')
    <div class="container mt-5">
        <h1>Dashboard</h1>
        <h2>Mi música</h2>
        <div class="d-flex flex-row justify-content-around flex-wrap">
            @forelse ($songs as $song)
                <a href="/player/{{ $song->id }}">
                    <div class="card m-2">
                        <img class="card-img-top cover-size" src="/storage/music/covers/{{ $song->cover }}"
                            alt="Card image cap">
                        <div class="card-body px-5">
                            <h5 class="card-title">{{ $song->title }}</h5>
                            <p class="card-text mb-2 mt-2">{{ $song->artist_name }}</p>
                            <p class="card-text mb-2 mt-2">{{ $song->album_name }}</p>
                            <div class="btn-play"><i class="fa fa-play"></i></div>

                        </div>
                    </div>
                </a>
            @empty
                <p>No tienes música aún</p>
            @endforelse
        </div>
    </div>
    <div class="container mt-5">
        <h2>Favoritos</h2>
        <div class="d-flex flex-row justify-content-around flex-wrap">
            @forelse ($favorites_songs as $favorite)
            <a href="/player/{{ $favorite->id }}">
              <div class="card m-2">
                  <img class="card-img-top cover-size" src="/storage/music/covers/{{ $favorite->cover }}"
                      alt="Card image cap">
                  <div class="card-body px-5">
                      <h5 class="card-title">{{ $favorite->title }}</h5>
                      <p class="card-text mb-2 mt-2">{{ $favorite->artist_name }}</p>
                      <p class="card-text mb-2 mt-2">{{ $favorite->album_name }}</p>
                      <div class="btn-play"><i class="fa fa-play"></i></div>

                  </div>
              </div>
          </a>
            @empty
                <p>No tienes música favorita aún</p>
            @endforelse
        </div>
    </div>
    <div class="container mt-5">
        <h2>Añadidas recientemente</h2>
        <div class="d-flex flex-row justify-content-around flex-wrap">
            @forelse ($recently_songs as $song)
            <a href="/player/{{ $song->id }}">
              <div class="card m-2">
                  <img class="card-img-top cover-size" src="/storage/music/covers/{{ $song->cover }}"
                      alt="Card image cap">
                  <div class="card-body px-5">
                      <h5 class="card-title">{{ $song->title }}</h5>
                      <p class="card-text mb-2 mt-2">{{ $song->artist_name }}</p>
                      <p class="card-text mb-2 mt-2">{{ $song->album_name }}</p>
                      <div class="btn-play"><i class="fa fa-play"></i></div>

                  </div>
              </div>
          </a>
            @empty
                <p>No hay música recientemente añadida</p>
            @endforelse
        </div>
    </div>
    <div class="container mt-5">
        <h2>Playlists</h2>
        <div class="d-flex flex-row justify-content-around flex-wrap">
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
@endsection
