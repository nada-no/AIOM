<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Album;
use App\Models\Playlist;
use App\Models\Song_x_artist;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;

class Player extends Controller
{
    private $song;
    private $playedSong;
    private $songXartist;

    function __construct()
    {
        $this->song = new Song();
        $this->album = new Album();
        $this->songXartist = new Song_x_artist();
    }

    function playSong($idSong)
    {
        // $this->playedSong = Song::find($idSong);
        $this->playedSong = $this->songXartist->songsArtists()
            ->where('song.id', $idSong)
            ->get()->first();
        return view("playerSong")
            ->with("song", $this->playedSong);
    }

    function queue(Request $request)
    {
        $queue = $request->session()->get('queue', []);
        return json_encode($queue);
    }

    function playQueue(Request $request)
    {
        $firstSong = $request->session()->get('queue', []);
        if ($firstSong != []) {
            $firstSong = $firstSong[0];
        } else {
            $firstSong = null;
        }
        return view("player")->with('firstSong', $firstSong);
    }

    function deleteQueue(Request $request)
    {
        FacadesSession::forget('queue');
    }

    function playPlaylist(Request $request){
        $playlist = Playlist::find($request->idPlaylist);
        $songs = $playlist->songs; 

        foreach ($songs as $song) {
            session()->push('queue',$song);
        }

        return redirect('/player');
    }
}
