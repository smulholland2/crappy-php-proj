/*jQuery('.training-submit').submit(function(e) {
    e.preventDefault();
    console.log('submitted');
    var lisc = jQuery('#unbox').val();
    $.ajax({
        type: 'POST',
        url: '/account/login.php',
        data: { account_type: lisc },
        beforeSend:function() {
            // append a loading image
            console.log('sending');
        },
        success:function(data) {
            // successful request; redirect to training main page
            window.location.href="http://tapseries-assets.s3-website-us-east-1.amazonaws.com/fsh/shell.html?u=" + lisc;
        },
        error:function() {            
            // failed request; display course selection list
            $('#lookupError').modal();                
        }
    })
})*/