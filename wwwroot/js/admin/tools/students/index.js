$('.course-list').change(function(e) {

    var INTRO = "You have ";
    var OUTRO = " licenses remaining for ";
    var NONE = "NO licenses remaining for ";
    var UL = "UNLIMITED";
    var NOADD = "Your account is not permitted to add student to ";
    var VOUCHER = "You can add as many students as you have voucher numbers remaining for ";

    var msgid = $(this).val();
    var remaining = $('#msg-' + msgid).html();    
    var proname = $('.course-list option:selected').text();
    var proid = $('.course-list option:selected').val();
    var $numstudents = $('.numstudents');
    var max = 0;

    if(proid != '80')
        $numstudents.removeAttr('disabled');
    else if(proid == '80')
    {
        $numstudents.val(1);
        $numstudents.attr('disabled', true);        
    }
        
    $('#fileToUpload').attr('disabled', true);
    $('.course-opts').attr('action', "/admin/tools/students/single");

    if(remaining > 20)
        max = 20;
    else if(remaining > 0 && remaining < 20)
        max = remaining;
    else if(remaining == 0)
        max = 0;

    switch (remaining)
    {
        case '0':
            $('.remain-msg').html();
            $('.remain-msg').html(INTRO + NONE + proname);
            $numstudents.attr("min", 0);
            $numstudents.attr("max", 0);
            $numstudents.val(0);
            break;
        case '-1':
            $('.remain-msg').html();
            $('.remain-msg').html(INTRO + UL + OUTRO + proname);
            $numstudents.attr("min", 1);
            $numstudents.removeAttr('max');
            $numstudents.val(1);
            break;
        case '-2':
            $('.remain-msg').html();
            $('.remain-msg').html(NOADD + proname);
            $numstudents.attr("min", 1);
            $numstudents.removeAttr('max');
            $numstudents.val(1);
            break;
        case '-3':
            $('.remain-msg').html();
            $('.remain-msg').html(VOUCHER + proname);
            $numstudents.attr("min", 1);
            $numstudents.removeAttr('max');
            $numstudents.val(1);
            break;
        default:
            $('.remain-msg').html();
            $('.remain-msg').html(INTRO + "<span class='lisc-remaining'>" + remaining + "</span>" + OUTRO + proname);
            $numstudents.attr("min", 1);
            $numstudents.attr("max", max);
            $numstudents.val(1);
            break;
    }
});

$('.numstudents').keyup(function(e){
    //Dont allow the user to go over the max licenses available.
    if(e.keyCode != 8)
    {
        //if($(this).val() < $('.lisc-remaining').html())
            //$(this).val($('.lisc-remaining').html());

        if($(this).val() > 1)
        {
            $('#fileToUpload').attr('disabled', false);
            $('.course-opts').attr('action', "/admin/tools/students/multiple");
            if($(this).val() > 20)
                $(this).val(20);
        }        
        else if($(this).val() == 1)
        {
            $('#fileToUpload').attr('disabled', true);
            $('.course-opts').attr('action', "/admin/tools/students/single");
        }
    }        
});

$('.numstudents').change(function(){
    if($(this).val() > 1)
    {
        $('#fileToUpload').attr('disabled', false);
        $('.course-opts').attr('action', "/admin/tools/students/multiple");
        if($(this).val() > 20)
            $(this).val(20);
    }        
    else if($(this).val() == 1)
    {
        $('#fileToUpload').attr('disabled', true);
        $('.course-opts').attr('action', "/admin/tools/students/single");
    }
});

$('.submit').click(function(){
    $('.course-opts').submit();
});

$('.course-opts').submit(function(e){
    if($('.numstudents').val() == '')
    {
        e.preventDefault();
        alert('Please enter the number of students you wish to add.');
    }
});