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
$('.dob').click(function(e) {
    e.preventDefault();
    
    // Set the course-id from the anchor tag in the map.
    var courseId = findCourse($(this).find('.course-id').attr('href'), function(callback) {        
        
    });    
});

// After a state has been selected, show the user name form.
$('.usern').click(function(e) {
    e.preventDefault();

    // Remove the leading # from the href value passed in with the id.
    var courseId = $(this).find('.course-id').attr('href');
    var courseId = courseId.split("#");
    // Set courseId as the array item without the hash.
    courseId = courseId[1];
    $('.course-id-input').val(courseId);
    // Add the Course Title to the message so users can see what they picked.
    getCourseTitle($('.course-id-input').val());
    // Hide the map.
    $('.map').addClass('hidden');

    // Show the login form container.    
    $('.welcome-msg').removeClass('hidden');
    $('.cert-login-forms').removeClass('hidden');

    // Only show the form requested.
    $('.usernform').removeClass('hidden');
    $('.dobform').addClass('hidden');

    window.scrollTo(0,0);
    
});

function findCourse(hashid, callback)
{    
    if(hashid[0] == "#") {
        // Remove the leading # from the href value passed in with the id.
        var courseId = hashid.split("#");
        // Set courseId as the array item without the hash.
        courseId = courseId[1];
    } else {
        var courseid = hashid;
    }
        
    if(courseId == 2) {
        // Handle CA
        courseId = 0;
        $('.ca-opts').modal('show');

    } else if(courseId == 10) {
        // Handle WV
        courseId = 0;
        $('.wv-opts').modal('show');

    } else if(courseId == 17) {
        // Handle KS
        courseId = 0;
        $('.ks-opts').modal('show');

    } else if(courseId == 16) {
        // Handle VA
        courseId = 0;
        $('.va-opts').modal('show');

    } else {
        $('.course-id-input').val(courseId);
        showForms();
    }
    
    return callback($('.course-id-input').val());
}

function getCourseTitle(courseid)
{    
    $.ajax({ 
        url:'/certificate/foodhandler/lookup.php',
        type: "POST",
        data: { id: courseid },
        success: function(data){
            $('.welcome-msg p span').html(data);
        }
    });
}

$('.ca-opts').on('show.bs.modal', function (e) {
    $('.ca-yes').click(function(){
        var courseId = $(this).parent().parent().find('input[name="course-opts"]:checked').val();
        $('.course-id-input').val(courseId);
        $('.ca-opts').modal('hide');
        showForms();
    });
});

$('.wv-opts').on('show.bs.modal', function (e) {
    $('.wv-yes').click(function(){
        var courseId = $(this).parent().parent().find('input[name="course-opts"]:checked').val();
        $('.course-id-input').val(courseId);
        $('.wv-opts').modal('hide');
        showForms();
    });
});

$('.ks-opts').on('show.bs.modal', function (e) {
    $('.ks-yes').click(function(){
        var courseId = $(this).parent().parent().find('input[name="course-opts"]:checked').val();
        $('.course-id-input').val(courseId);
        $('.ks-opts').modal('hide');
        showForms();
    });
});

$('.va-opts').on('show.bs.modal', function (e) {
    $('.va-yes').click(function(){
        var courseId = $(this).parent().parent().find('input[name="course-opts"]:checked').val();
        $('.course-id-input').val(courseId);
        $('.va-opts').modal('hide');
        showForms();
    });
});

function showForms()
{
    // Add the Course Title to the message so users can see what they picked.
    getCourseTitle($('.course-id-input').val());

    // Hide the map.
    $('.map').addClass('hidden');

    // Show the login form container.    
    $('.welcome-msg').removeClass('hidden');
    $('.cert-login-forms').removeClass('hidden');

    // Only show the form requested.
    $('.dobform').removeClass('hidden');
    $('.usernform').addClass('hidden');
    window.scrollTo(0,0);
}

// This allows the user to go back to the map if they selected the wrong state.
$('.welcome-msg button').click(function(e) {
    e.preventDefault();

    // Hide the form(s) and form container.
    $('.welcome-msg').addClass('hidden');
    $('.cert-login-forms').addClass('hidden');
    $('.usernform').addClass('hidden');
    $('.dobform').addClass('hidden');

    // Show the map.
    $('.map').removeClass('hidden');

    // Scroll to the top of the page.
    window.scrollTo(0,0);    
});
/*var $month = $('.month');
var $day = $('.day');
var $year = $('.year');

$day.prop( 'disabled', true);
$year.prop( 'disabled', true);

$month.change(function(e) {
    var $this = $(this);
    // Enable the day selector as long as month is not the placeholder option.
    if ($this.val() > 0)
        $day.prop( 'disabled', false);   
    // Set the number of days for Jan - Jul
    if($this.val() < 7) {        
        if($this.val() == 'February') // Feb.
            setDays(28)        
        else if($this.val() % 2 == 0) // Apr, Jun
            setDays(30)        
        else // Jan, Mar, May, Jul
            setDays(31)
    // Set the number of days for Aug - Dec
    } else {        
        if($this.val() % 2 == 0) // Aug, Oct, Dec
            setDays(31)        
        else // Sep, Nov
            setDays(30)
    }
});

$day.change(function(e) {    
    // Enable the year selector as long as day is not the placeholder option.
    if ($(this).val() > 0)
        $year.prop( 'disabled', false);
});

$year.change(function(e) {
    if ($(this).val() > 0){
        var dob = $year.val() + "-" + $month.val() + "-" + $day.val();
        $('.course-dob-input').val(dob);
    }
});*/

function setDays(num)
{
    $day.empty();
    for(var i = 1; i <= num; i++)
    {
        if (i < 10) // Put 0 in front of the single digits
            $day.append("<option value='0" + i + "'>0" + i + "</option>")
        else
            $day.append("<option value='" + i + "'>" + i + "</option>")
    }
}
