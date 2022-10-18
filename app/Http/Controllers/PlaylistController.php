<?php

namespace App\Http\Controllers;

use App\Models\account;
use App\Models\Playlist;
use App\Models\Song_x_playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\UploadPhotoPlaylistService;
use App\Exceptions\UploadFileException;

class PlaylistController extends Controller
{
    private $playlist;
    private $uploadPhotoPlaylist;
    // private $playlistsXAccount;

    public function __construct(){
        $this->playlist = new Playlist();
    }

    public function list() {
        $playlists = account::find(Auth::id())->playlists;
        return view("playlists")->with(['playlists' => $playlists]);
    }

    public function new(Request $request,UploadPhotoPlaylistService $uploadPhotoPlaylistService){
        try {
            $this->playlist->name = $request->nombre;
            $isValid = $request->validate([
                'cover' => 'mimes:png,jpg,jpeg,gif,png,svg|max:40048'
            ]);
            if ($isValid) {
                $this->uploadPhotoPlaylist = $uploadPhotoPlaylistService;
                if ($request->hasFile('cover')) {
                    $this->playlist->cover = $request->cover->getClientOriginalName();
                    $this->uploadPhotoPlaylist->uploadFile($request->file('cover'));
                }
            }
            $this->playlist->account_id = Auth::id();
            $this->playlist->save();
        }catch (UploadFileException $exception) {
            //$this->error = $exception->getMessage();
            $this->error = $exception->customMessage(); 
        }catch ( \Illuminate\Database\QueryException $exception) {
            $this->error = "Error with information introduced on database";
        }
        return redirect('/playlists');

    }

    public function show($idPlaylist){
        $playlist = Playlist::find($idPlaylist);
        $songs = $playlist->songs; 
        // $songs = $songs->query();
        // $songs = $songs->joinAlbumArtist();
        return view('playlistSongs')->with('playlist', $playlist)->with('songs', $songs);
    }

    public function delete($idPlaylist){
        $playlist = Playlist::find($idPlaylist);
        $playlist->delete();
        return redirect('/playlists');
    }

    public function addSong(Request $request) {
        $playlist = $request->playlist_id;
        $song = $request->song_id;
        $song_x_playlist = new Song_x_playlist();
        $song_x_playlist->song_id = $song;
        $song_x_playlist->playlist_id = $playlist;
        if($song_x_playlist->save()){
            return response()->json('Guardada en la playlist', 200);
        } else {
            return response()->json('No se ha podido guardar', 500);
        }
       
    }

    public function deleteSong(Request $request) {
       
        DB::table('song_x_playlist')->where('playlist_id', $request->playlist_id)->where('song_id', $request->song_id)->delete();
        //return redirect(url()->previous());
        return response()->json('{status:ok}', 200);
    }

}
