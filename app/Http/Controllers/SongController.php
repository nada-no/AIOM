<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;
use App\Models\Genre;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Song_x_artist;
use App\Models\Songs_x_album;
use App\Models\Music_x_genre;
use App\Models\Favorites_songs;
use App\Services\UploadMusicService;
use App\Services\UploadCoverService;
use App\Services\UploadCoverAlbumService;
use App\Services\UploadCoverArtistService;
use App\Services\UploadCoverGenreService;

use App\Exceptions\UploadFileException;
use App\Models\account;
use App\Models\Playlist;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth;

class SongController extends Controller
{
    private $uploadCoverService;
    private $uploadMusicService;
    private $uploadCoverAlbumService;
    private $uploadCoverArtistService;
    private $uploadCoverGenreService;
    private $song;
    // private $album;
    // private $artist;
    // private $genre;
    private $error = '';
    private $playlist;
    // private $playlistsXAccount;



    public function __construct()
    {
        $this->playlist = new Playlist();
        $this->song = new Song();
        // $this->album = new Album();
        // $this->artist = new Artist();
        // $this->genre = new Genre();
    }
    // Devolver la vista con todas las canciones
    public function index()
    {
        $playlists = account::find(Auth::id())->playlists;
        $song = new Song;
        $song = $song->query();
        $song->joinFavorites();
        $song = $song->get();
        //dd($song);
        return view("music")
            ->with("songs", $song)
            ->with("playlists", $playlists);
        
    }
    

    public function addSong(Request $request,
                            UploadMusicService $UploadMusicService,
                            UploadCoverService $UploadCoverService,
                            UploadCoverAlbumService $UploadCoverAlbumService,
                            UploadCoverArtistService $UploadCoverArtistService,
                            UploadCoverGenreService $UploadCoverGenreService)
    {   
        $success = false;
        try {
            // check parameters of request
            $isValid = $request->validate([
                'title' => 'required|max:255',
                'cover' => 'required|mimes:png,jpg,jpeg,gif,png,svg|max:40048',
                'url' => 'required|mimes:mp3,m4a,mp4,wav,wma|max:100000',
                'artist_cover' => 'mimes:png,jpg,jpeg,gif,png,svg|max:40048',
                'genre_cover' => 'mimes:png,jpg,jpeg,gif,png,svg|max:40048',
                'album_cover' => 'mimes:png,jpg,jpeg,gif,png,svg|max:40048',
                'genre' => 'required|max:100',   
                'album_name' => 'required|max:100',
                'artist_name' => 'required|max:100'

            ]);
            if ($isValid) {
                $this->uploadMusicService = $UploadMusicService;
                $this->uploadCoverService = $UploadCoverService;
                $this->uploadMusicService->uploadFile($request->file('url'));
                $this->uploadCoverService->uploadFile($request->file('cover'));
                # Crear los modelos
                $song = new Song;
                $artist = new Artist;
                $album = new Album;
                $genre = new Genre;
                $songs_x_artist = new Song_x_artist;
                $songs_x_album = new Songs_x_album;
                $music_x_genre = new Music_x_genre;
                # Establecer propiedades leídas del formulario en cuanto a las songs
                $song->title = $request->title;
                $song->cover = $request->cover->getClientOriginalName();
                $song->url = $request->url->getClientOriginalName();
                $song->account_id = auth()->user()->id;
                # artistas
                $artistElement = $artist->where('name', $request->artist_name)->where('surname', $request->artist_surname)->get();
                if ($artistElement->first() != null) {
                    $artistIdExist = $artistElement->first()->id;
                }else {
                    $artist->name = $request->artist_name;
                    $artist->surname = $request->artist_surname;
                }
                if ($request->hasFile('artist_cover')) {
                    $artist->cover = $request->artist_cover->getClientOriginalName();
                    $this->uploadCoverArtistService = $UploadCoverArtistService;
                    $this->uploadCoverArtistService->uploadFile($request->file('artist_cover'));
                }
                # album
                $albumElement = $album->where('name', $request->album_name)->get();
                //dd($albumElement->first() == null);
                if ($albumElement->first() != null) {
                    $albumIdExist = $albumElement->first()->id;
                    //$request->album_name;
                }else {
                    $album->name = $request->album_name;
                }
                if ($request->hasFile('album_cover')) {
                    $album->cover = $request->album_cover->getClientOriginalName();
                    $this->uploadCoverAlbumService = $UploadCoverAlbumService;
                    $this->uploadCoverAlbumService->uploadFile($request->file('album_cover'));
                }

                // # generos
                $genreElement = $genre->where('genre', $request->genre)->get();
                if ($genreElement->first() != null) {
                    $genreIdExist = $genreElement->first()->id;
                }else {
                    $genre->genre = $request->genre;
                }
                $genre->genre = $request->genre;
                if ($request->hasFile('genre_cover')) {
                    $genre->cover = $request->genre_cover->getClientOriginalName();
                    $this->uploadCoverGenreService = $UploadCoverGenreService;
                    $this->uploadCoverGenreService->uploadFile($request->file('genre_cover'));
                }

                # Y guardar los modelos
                if ($song->save()) {
                    if (!isset($albumIdExist) ) {
                        $album->save();
                    }
                    if (!isset($genreIdExist)) {
                        $genre->save();
                    }
                    if (!isset($artistIdExist)) {
                        $artist->save();
                    }
                    $success = true;
                }
                $idsong = $song->id;
                $idartista = $artist->id;
                $idalbum = $album->id;
                $idgenre = $genre->id;
                //necessitamos vincular los canciones con los generos (music_x_genre)
                if (isset($genreIdExist)) {
                    $music_x_genre->id_genre =  $genreIdExist;
                }else {
                    $music_x_genre->id_genre =  $idgenre;
                }
                $music_x_genre->id_song = $idsong;
                $music_x_genre->save();
                // necessitamos vincular los albumes con las canciones (songs_x_album)
                if (isset($albumIdExist)) {
                    $songs_x_album->id_album =  $albumIdExist;
                    //dd($albumIdExist);
                }else {
                    $songs_x_album->id_album =  $idalbum;
                }
                $songs_x_album->id_song = $idsong;
                $songs_x_album->save();
                //necessitamos vincular los artistas con las canciones (songs_x_artist)
                if (isset($artistIdExist)) {
                    $songs_x_artist->id_artist =  $artistIdExist;
                    //dd($artistIdExist);
                }else {
                    $songs_x_artist->id_artist =  $idartista;
                }
                $songs_x_artist->id_song = $idsong;
                $songs_x_artist->save();
            }
        } catch (UploadFileException $exception) {
            //$this->error = $exception->getMessage();
            $this->error = $exception->customMessage();
        }catch ( \Illuminate\Database\QueryException $exception) {
            $this->error = "Error with information introduced";
        }
        return view('upload_song')
            ->with("success",$success);
    }

    public function updateSong(Request $request,
        UploadMusicService $UploadMusicService,
        UploadCoverService $UploadCoverService,
        UploadCoverAlbumService $UploadCoverAlbumService,
        UploadCoverArtistService $UploadCoverArtistService,
        UploadCoverGenreService $UploadCoverGenreService)
    {   
        //$idSong = $request->route("id");
        # El id para el where de SQL
        $idSongToUpdate= $request->id;
        # Obtener modelo fresco de la base de datos
        # Buscar o fallar
        $song = Song::findOrFail($idSongToUpdate);
        $success = false;
        try {
            // check parameters of request
            $isValid = $request->validate([
            'title' => 'required|max:255',
            'cover' => 'required|mimes:png,jpg,jpeg,gif,png,svg|max:40048',
            'url' => 'required|mimes:mp3,m4a,mp4,wav,wma|max:100000',
            'artist_cover' => 'mimes:png,jpg,jpeg,gif,png,svg|max:40048',
            'genre_cover' => 'mimes:png,jpg,jpeg,gif,png,svg|max:40048',
            'album_cover' => 'mimes:png,jpg,jpeg,gif,png,svg|max:40048'
            ]);
            if ($isValid) {
                $this->uploadMusicService = $UploadMusicService;
                $this->uploadCoverService = $UploadCoverService;
                $this->uploadMusicService->uploadFile($request->file('url'));
                $this->uploadCoverService->uploadFile($request->file('cover'));
                # Crear los modelos
                $song = new Song;
                $artist = new Artist;
                $album = new Album;
                $genre = new Genre;
                $songs_x_artist = new Song_x_artist;
                $songs_x_album = new Songs_x_album;
                $music_x_genre = new Music_x_genre;
                # Establecer propiedades leídas del formulario en cuanto a las songs
                $song->title = $request->title;
                $song->cover = $request->cover->getClientOriginalName();
                $song->url = $request->url->getClientOriginalName();
                # artistas
                $artist->name = $request->artist_name;
                $artist->surname = $request->artist_surname;
                if ($request->hasFile('artist_cover')) {
                    $artist->cover = $request->artist_cover->getClientOriginalName();
                    $this->uploadCoverArtistService = $UploadCoverArtistService;
                    $this->uploadCoverArtistService->uploadFile($request->file('artist_cover'));
                }
                # album
                $album->name = $request->album_name;
                if ($request->hasFile('album_cover')) {
                    $album->cover = $request->album_cover->getClientOriginalName();
                    $this->uploadCoverAlbumService = $UploadCoverAlbumService;
                    $this->uploadCoverAlbumService->uploadFile($request->file('album_cover'));
                }

                # generos
                $genre->genre = $request->genre;
                if ($request->hasFile('genre_cover')) {
                    $genre->cover = $request->genre_cover->getClientOriginalName();
                    $this->uploadCoverGenreService = $UploadCoverGenreService;
                    $this->uploadCoverGenreService->uploadFile($request->file('genre_cover'));
                }

                # Y guardar los modelos
                if ($song->save() && $artist->save() && $album->save() && $genre->save()) {
                    $success = true;
                }
                $idsong = $song->id;
                $idartista = $artist->id;
                $idalbum = $album->id;
                $idgenre = $genre->id;
                //necessitamos vincular los canciones con los generos (music_x_genre)
                $music_x_genre->id_song = $idsong;
                $music_x_genre->id_genre =  $idgenre;
                $music_x_genre->save();
                // necessitamos vincular los albumes con las canciones (songs_x_album)
                $songs_x_album->id_song = $idsong;
                $songs_x_album->id_album =  $idalbum;
                $songs_x_album->save();
                //necessitamos vincular los artistas con las canciones (songs_x_artist)
                $songs_x_artist->id_song = $idsong;
                $songs_x_artist->id_artist =  $idartista;
                $songs_x_artist->save();
            }
        } catch (UploadFileException $exception) {
            //$this->error = $exception->getMessage();
            $this->error = $exception->customMessage();
        }catch ( \Illuminate\Database\QueryException $exception) {
            $this->error = "Error with information introduced";
        }
        // return redirect('/update/song')
        //     ->with("success",$success);
        return view('update_song')
        ->with("success",$success);
    }
   
    // no lo vamos a usar este method solo lo usariamos los admins en todo caso
    public function deleteSong(Request $request)
    {
        $success = false;
        # El id para el where de SQL
        $songId = $request->route("id");
        # Obtener canción o mostrar el msg de error
        $song = Song::findOrFail($songId);
        # Eliminar
        $success = $song->delete();
        // return redirect('/delete/song')
        //     ->with("success",$success);
        return view('delete_song')
        ->with("success",$success);
    }
    public function addFavorites(Request $request) {
        $favorites = new Favorites_songs;
        $favorites->id_account = auth()->user()->id;
        $favorites->id_song = $request->idSong;
        $checkFavoriteSong = $favorites->where('id_song',$request->idSong)->first();
        if (!$checkFavoriteSong) {
            $favorites->save();
        }else {
            $checkFavoriteSong->delete();
        }
        return redirect(url()->previous());
    }
    public function listFavorites() {
        $favorites = new Favorites_songs;
        $song = $favorites->query();
        $song->joinFavorites();
        $favorites_songs = $song->listFavorites();
        return view('favorites')->with('favorites_songs', $favorites_songs);
    }

    public function listFavoritesApi() {
        $favorites = new Favorites_songs;
        $song = $favorites->query();
        $song->joinFavorites();
        $favorites_songs = $song->listFavorites();
        return $favorites_songs;

    }
    public function listDashboard() {
        $playlists = account::find(Auth::id())->playlists;
        $all_song_with_favorites = $this->song->query()->joinFavorites();
        $song = $all_song_with_favorites->limit(4)->get();
        $recently_songs = $all_song_with_favorites->latest()->take(4)->get();
        $favorites = $this->song->query();
        $favorites->joinOnlyFavorites();
        $favorites = $favorites->limit(4)->get();
        return view('music_dashboard')
            ->with("songs", $song)
            ->with("favorites_songs",$favorites)
            ->with("playlists", $playlists)
            ->with("recently_songs",$recently_songs);
    }
    public function addFavoritesTmp(Request $request) {
        $favoritos_songs_tmp = $request->session()->get('favoritos_songs_tmp', []);
        $actual = (object) array('id'=>$request->input('id'),'cover'=>$request->input('cover'), 'title'=>$request->input('title'), 'url'=>$request->input('url'));
        array_push($favoritos_songs_tmp, $actual);
        
        $request->session()->put('favoritos_songs_tmp', $favoritos_songs_tmp);
        return redirect(url()->previous());
    }
    public function addQueue(Request $request) {
        $queue = $request->session()->get('queue', []);
        $song = $this->song->query();
        $songs = $song->getQueue()->where('song.id',$request->id)->get();
        $songs = $songs->first();
        $actual = (object) array('id'=>$request->input('id'),'cover'=>$request->input('cover'), 'title'=>$request->input('title'), 'url'=>$request->input('url'), 'album_name' =>$songs->album_name, 'artist_name' => $songs->artist_name, 'genre' => $songs->genre);
        array_push($queue, $actual);
        $request->session()->put('queue', $queue);
        return redirect(url()->previous());
    }

    public function search(Request $request){
        $inputText = $request->input('searchBox');
        $song = $this->song->query();
        $song->joinResult();
        $songs = $song->Title($inputText)->get();
        $playlists = account::find(Auth::id())->playlists;
        return view('results')->with('songs', $songs)->with('playlists', $playlists);
    }
}
