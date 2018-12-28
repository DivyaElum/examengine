var basePath = $('meta[name="base-path"]').attr('content');

var player,
time_update_interval = 0;

var youtubeId = youtubeUrl.split('v=').reverse()[0];


function onYouTubeIframeAPIReady() {
    player = new YT.Player('video-placeholder', {
        width: 600,
        height: 400,
        videoId: youtubeId,
        playerVars: {
            color: 'white'
        },
        events: {
            onReady: initialize
        }
    });
}

function initialize(){

    // Update the controls on load
    // setInterval(function(){ 
    //     updateTimerDisplay();
    // }, 5000);

    // Clear any old interval.
    clearInterval(time_update_interval);

    // Start interval to update elapsed time display and
    // the elapsed part of the progress bar every second.
    setInterval(function(){ 
            updateTimerDisplay();
    }, 10000);
    


    $('#volume-input').val(Math.round(player.getVolume()));
}


// This function is called by initialize()
function updateTimerDisplay(){
    // Update current time text display.
    console.log(player.getCurrentTime());
    console.log(player.getDuration());

    // $('#current-time').text(formatTime( player.getCurrentTime() ));
    // $('#duration').text(formatTime( player.getDuration() ));

    // $('#watch_time').val(formatTime( player.getCurrentTime() ));
    // $('#duration_time').val(formatTime( player.getDuration() ));

    var formData = new FormData;
    formData.append('watch_time', player.getCurrentTime());
    formData.append('duration', player.getDuration());
    formData.append('user_id', user_id);
    formData.append('course_id', course_id);
    formData.append('prerequisite_id', prerequisite_id);
 
    $.ajax(
    {
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: basePath+'/course/updateWatchStatus',
        data: formData,
        processData: false,
        contentType: false,
        error: function (data)
        {
            console.log(data);
        },
        error: function (data)
        {
            console.log(data);   
        }
    });
}


// Sound volume


$('#mute-toggle').on('click', function() {
    var mute_toggle = $(this);

    if(player.isMuted()){
        player.unMute();
        mute_toggle.text('volume_up');
    }
    else{
        player.mute();
        mute_toggle.text('volume_off');
    }
});

$('#volume-input').on('change', function () {
    player.setVolume($(this).val());
});


// Other options


$('#speed').on('change', function () {
    player.setPlaybackRate($(this).val());
});

$('#quality').on('change', function () {
    player.setPlaybackQuality($(this).val());
});


// Playlist

$('#next').on('click', function () {
    player.nextVideo()
});

$('#prev').on('click', function () {
    player.previousVideo()
});


// Load video

$('.thumbnail').on('click', function () {

    var url = $(this).attr('data-video-id');

    player.cueVideoById(url);

});


// Helper Functions

function formatTime(time){
    time = Math.round(time);

    var minutes = Math.floor(time / 60),
        seconds = time - minutes * 60;

    seconds = seconds < 10 ? '0' + seconds : seconds;

    return minutes + ":" + seconds;
}


$('pre code').each(function(i, block) {
    hljs.highlightBlock(block);
});