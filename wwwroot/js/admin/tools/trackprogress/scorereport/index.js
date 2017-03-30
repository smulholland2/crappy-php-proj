$('.change-email').click(function(){
    $('.change-email-prompt').modal('show');
    $('.change-email-form').removeClass('hidden');
    $('.change-email-fail').addClass('hidden');
    $('.change-email-success').addClass('hidden');
    $('.email-yes').removeClass('hidden');
    $('.email-no').html('Cancel');
    $('.newemail').val($('.emaillabel').html());
});

$('.email-yes').click(function(){
    var newemail = $('.newemail').val();
    var newfirstname = $('.newfirstname').val();
    var newlastname = $('.newlastname').val();
    var newpassword = $('.newpassword').val();
    var studentid = $('.studentid').val();
    var tablecode = $('.tablecode').val();
    $.ajax({
        type: 'POST',
        url: '/admin/tools/trackprogress/scorereport/index.php',
        data: { 
            newemail: newemail,
            newfirstname: newfirstname,
            newlastname: newlastname,
            newpassword: newpassword,
            studentid: studentid,
            tablecode: tablecode 
        },
        success: function(response){                
            if(response.length > 0)
            {
                $('.change-email-fail').removeClass('hidden');
                $('.fail-msg').html(response);
            }
            else
            {
                $('.change-email-form').addClass('hidden');
                $('.change-email-success').removeClass('hidden');
                $('.email-no').html('Close');
                $('.email-yes').addClass('hidden');
                $('.emaillabel').html(newemail);
                $('.fullname').html(newfirstname + " " + newlastname);
            }
        }
    })
});

$('.resend-creds').click(function(){
    var resend = $('.emaillabel').html();
    var studentid = $('.studentid').val();
    var tablecode = $('.tablecode').val();
    var productid = $('.productid').val();
    $.ajax({
        type: 'POST',
        url: '/admin/tools/trackprogress/scorereport/index.php',
        data: { 
            resend: resend,
            studentid: studentid,
            tablecode: tablecode,
            productid: productid,
        },
        success: function(response){
            console.log(response);
            if(response.length == 0)
            {
                $('.resend-creds-confirm').modal('show');
                $('.resend-creds-success').removeClass('hidden');
                $('.resend-creds-fail').addClass('hidden');
            }
            else
            {
                $('.resend-creds-confirm').modal('show');
                $('.resend-creds-success').addClass('hidden');
                $('.resend-creds-fail').removeClass('hidden');
            }
        }
    })
});