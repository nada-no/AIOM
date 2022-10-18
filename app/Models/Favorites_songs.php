<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorites_songs extends Model
{
    use HasFactory;
    protected $table = "favorites_songs";

    public function scopeJoinFavorites($query){
        return $query->join('song', 'song.id', 'id_song')
            ->join('songs_x_album','song.id','songs_x_album.id_song')
            ->join('album','album.id','songs_x_album.id_album')
            ->join('song_x_artist','song.id','song_x_artist.id_song')
            ->join('artist','artist.id','song_x_artist.id_artist')
            ->join('music_x_genre','music_x_genre.id_song','song.id')
            ->join('genres','genres.id','music_x_genre.id_genre')
            ->where("id_account",auth()->user()->id)
            ->orWhere("id_account",null);
    }
    public function scopeJoinLeftFavorites($query){
        return $query->Leftjoin('song', 'song.id', 'id_song')
            ->join('account', 'account.id', 'id_account');
    }
    public function scopeListFavorites($query){
        return $query->select('song.*','genres.genre','album.name AS album_name','artist.name AS artist_name','id_account')->get();
    }
}
