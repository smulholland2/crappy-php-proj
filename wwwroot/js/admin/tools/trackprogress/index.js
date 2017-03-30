// Vanilla JS functions to auto pop the dates.
Date.prototype.firstoflastmonth = function() {
    var mm = this.getMonth() + -1; // getMonth() is zero-based
    if(mm == 0)
        mm = 1;
    if(mm < 10 && mm > 0)
        mm = "0" + mm;
    else if(mm == -1)
        mm = 12;
    else if(mm == 0)
        mm = 1;
    var dd = "01";    
    var YYYY = this.getFullYear();

    if(mm == 12)
        YYYY = YYYY - 1;

    $('.from .month').val(mm);
    $('.from .day').val(dd);
    $('.from .year').val(YYYY);

    var fromdate = [YYYY,mm,dd];

    $('input[name="fromdate"]').val(fromdate.join("-"));
};

// Basically the same as the previous function,
// but we add an extra month to give us the next month.
Date.prototype.totoday = function() {
    var mm = this.getMonth() + 1;
    // 13 isn't a valid month.
    if(mm === 13)
        mm = 1;  // Set month to 1.
    else if(mm < 10)
        mm = "0" + mm;
    var dd = this.getDate();

    if(dd < 10)
        dd = "0" + dd;

    var YYYY = this.getFullYear();

    $('.to .month').val(mm);
    $('.to .day').val(dd)
    $('.to .year').val(YYYY);

    var todate = [YYYY,mm,dd];

    $('input[name="todate"]').val(todate.join("-"));
};

$('doucment').ready(function(){
    // Include the chosen plugin.
    console.log('Inserting file');
    $chosenFile = $('<script src="/wwwroot/lib/js/chosen/chosen.jquery.min.js" type="text/javascript"></script>');
    $('body').append($chosenFile);

    $('.from select').change(function(){
        console.log('change');
        mm = $('.from .month').val();
        dd = $('.from .day').val();
        YYYY = $('.from .year').val();

        var fromdate = [YYYY,mm,dd];

        $('input[name="fromdate"]').val(fromdate.join("-"));        
    });

    $('.to select').change(function(){
        mm = $('.to .month').val();
        dd = $('.to .day').val();
        YYYY = $('.to .year').val();

        var todate = [YYYY,mm,dd];

        $('input[name="todate"]').val(todate.join("-"));
    });
});
$('.progresstype').click(function(){
    var href = "/admin/tools/trackprogress/";
    $('.trackform').prop('action', href + $(this).val());
    // When searching for a single student,
    if($(this).val() == "singlestudent")
    {
        // we will use Ajax to bring up a student list before
        // submitting the form. The student id will be stored in
        // a hidden input. We do not need to show the datepicker.
        $('.datepicker').addClass('hidden');
        $('.single-student-info').removeClass('hidden');
    }
    else
    {
        // Auto set the date to within the last month and reveal
        // the datepicker if previously hidden by the single option.
        $('.datepicker').removeClass('hidden');
        $('.single-student-info').addClass('hidden');

        var date = new Date();
        
        date.firstoflastmonth();
        date.totoday();
    }
});

$('.courselist').change(function(){
    var productid = $('.courselist option:selected').val();
    $.ajax({
        type: 'POST',
        url: '/admin/tools/trackprogress/index',
        dataType: 'json',
        data: {productid: productid},
        success: function(response)
        {
            $('.tablecode').val(response.TableCode.trim());
        }
    });
});

$('.submit').click(function(e){
    e.preventDefault();
    $('.form-errs').addClass('hidden');
    $('.err-msg').empty();

    var selectedIndex = $(".progresstype").index($(".progresstype").find(':checked'));

    if($('.progresstype:checked').val() === 'singlestudent')
    {
        if($('.courselist').prop('selectedIndex') < 0)
        {
            $('.err-msg').append("<li>Please select a Training Program.</li>");
            $('.form-errs').removeClass('hidden');
        }

        var tablecode = $('.tablecode').val();
        var productid = $('select[name="productid"]').val();

        $.ajax({
            type: "POST",
            url: "/admin/tools/trackprogress/index",
            data: {
                tablecode: tablecode,
                productid: productid
            },
            dataType: "json",
            success: function(response)
            {
                $('.searchable').html('');
                var $response = $(response);
                var $studentsGroup = $('<div class="form-group"></div>');
                var $students = $('<select class="students form-control" size="10" name="studentid" data-placeholder="Click here to search your student list.">');                
                $.each($response,function(key, value) {
                    var name = value.NL + ", " + value.NF;
                    var $option = $('<option value="' + (value.id)  + '">' + name + '</option>');
                    $students.append($option);
                });
                $studentsGroup.append($students);
                $('.searchable').append($studentsGroup);
                $('.students').chosen({
                    no_results_text: "Sorry, no student found with the name.",
                    width: 100
                });
                $('.student-list').modal('show');
                $('.student-ok').click(function(){
                    $('.studentid').val($students.val());
                    $('form').attr('action', '/admin/tools/trackprogress/scorereport/index.php');
                    $('form').submit();
                })
            },
            failure: function(data) {
                consol.log(data);
            }
        })
    }
    else
    {
        var err = 0;
        var selectedIndex = $("input:radio[name='progresstype']").index($(".progresstype").filter(':checked'));
        console.log(selectedIndex);

        if(selectedIndex < 0)
        {
            $('.err-msg').append("<li>Please choose a Progress Type.</li>");
            err = 1;
        }

        if($('.fromdate').val() == '')
        {
            $('.err-msg').append("<li>Please enter a From Date.</li>");
            err = 1;
        }

        if($('.todate').val() == '')
        {
            $('.err-msg').append("<li>Please enter a To Date.</li>");
            err = 1;
        }
        
        if($('.courselist').prop('selectedIndex') < 0)
        {
            $('.err-msg').append("<li>Please select a Training Program.</li>");
            err = 1;
        }

        if(err == 1)
            $('.form-errs').removeClass('hidden');
        else
            $('.trackform').submit();
    }
});

