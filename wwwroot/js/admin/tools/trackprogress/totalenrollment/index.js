$('.send-email').click(function(e) {
    $('.send-email-form').removeClass('hidden');
    $('.send-email-success').addClass('hidden');
    $('.send-email-fail').addClass('hidden');
    $('.email-no').html('Cancel');
    $('.email-yes').removeClass('hidden');

    $('.send-email-prompt').modal('show');
    var emailaddresses = [];
    $('.email-select').each(function(){
        if($(this).is(':checked'))                
            emailaddresses.push($(this).parents('tr').find('.emailaddress').html());
    });
    $('.to').val(emailaddresses.join());
});
$('.email-yes').click(function() {
    $('.send-email-fail').addClass('hidden');
    $('.fail-msg').html('');

    var from    = $('.from').val();
    var to      = $('.to').val();
    var cc      = $('.cc').val();
    var subject = $('.subject').val();
    var message = $('.message').val();

    var errs = [];
    
    if(from.length == 0)
        errs.push('"From" is a required field.');
    if(to.length == 0)
        errs.push('"To" is a required field.');
    if(message.length == 0)
        errs.push('"Message" is a required field.');
    
    if(errs.length == 0)
    {
        $.ajax({
            type: 'POST',
            url: '/admin/tools/trackprogress/scores',
            data: {
                from: from,
                to: to,
                cc: cc,
                subject: subject,
                message: message
            },
            success: function(response){
                $('.send-email-form').addClass('hidden');
                $('.send-email-success').removeClass('hidden');
                $('.email-no').html('Close');
                $('.email-yes').addClass('hidden');
            }
        });
    }
    else
    {
        for(var i = 0; i < errs.length; i++)
        {
            $('.fail-msg').append('<li>' + errs[i] + '</li>');
        }

        $('.send-email-fail').removeClass('hidden');
    }
});
$('.select-all').click(function(){
    var $checks = $('.email-select');

    if($(this).children('span').hasClass('glyphicon-ok'))
    {
        $(this).children('span').removeClass('glyphicon-ok');
        $(this).children('span').addClass('glyphicon-remove');
        $checks.each(function(){
            $(this).prop('checked', true);
        });
    }
    else
    {
        $(this).children('span').removeClass('glyphicon-remove');
        $(this).children('span').addClass('glyphicon-ok');
        $checks.each(function(){
            $(this).prop('checked', false);
        });
    }        
});