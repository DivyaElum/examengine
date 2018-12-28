var baseUrl = $('meta[name="base-path"]').attr('content')

$(document).ready(function()
{
    $('#my-carousel').carousel();
})

$(document).on('click', '#my-carousel .question_buttons' , function(e)
{
    $('.question_buttons').removeClass('activate');
    $(this).addClass('activate');
});


function startTimer(element)
{
    // adding status to start timer
    var course_id   = $('input[name="course_id"]').val();
    var user_id     = $('input[name="user_id"]').val();
    var exam_id     = $('input[name="exam_id"]').val();

    var formData = new FormData();
    formData.append('user_id',user_id)
    formData.append('course_id',course_id)
    formData.append('exam_id',exam_id)

    var action = baseUrl+"/exam/updateExamResultStatus";

    $dbdata = [];
    $.ajax(
    {
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: action,
        data: formData,
        global: false,
        async: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(data)
        {
            $dbdata = data;
        }
    });

    if (!$.isEmptyObject($dbdata)) 
    {
        if ($dbdata.status == 'error') 
        {
            alert('Server failure, Please try again later.');
            return false;
        }

        $('#examForm').append('<input type="hidden" name="result_id" value="'+$dbdata.result+'">');
    }
    else
    {
        alert('Server failure, Please try again later.');
        return false;
    }

    var hours = $(element).attr('data-hours');

    document.getElementById('startExam').style.display = 'none';
    document.getElementById('exam').style.display = 'block';

    var countDownDate = new Date().addHours(hours)

    // Update the count down every 1 second
    var x = setInterval(function() 
    {

        // Get todays date and time
        var now = new Date().getTime();
        
        // Find the distance between now and the count down date
        var distance = countDownDate - now;
        
        // Time calculations for days, hours, minutes and seconds
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        // Output the result in an element with id="demo"
        console.log(hours);
        console.log(minutes);
        console.log(seconds);

        document.getElementById("demo").innerHTML = hours + " hours : " + minutes + " min : " + seconds + ' sec';
        
        // If the count down is over, write some text 
        if (distance < 0) 
        {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "00 Hours : 00 min : 00 sec";
            document.getElementById('startExam2').innerHTML = 'Completed Please wait for you result';
        }
    }, 1000);
}

function goPrevious(element)
{
    var examSrno = parseInt($(element).attr('data-qn')) - 1;
    $('.srno_'+examSrno).trigger('click');
}

function goNext(element)
{
    var examSrno = parseInt($(element).attr('data-qn')) + 1;
    $('.srno_'+examSrno).trigger('click');
}

