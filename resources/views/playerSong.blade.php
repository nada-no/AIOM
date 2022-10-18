@extends('layouts.lateral')

@section('content')
    <div id="player">
        <div class="card mt-5" id="playing">
            <img class="card-img-top" alt="Sin imagen de portada" src="/storage/music/covers/{{ $song->cover }}">
            <div class="card-body">
                <h3 class="card-title" id="titulo">{{ $song->title }}</h3>
                <p class="card-text" id="album">{{ $song->nombre }}</p>
            </div>

            <audio autoplay id="myAudio" ontimeupdate="onTimeUpdate()">
                <source type="audio/mpeg" src="/storage/music/audios/{{ $song->url }}">
                Your browser does not support the audio element.
            </audio>

            <script src="https://kit.fontawesome.com/a062562745.js" crossorigin="anonymous"></script>
            

            <div class="player-ctn">
                <div class="infos-ctn">
                    <div class="timer">00:00</div>
                    <div class="title"></div>
                    <div class="duration">00:00</div>
                </div>
                <div id="myProgress">
                    <div id="myBar"></div>
                </div>
                <div class="btn-ctn">
                    <div class="btn-action first-btn" onclick="previous()">
                        <div id="btn-faws-back">
                            <i class='fas fa-step-backward'></i>
                        </div>
                    </div>

                    <div class="btn-action" onclick="toggleAudio()">
                        <div id="btn-faws-play-pause">
                            <i class='fas fa-play' id="icon-play" style="display: none"></i>
                            <i class='fas fa-pause' id="icon-pause"></i>
                        </div>
                    </div>

                    <div class="btn-action" onclick="next()">
                        <div id="btn-faws-next">
                            <i class='fas fa-step-forward'></i>
                        </div>
                    </div>
                    <div class="btn-mute" id="toggleMute" onclick="toggleMute()">
                        <div id="btn-faws-volume">
                            <i id="icon-vol-up" class='fas fa-volume-up'></i>
                            <i id="icon-vol-mute" class='fas fa-volume-mute' style="display: none"></i>
                        </div>
                    </div>
                </div>
                <div class="playlist-ctn"></div>
            </div>
        </div>
    </div>
    <script>
        var currentAudio = document.getElementById("myAudio");

        currentAudio.load()

        currentAudio.onloadedmetadata = function() {
            document.getElementsByClassName('duration')[0].innerHTML = this.getMinutes(this.currentAudio.duration)
        }.bind(this);

        var interval1;

        function toggleAudio() {

            if (this.currentAudio.paused) {
                document.querySelector('#icon-play').style.display = 'none';
                document.querySelector('#icon-pause').style.display = 'block';
                this.currentAudio.play();
            } else {
                document.querySelector('#icon-play').style.display = 'block';
                document.querySelector('#icon-pause').style.display = 'none';
                this.currentAudio.pause();
            }
        }

        function pauseAudio() {
            this.currentAudio.pause();
            clearInterval(interval1);
        }

        var timer = document.getElementsByClassName('timer')[0]

        var barProgress = document.getElementById("myBar");


        var width = 0;

        function onTimeUpdate() {
            var t = this.currentAudio.currentTime
            timer.innerHTML = this.getMinutes(t);
            this.setBarProgress();
            if (this.currentAudio.ended) {
                document.querySelector('#icon-play').style.display = 'block';
                document.querySelector('#icon-pause').style.display = 'none';
                this.pauseToPlay(this.indexAudio)
                if (this.indexAudio < listAudio.length - 1) {
                    var index = parseInt(this.indexAudio) + 1
                    this.loadNewTrack(index)
                }
            }
        }


        function setBarProgress() {
            var progress = (this.currentAudio.currentTime / this.currentAudio.duration) * 100;
            document.getElementById("myBar").style.width = progress + "%";
        }


        function getMinutes(t) {
            var min = parseInt(parseInt(t) / 60);
            var sec = parseInt(t % 60);
            if (sec < 10) {
                sec = "0" + sec
            }
            if (min < 10) {
                min = "0" + min
            }
            return min + ":" + sec
        }

        var progressbar = document.querySelector('#myProgress')
        progressbar.addEventListener("click", seek.bind(this));


        function seek(event) {
            var percent = event.offsetX / progressbar.offsetWidth;
            this.currentAudio.currentTime = percent * this.currentAudio.duration;
            barProgress.style.width = percent * 100 + "%";
        }



        function toggleMute() {
            var btnMute = document.querySelector('#toggleMute');
            var volUp = document.querySelector('#icon-vol-up');
            var volMute = document.querySelector('#icon-vol-mute');
            if (this.currentAudio.muted == false) {
                this.currentAudio.muted = true
                volUp.style.display = "none"
                volMute.style.display = "block"
            } else {
                this.currentAudio.muted = false
                volMute.style.display = "none"
                volUp.style.display = "block"
            }
        }
    </script>


    </div>
@endsection
