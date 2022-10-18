<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account')->insert([
            'nick' => 'acuesta',
            'email' => 'adan@adan.com',
            'password' => Hash::make('adan')
        ]);
        DB::table('account')->insert([
            'nick' => 'dani',
            'email' => 'dani@dani.com',
            'password' => Hash::make('dani')
        ]);

        DB::table('song')->insert([
            'title' => 'catedral',
            'url' => 'Pöls - Instinto - 01 Catedral.mp3',
            'cover' => 'pols_instinto.jpg',
            'account_id' => 1
        ]);

        DB::table('song')->insert([
            'title' => 'instinto',
            'url' => 'Pöls - Instinto - 02 Instinto.mp3',
            'cover' => 'pols_instinto.jpg',
            'account_id' => 1
        ]);

        DB::table('song')->insert([
            'title' => 'no te preu',
            'url' => 'Pöls - Instinto - 03 No té preu.mp3',
            'cover' => 'pols_instinto.jpg',
            'account_id' => 1
        ]);

        DB::table('song')->insert([
            'title' => 'sigo aqui',
            'url' => 'Pöls - Instinto - 04 Sigo aquí.mp3',
            'cover' => 'pols_instinto.jpg',
            'account_id' => 1
        ]);

        DB::table('song')->insert([
            'title' => 'One dance',
            'url' => 'one_dance.mp3',
            'cover' => 'one_dance.jpeg',
            'account_id' => 2
        ]);
        DB::table('song')->insert([
            'title' => 'In my feelings',
            'url' => 'in_my_feelings.mp3',
            'cover' => 'in_my_feelings.jpeg',
            'account_id' => 2
        ]);
        DB::table('song')->insert([
            'title' => 'Still Dre',
            'url' => 'still_dre.mp3',
            'cover' => 'still_dre.jpg',
            'account_id' => 2
        ]);

        DB::table('album')->insert([
            'name' => 'instinto',
            'cover' => null,
        ]);
        DB::table('album')->insert([
            'name' => 'Views',
            'cover' => null,
        ]);
        DB::table('album')->insert([
            'name' => 'Scorpion',
            'cover' => null,
        ]);
        DB::table('album')->insert([
            'name' => '2001',
            'cover' => null,
        ]);

        DB::table('artist')->insert([
            'name' => 'Pöls',
            'cover' => null,
        ]);
        DB::table('artist')->insert([
            'name' => 'Drake',
            'cover' => null,
        ]);
        DB::table('artist')->insert([
            'name' => 'Snoop Dogg, Dr. Dre',
            'cover' => null,
        ]);

        DB::table('song_x_artist')->insert([
            'id_song' => 1,
            'id_artist' => 1,
        ]);

        DB::table('song_x_artist')->insert([
            'id_song' => 2,
            'id_artist' => 1,
        ]);

        DB::table('song_x_artist')->insert([
            'id_song' => 3,
            'id_artist' => 1,
        ]);

        DB::table('song_x_artist')->insert([
            'id_song' => 4,
            'id_artist' => 1,
        ]);

        DB::table('song_x_artist')->insert([
            'id_song' => 5,
            'id_artist' => 2,
        ]);

        DB::table('song_x_artist')->insert([
            'id_song' => 6,
            'id_artist' => 2,
        ]);
        
        DB::table('song_x_artist')->insert([
            'id_song' => 7,
            'id_artist' => 3,
        ]);
        DB::table('songs_x_album')->insert([
            'id_song' => 1,
            'id_album' => 1,
        ]);

        DB::table('songs_x_album')->insert([
            'id_song' => 2,
            'id_album' => 1,
        ]);

        DB::table('songs_x_album')->insert([
            'id_song' => 3,
            'id_album' => 1,
        ]);

        DB::table('songs_x_album')->insert([
            'id_song' => 4,
            'id_album' => 1,
        ]);

        DB::table('songs_x_album')->insert([
            'id_song' => 5,
            'id_album' => 2,
        ]);
        DB::table('songs_x_album')->insert([
            'id_song' => 6,
            'id_album' => 3,
        ]);
        DB::table('songs_x_album')->insert([
            'id_song' => 7,
            'id_album' => 4,
        ]);
        DB::table('genres')->insert([
            'genre' => 'rock',
            'cover' => null
        ]);
        DB::table('genres')->insert([
            'genre' => 'pop',
            'cover' => null
        ]);
        DB::table('genres')->insert([
            'genre' => 'rap',
            'cover' => null
        ]);
        DB::table('music_x_genre')->insert([
            'id_genre' => 1,
            'id_song' => 1
        ]);
        DB::table('music_x_genre')->insert([
            'id_genre' => 1,
            'id_song' => 2
        ]);
        DB::table('music_x_genre')->insert([
            'id_genre' => 1,
            'id_song' => 3
        ]);
        DB::table('music_x_genre')->insert([
            'id_genre' => 1,
            'id_song' => 4
        ]);
        DB::table('music_x_genre')->insert([
            'id_genre' => 2,
            'id_song' => 5
        ]);
        DB::table('music_x_genre')->insert([
            'id_genre' => 2,
            'id_song' => 6
        ]);
        DB::table('music_x_genre')->insert([
            'id_genre' => 3,
            'id_song' => 7
        ]);
        
    }
}
