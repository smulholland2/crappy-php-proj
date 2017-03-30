$('.course-list').change(function(e) {

    const INTRO = "You have&nbsp;";
    const OUTRO = "&nbsplicenses remaining for&nbsp;";
    const NONE = "NO licenses remaining for&nbsp;";
    const UL = "UNLIMITED";
    const VOUCHER = "You can add as many students as you have voucher numbers remaining for&nbsp;";

    var msgid = $(this).val();
    var remaining = $('#msg-' + msgid).html();
    var proname = $('.course-list option:selected').text();

    switch (remaining) 
    {
        case '0':
            $('.remain-msg').html();
            $('.remain-msg').html(INTRO + NONE + proname);
            break;
        case '-1':
            $('.remain-msg').html();
            $('.remain-msg').html(INTRO + UL + OUTRO + proname);
            break;
        case '-2':
            $('.remain-msg').html();
            $('.remain-msg').html(INTRO + UL + OUTRO + proname);
            break;
        case '-3':
            $('.remain-msg').html();
            $('.remain-msg').html(VOUCHER + proname);
            break;
        default:
            $('.remain-msg').html();
            $('.remain-msg').html(INTRO + remaining + OUTRO + proname);
            break;
    }
});