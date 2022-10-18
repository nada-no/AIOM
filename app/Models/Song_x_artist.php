<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song_x_artist extends Model
{
    use HasFactory;
    protected $table = "song_x_artist";

    public function scopeSongsArtists($query){
        return $query->join('artist', 'artist.id','song_x_artist.id_artist')
        ->Rightjoin('song', 'song.id', 'song_x_artist.id_song')
        ->select('song.*','artist.name');   
    }
}
