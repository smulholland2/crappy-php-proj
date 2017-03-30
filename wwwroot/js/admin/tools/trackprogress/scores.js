$('.view-score').click(function(e){
    e.preventDefault();

    var hash = $(this).attr('href');
    var args = hash.substr(1);
    var ids = args.split('-');

    $.ajax({
        type: 'GET',
        url: '/admin/tools/trackprogress/scorereport/index.php',
        data: {
            studentid: ids[0],
            tablecode: ids[1],
            productid: ids[2]
        },
        success: function(response)
        {
            window.location.href="/admin/tools/trackprogress/scorereport/index.php"
        }
    });
});
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
        var data = {
            from: from,
            to: to,
            cc: cc,
            subject: subject,
            message: message
        }
        console.log(data);
        $.ajax({
            type: 'POST',
            url: '/admin/tools/trackprogress/scores',
            data: data,
            success: function(response){
                console.log(response);
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

    if($('.select-all .glyphicon').hasClass('glyphicon-ok'))
    {
        $('.select-all .glyphicon').removeClass('glyphicon-ok');
        $('.select-all .glyphicon').addClass('glyphicon-remove');
        $('.email-select').each(function(){
            $(this).prop('checked', true);
        });
    }
    else
    {
        $('.select-all .glyphicon').removeClass('glyphicon-remove');
        $('.select-all .glyphicon').addClass('glyphicon-ok');
        $('.email-select').each(function(){
            $(this).prop('checked', false);
        });
    }        
});

$('.save-data').click(function(){
    $('#track-prog-table').tableExport({type:'csv',ignoreColumn: [0,1,9,10]});
});