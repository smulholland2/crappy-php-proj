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
        
    if(courseId == 2) {

    var ProID="fs";        


   
       
        $.ajax({
            url:'/courses/foodsafetymanager/index',
            type: 'POST',
            data: {
                state: state,
            },
            success: function(data){
                window.location.href= "/courses/shop/sc_product_list_fsm.php";
            }
        })
    }
    
    return callback($('.course-id').val());
}

function getCourseTitle(courseid)
{
    $.ajax({ 
        url:'/courses/foodsafetymanager/lookup.php',
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

$('.ks-opts').on('show.bs.modal', function (e) {
    $('.ks-yes').click(function(){
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
