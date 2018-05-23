<html>
<head>
<title>find your music</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css" media="screen">
body {
    margin: 0;
    background: black;
    color: white;
    font-size: 22px;
    text-align: center;
    font-family: 'Droid Sans';
}
#logo {
    background: no-repeat url(https://raw.githubusercontent.com/richard512/findyourmusic/master/find-your-music.png);
    height: 42px;
    width: 42px;
    position: fixed;
    top: 10px;
    left: 10px;
    background-size: cover;
}
#logo a {
    display: block;
    height: 100%;
    width: 100%;
}
#info {
    max-width: 450px;
    margin: 50px auto 21px;
}
#info a {
    display: block;
    color: white;
    text-decoration: none;
}
#genre {
    font-size: 42px;
}
#controls{
    font-size: 16px;
    color: gray;
    position: fixed;
    bottom: 20px;
    left: 50%;
    width: 230px;
    margin-left: -115px;
}
button {
    color: white;
    background: #4e4e4e;
    border: 0;
    padding: 10px;
    font-weight: bold;
    font-size: 20px;
    outline: none;
    min-width: 50px;
    text-align: center;
    height: 51px;
}
</style>
</head>

<body>
<div id="logo"><a href="https://github.com/richard512/findyourmusic"></a></div>
<a href="https://github.com/richard512/findyourmusic"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/365986a132ccd6a44c23a9169022c0b5c890c387/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f7265645f6161303030302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png"></a>
    
<div id="info">
    <a id="genre" href="javascript:;" title="pause and youtube GENRE"></a>
    <a id="artist" href="javascript:;" title="pause and youtube ARTIST"></a>
    <a id="song" href="javascript:;" title="pause and youtube ARTIST and SONG"></a>
</div>

<button id="prev">⏪</button>
<button id="playpause">play / pause</button>
<button id="next">⏩</button>
    
<div id="controls">
1514 genres of music will play.<br>
try space, enter, and arrow keys.<br>
tap titles to pause and youtube.
</div>

<script>
player = document.createElement('video');
currsong = -1;

music = [
<?php

$songs = scandir('songs');
foreach ($songs as $song) {
    if (substr($song, -4) == '.mp3') {
        echo '"' . $song . '",'."\n";
    }
}

?>
];

function isAndroid() {
    var ua = navigator.userAgent.toLowerCase();
    return ua.indexOf("android") > -1;
}

function shuffle(array) {
  var currentIndex = array.length, temporaryValue, randomIndex;

  // While there remain elements to shuffle...
  while (0 !== currentIndex) {

    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    // And swap it with the current element.
    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }

  return array;
}

function youtube(query){
    window.open('https://www.youtube.com/results?search_query='+escape(query))
}

function youtubeGenre() {
    if (player && !player.paused) player.pause()
    window.open('https://www.youtube.com/results?search_query='+escape(genre))
}

function youtubeArtist() {
    if (player && !player.paused) player.pause()
    window.open('https://www.youtube.com/results?search_query='+escape(artist))
}

function youtubeSong() {
    if (player && !player.paused) player.pause()
    window.open('https://www.youtube.com/results?search_query='+escape(artist+' - '+song+' lyrics'))
}

function playNextSong() {
    if (player && !player.paused) player.pause()
    genre = ''
    artist = ''
    song = ''

    if (currsong < music.length -2) {
        currsong++
        console.log('next song')
    } else {
        currsong = 0;
        console.log('next to the beginnning')
    }
    blah = music[currsong]
    info = blah.match('^([^\-]*) - ([^\-]*) - ([^\-\.]*)')
    if (info) {
        genre = info[1]
        artist = info[2]
        song = info[3]
        document.getElementById('genre').innerText = genre
        document.getElementById('genre').href = 'javascript:youtubeGenre();'
        document.getElementById('artist').innerText = artist
        document.getElementById('artist').href = 'javascript:youtubeArtist();'
        document.getElementById('song').innerText = song
        document.getElementById('song').href = 'javascript:youtubeSong();'
    }
    //player = new Audio('songs/'+blah)
    player.src = 'songs/'+blah;
    player.onloadstart = function(){
        if (isAndroid()) {
            document.getElementById('playpause').innerText = '►'
        } else {
            document.getElementById('playpause').innerText = 'Loading...'
        }
    }
    player.onloadeddata = function(){
        document.getElementById('playpause').innerText = 'Loading...'
    }
    player.onplaying = function(){
        document.getElementById('playpause').innerText = '◼'
    }
    player.onpause = function(){
        document.getElementById('playpause').innerText = '►'
    }
    player.onended = function(){
        playNextSong()
    }
    player.play()
    console.log('current song = '+music[currsong])
}
    
function volumeUp() {
    if (player.volume < 1)
    {
        player.volume += 0.1;
    }

}

function volumeDown() {
    if (player.volume > 0)
    {
        player.volume -= 0.1;
    }
}

function playPrevSong() {
    if (currsong > 1) {
        currsong = currsong - 2;
        console.log('prev song')
    } else {
        currsong = music.length -3;
        console.log('prev to the end')
    }
    playNextSong()
}

function toggleFullScreen() {
  if ((document.fullScreenElement && document.fullScreenElement !== null) ||    
   (!document.mozFullScreen && !document.webkitIsFullScreen)) {
    if (document.documentElement.requestFullScreen) {  
      document.documentElement.requestFullScreen();  
    } else if (document.documentElement.mozRequestFullScreen) {  
      document.documentElement.mozRequestFullScreen();  
    } else if (document.documentElement.webkitRequestFullScreen) {  
      document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);  
    }  
  } else {  
    if (document.cancelFullScreen) {  
      document.cancelFullScreen();  
    } else if (document.mozCancelFullScreen) {  
      document.mozCancelFullScreen();  
    } else if (document.webkitCancelFullScreen) {  
      document.webkitCancelFullScreen();  
    }  
  }  
}
    
function togglePlayer() {
    if (player.paused) {
        player.play()
    } else {
        player.pause()
    }
}

function initUI() {
    document.body.onkeyup = function(ev) {
        console.log(ev.keyCode)
        switch (ev.keyCode) {
            case 38: // up arrow
                volumeUp()
                break;
            case 39: // right arrow
                playNextSong()
                break;
            case 40: // down arrow
                volumeDown()
                break;
            case 37: // left arrow
                playPrevSong()
                break;
            case 32: // spacebar
                togglePlayer();
                break;
            case 70: // F key
            case 13: // enter
                toggleFullScreen()
                break;
        }
    }
    document.getElementById('prev').onclick = function(){
        playPrevSong();
    }
    document.getElementById('playpause').onclick = function(ev){
        console.log(ev)
        togglePlayer();
    }
    document.getElementById('next').onclick = function(){
        playNextSong();
    }

    if (isAndroid()){
        document.getElementById('controls').innerHTML = '1514 genres of music will play.<br>tap titles to pause and youtube.'
    }
}

music = shuffle(music)
playNextSong()
initUI()
</script>
</body>
</html>
