@extends('layouts.lateral')

@section('content')

<div class="container mt-5">
    <h2>{{$playlist->name}}</h2>

    <a href="/playlists/play/{{ $playlist->id }}" class="btn btn-primary text-white">Reproducir playlist</a>
    
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Título</th>
          <th>Album</th>
          <th>Artist</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      @forelse ($songs as $song)
        <tr>
          <td><a class="text-decoration-none" href="/player/{{$song->id}}">{{$song->title}}</a></td>
          <td>{{$song->album_name}}</td>
          <td>{{$song->artist_name}}</td>
          <td>
            <p class="btn btn-primary text-white" onclick="deleteSong(event, {{$playlist->id}}, {{$song->id}})">Borrar canción</p>
          </td>
        </tr>
        @empty
          <p>Esta playlist está vacía</p>
      @endforelse
      </tbody>
    </table>
    <a href="/playlists/delete/{{ $playlist->id }}" class="btn btn-danger">Eliminar playlist</a>
    <script>
       async function deleteSong(e, playlistid, songid){
    const response = await fetch(`/api/playlist/deleteSong?playlist_id=${playlistid}&song_id=${songid}`);
    // console.log(e.target.parentNode.parentNode);
    var fila =e.target.parentNode.parentNode;
    fila.style.display = "none";
  }
    </script>
</div>
@endsection