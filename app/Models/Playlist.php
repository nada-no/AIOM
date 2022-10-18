<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;
    protected $table = "playlist";

    // public function scopeJoinFavorites($query){
    //     return $query->join('favorites_songs', 'song.id', 'id_song')
    //         ->join('account', 'id_account', 'account.id');
    // }
    //para pillar todas las canciones de una playlist
    public function songs(){
        return $this->belongsToMany(Song::class, 'song_x_playlist')
                ->join('songs_x_album','song.id','songs_x_album.id_song')
                ->join('album','album.id','songs_x_album.id_album')
                ->join('song_x_artist','song.id','song_x_artist.id_song')
                ->join('artist','artist.id','song_x_artist.id_artist')
                ->select('song.*','album.name AS album_name','artist.name AS artist_name');
    }
}
