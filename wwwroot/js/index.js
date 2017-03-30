$(document).ready(function(){
    getLocation();
});

function swapImages(){
    var $active = $('#fadingText .active');
    var $next = ($('#fadingText .active').next().length > 0) ? $('#fadingText .active').next() : $('#fadingText p:first');

    $active.fadeOut( 400,function() {
        $active.removeClass('active');
      	$next.fadeIn(400).addClass('active');
    });
}

$(document).ready(function(){
    // Run our swapImages() function every 5secs
    setInterval('swapImages()', 5000);
    $('.carousel').carousel({
        interval: 2000
    });
});
	
/*    
$(".coursesmenu, #purchasecourse").click(function() {
    $('html, body').animate({
        scrollTop: $("#course-list").offset().top
    }, 2000);
});
*/

$("#courses_scroll").click(function() {
    $('html, body').animate({
        scrollTop: $("#course-list").offset().top
    }, 2000);
});

$("#purchasecourse").click(function() {
    $('html, body').animate({
        scrollTop: $("#course-list").offset().top
    }, 2000);
});


/*
$("#logo").click(function() {
    $('html, body').animate({
        scrollTop: $("#wrapper").offset().top
    }, 2000);
});

*/

/*function getLocation() {
    // Check to see if the location is already set.
    var locset = 0;
    $.ajax({ 
        url:'/config/config.php',
        type: 'POST',
        data: {loccheck: true},
        success: function(response){
            locset = response;
        }
    });

    // Set the location if it is not already set.
    if (navigator.geolocation && locset == 0) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}*/

/*function showPosition(position) {
    var lat = position.coords.latitude;
    var long = position.coords.longitude;
    var openingmsg = "We have determined that you are in "
    var confirmmsg = ". Is that correct? "
    $.ajax({ 
        url:'http://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ','+ long,
        success: function(data){            
            var locdata = data.results[4].formatted_address.split(",");
            $('.geostate').val(locdata[0]);            
            $('.modal-msg').html(openingmsg + locdata[0] + confirmmsg);
            $('.geo-confirm').modal('show');
        }
    });
}*/

/*$('.geo-yes').click(function(){
    var locdata = $('.geostate').val();
    $('.geo-confirm').modal('hide');
    $.ajax({ 
        url:'/config/config.php',
        type: "POST",
        data: { location: locdata },
        success: function(data){
            console.log(data);    
        },
        failure: function(data) {
            consol.log(data);
        }
    });    
});*/