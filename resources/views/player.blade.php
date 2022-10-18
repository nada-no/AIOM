@extends('layouts.lateral')

@section('content')
    <div id="player">
        <div class="card my-5" id="playing">
            @if ($firstSong == null)
            <img class="card-img-top" alt="No hay música en la queue :(" src="">
            @else
            <img class="card-img-top" alt="Sin imagen de portada" src="">
            @endif
            
            <div class="card-body">
                <h3 class="card-title" id="titulo"></h3>
                <p class="card-text" id="album"></p>
            </div>

            {{-- <audio autoplay id="myAudio" ontimeupdate="onTimeUpdate()"> --}}
            <audio autoplay id="myAudio">

                <source id="source-audio" type="audio/mpeg"
                @if ($firstSong == null)
                src="">
                @else
                src="/storage/music/audios/{{$firstSong->url}}">
                @endif
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
                    <div class="btn-action first-btn" id="previous">
                        <div id="btn-faws-back">
                            <i class='fas fa-step-backward'></i>
                        </div>
                    </div>

                    <div class="btn-action" id="toggleAudio">
                        <div id="btn-faws-play-pause">
                            <i class='fas fa-play' id="icon-play" style="display: none"></i>
                            <i class='fas fa-pause' id="icon-pause"></i>
                        </div>
                    </div>

                    <div class="btn-action" id="next">
                        <div id="btn-faws-next">
                            <i class='fas fa-step-forward'></i>
                        </div>
                    </div>
                    <div class="btn-mute" id="toggleMute" id="toggleMute">
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
        // extraido de https://codepen.io/vanderzak/pen/BayjVep?editors=0110

        (async () => {
            var interval1;
            var index = -1;
            var listAudio;
            var indexAudio = 0;
            var width = 0;

            var timer = document.getElementsByClassName('timer')[0]
            var barProgress = document.getElementById("myBar");
            var currentAudio = document.getElementById("myAudio");
            var progressbar = document.querySelector('#myProgress')
            var playListItems = document.querySelectorAll(".playlist-track-ctn");



            currentAudio.load()

            currentAudio.onloadedmetadata = function() {
                document.getElementsByClassName('duration')[0].innerHTML = getMinutes(currentAudio
                    .duration)
            }.bind(this);

            await loadSongs();
            setupPlayer();

            async function loadSongs() {
                console.log("playQueue")
                const queue = await fetch("/api/queue");
                listAudio = await queue.json();

                console.log("listAudio loaded", listAudio);
                // playNext();

                for (var i = 0; i < listAudio.length; i++) {
                    createTrackItem(i, listAudio[i].title);
                }


            }


            function createTrackItem(index, name) {
                var trackItem = document.createElement('div');
                trackItem.setAttribute("class", "playlist-track-ctn");
                trackItem.setAttribute("id", "ptc-" + index);
                trackItem.setAttribute("data-index", index);
                document.querySelector(".playlist-ctn").appendChild(trackItem);

                var playBtnItem = document.createElement('div');
                playBtnItem.setAttribute("class", "playlist-btn-play");
                playBtnItem.setAttribute("id", "pbp-" + index);
                document.querySelector("#ptc-" + index).appendChild(playBtnItem);

                var btnImg = document.createElement('i');
                btnImg.setAttribute("class", "fas fa-play");
                btnImg.setAttribute("height", "40");
                btnImg.setAttribute("width", "40");
                btnImg.setAttribute("id", "p-img-" + index);
                document.querySelector("#pbp-" + index).appendChild(btnImg);

                var trackInfoItem = document.createElement('div');
                trackInfoItem.setAttribute("class", "playlist-info-track");
                trackInfoItem.innerHTML = name
                document.querySelector("#ptc-" + index).appendChild(trackInfoItem);

            }



            function loadNewTrack(index) {
                var player = document.querySelector('#source-audio')
                player.src = "storage/music/audios/" + listAudio[index].url
                document.querySelector('.title').innerHTML = listAudio[index].title
                document.querySelector('#playing img').src = "/storage/music/covers/" + listAudio[index].cover
                currentAudio = document.getElementById("myAudio");
                currentAudio.load()
                toggleAudio()
                updateStylePlaylist(indexAudio, index)
                indexAudio = index;
            }




            function getClickedElement(event) {
                
                    var clickedIndex = event.target.getAttribute("data-index")
                    if (clickedIndex == indexAudio) { // alert('Same audio');
                        toggleAudio()
                    } else {
                        loadNewTrack(clickedIndex);
                    }
                

            }

            function toggleAudio() {

                if (currentAudio.paused) {
                    document.querySelector('#icon-play').style.display = 'none';
                    document.querySelector('#icon-pause').style.display = 'block';
                    document.querySelector('#ptc-' + indexAudio).classList.add("active-track");
                    playToPause(indexAudio)
                    currentAudio.play();
                } else {
                    document.querySelector('#icon-play').style.display = 'block';
                    document.querySelector('#icon-pause').style.display = 'none';
                    pauseToPlay(indexAudio)
                    currentAudio.pause();
                }
            }

            function pauseAudio() {
                currentAudio.pause();
                clearInterval(interval1);
            }





            function onTimeUpdate() {
                var t = currentAudio.currentTime
                timer.innerHTML = getMinutes(t);
                setBarProgress();
                if (currentAudio.ended) {
                    document.querySelector('#icon-play').style.display = 'block';
                    document.querySelector('#icon-pause').style.display = 'none';
                    pauseToPlay(indexAudio)
                    if (indexAudio < listAudio.length - 1) {
                        var index = parseInt(indexAudio) + 1
                        loadNewTrack(index)
                    }
                }
            }

            function setBarProgress() {
                var progress = (currentAudio.currentTime / currentAudio.duration) * 100;
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




            function seek(event) {
                var percent = event.offsetX / progressbar.offsetWidth;
                currentAudio.currentTime = percent * currentAudio.duration;
                barProgress.style.width = percent * 100 + "%";
            }

            function forward() {
                currentAudio.currentTime = currentAudio.currentTime + 5
                setBarProgress();
            }

            function rewind() {
                currentAudio.currentTime = currentAudio.currentTime - 5
                setBarProgress();
            }


            function next() {
                if (indexAudio < listAudio.length - 1) {
                    var oldIndex = indexAudio
                    indexAudio++;
                    updateStylePlaylist(oldIndex, indexAudio)
                    loadNewTrack(indexAudio);
                }
            }

            function previous() {
                if (indexAudio > 0) {
                    var oldIndex = indexAudio
                    indexAudio--;
                    updateStylePlaylist(oldIndex, indexAudio)
                    loadNewTrack(indexAudio);
                }
            }

            function updateStylePlaylist(oldIndex, newIndex) {
                document.querySelector('#ptc-' + oldIndex).classList.remove("active-track");
                pauseToPlay(oldIndex);
                document.querySelector('#ptc-' + newIndex).classList.add("active-track");
                playToPause(newIndex)
            }

            function playToPause(index) {
                var ele = document.querySelector('#p-img-' + index)
                ele.classList.remove("fa-play");
                ele.classList.add("fa-pause");
            }

            function pauseToPlay(index) {
                var ele = document.querySelector('#p-img-' + index)
                ele.classList.remove("fa-pause");
                ele.classList.add("fa-play");
            }


            function toggleMute() {
                var btnMute = document.querySelector('#toggleMute');
                var volUp = document.querySelector('#icon-vol-up');
                var volMute = document.querySelector('#icon-vol-mute');
                if (currentAudio.muted == false) {
                    currentAudio.muted = true
                    volUp.style.display = "none"
                    volMute.style.display = "block"
                } else {
                    currentAudio.muted = false
                    volMute.style.display = "none"
                    volUp.style.display = "block"
                }
            }

            function setupPlayer() {
                document.getElementById("previous").addEventListener("click", previous);
                document.getElementById("toggleAudio").addEventListener("click", toggleAudio);
                document.getElementById("next").addEventListener("click", next);
                document.getElementById("toggleMute").addEventListener("click", toggleMute);
                progressbar.addEventListener("click", seek.bind(this));
                currentAudio.addEventListener("timeupdate", onTimeUpdate);

                var playListItems = document.querySelectorAll(".playlist-track-ctn");
                for (let i = 0; i < playListItems.length; i++) {
                    playListItems[i].addEventListener("click", getClickedElement);
                }

                document.querySelector('#source-audio').src = listAudio[indexAudio].url
                document.querySelector('.title').innerHTML = listAudio[indexAudio].title
                document.querySelector('#p-img-0').classList.remove('fa-play');
                document.querySelector('#p-img-0').classList.add('fa-pause');
                document.querySelector('#ptc-0').classList.add('active-track');
                document.querySelector('#playing img').src = "/storage/music/covers/" + listAudio[0].cover
            }
        })();
    </script>
@endsection
