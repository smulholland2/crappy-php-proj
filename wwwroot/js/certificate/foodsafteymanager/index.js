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
    $('.usernform').removeClass('hidden');
    // Show the form based on which form type. Determined by state initials id.
});

$('.geo-print-no').click(function(){
    // Hide the short cut and show the big state list.
    $('.shortcut').hide();
    $('.map').removeClass('hidden');
    $('.usernform').addClass('hidden');
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
    //getCourseTitle($('.course-id-input').val());
    // Hide the map.
    $('.map').addClass('hidden');

    // Show the login form container.    
    $('.welcome-msg').removeClass('hidden');
    $('.cert-login-forms').removeClass('hidden');

    // Only show the form requested.
    $('.usernform').removeClass('hidden');

    window.scrollTo(0,0);
    
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

    window.scrollTo(0,0);
}

// This allows the user to go back to the map if they selected the wrong state.
$('.welcome-msg button').click(function(e) {
    e.preventDefault();

    // Hide the form(s) and form container.
    $('.welcome-msg').addClass('hidden');
    $('.cert-login-forms').addClass('hidden');
    $('.usernform').addClass('hidden');

    // Show the map.
    $('.map').removeClass('hidden');

    // Scroll to the top of the page.
    window.scrollTo(0,0);    
});