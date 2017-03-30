/** GEO LOCATION EVENTS  **/

$('.geo-print-yes').click(function(){
    // Show the login form, by pass big state list.
    // Grab the state's name from hidden input.
    var stateref = $('.state-ref').val();

    // Look up state in state list.    
    var $staterow = $('.map').find('#' + stateref);

    // Remove the hidden classes to show the form header and container.
    $('.welcome-msg').removeClass('hidden');
    $('.cert-login-forms').removeClass('hidden');

    // Hide the shortcut form.
    $('.shortcut').hide();

    // Show the form based on which form type. Determined by state initials id.
    $staterow.hasClass('dob') ? $('.dobform').removeClass('hidden') : $('.usernform').removeClass('hidden');
});

$('.geo-print-no').click(function(){
    // Hide the short cut and show the big state list.
    $('.shortcut').hide();
    $('.map').removeClass('hidden');
});


$('.geo-print-wrong').click(function(){
    // Remove the location data from the session so it doesn't keep bothering the user.
    $.ajax({ 
        url:'/config/geo.php',
        type: "POST",
        data: { location: null },
        success: function(data) {
            alert("Location data removed.")
        }
    });

    // Keep these out of the success function in case there is a PHP error.
    // Hide the short cut form.
    $('.shortcut').hide();

    // Show the big state list.
    $('.map').removeClass('hidden');
});

/** STATE LIST EVENTS  **/
// After a state has been selected, show the dob form.
$('.state-list div div').click(function(e) {
    e.preventDefault();
    
    // Set the course-id from the anchor tag in the map.
    var hashid = $(this).find('.course-id').attr('href');
    var state = $(this).attr('id');
    var courseId = findCourse(state, hashid, function(callback) {

    });    
});


function findCourse(state, hashid, callback)
{    
    if(hashid[0] == "#") {
        // Remove the leading # from the href value passed in with the id.
        var courseId = hashid.split("#");
        // Set courseId as the array item without the hash.
        courseId = courseId[1];
    } else {
        var courseid = hashid;
    }

    if(courseId == "california") {
        // Handle CA
        courseId = 0;
        $('.ca-opts').modal('show');
    } 
    else if(courseId == "wvirginia") {
        // Handle WV
        courseId = 0;
        $('.wv-opts').modal('show');
    }
    else if(courseId == "alaska") {
        // Handle WV
        courseId = 0;
        $('.ak-opts').modal('show');
    }
    else if(courseId == "virginia") {
        // Handle WV
        courseId = 0;
        $('.va-opts').modal('show');
    }
    else {
        

        if(courseId == 21){
            var ProID = "azfsh";
        }
        else if(courseId == 75){
            var ProID = "flfsh";
        }
        else if(courseId == 162){
            var ProID = "ilfsh";
        }
        else if(courseId == 76){
            var ProID = "ksfsh";
        }
        else if(courseId == 164){
            var ProID = "mofsh";
        }
        else if(courseId == 18){
            var ProID = "nmfsh";
        }
         else if(courseId == 13){
            var ProID = "idfsh";
        }
        else if(courseId == 24){
            var ProID = "ohfsh";
        }
        else if(courseId == 105){
            var ProID = "txfsh";
        }
        else if(courseId == 80){
            var ProID = "utfsh";
        }
        else if(courseId == 74){
            var ProID = "vaccfsh";
        }
        else{
            var ProID = "nfon";
        }
       
        $.ajax({
            url:'/courses/foodhandler/index',
            type: 'POST',
            data: {
                state: state,
            },
            success: function(data){
                window.location.href= "/courses/foodhandler/description/" + ProID;
            }
        })
    }
    
    return callback($('.course-id').val());
}

function getCourseTitle(courseid)
{
    $.ajax({ 
        url:'/courses/foodhandler/lookup.php',
        type: 'POST',
        data: { id: courseid },
        success: function(data){
            $('.welcome-msg p span').html(data);
        }
    });
}

$('.ca-opts').on('show.bs.modal', function (e) {
    $('.ca-yes').click(function(){
        var courseId = $(this).parent().parent().find('input[name="course-opts"]:checked').val();
        window.location.href="/courses/foodhandler/description/" + courseId;
    });
});

$('.wv-opts').on('show.bs.modal', function (e) {
    $('.wv-yes').click(function(){
        var courseId = $(this).parent().parent().find('input[name="course-opts"]:checked').val();
        window.location.href="/courses/foodhandler/description/" + courseId;
    });
});

$('.ak-opts').on('show.bs.modal', function (e) {
    $('.ak-yes').click(function(){
        var courseId = $(this).parent().parent().find('input[name="course-opts"]:checked').val();
        window.location.href="/courses/foodhandler/description/" + courseId;
    });
});

$('.va-opts').on('show.bs.modal', function (e) {
    $('.va-yes').click(function(){
        var courseId = $(this).parent().parent().find('input[name="course-opts"]:checked').val();
        window.location.href="/courses/foodhandler/description/" + courseId;
    });
});
