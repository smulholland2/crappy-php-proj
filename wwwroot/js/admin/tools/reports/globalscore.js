$('.report-grid').hide();
$('.date').datepicker({
    autoclose: true,
    clearBtn: true,
    orientation: "bottom left",
    todayHighlight: true,
    maxViewMode: 2,
});
jQuery('.new-search').click(function(){
    $('.report-grid').hide();
    $('.report-search-form').show();    
});
/*
jQuery("form").submit(function(e){
    e.preventDefault();
    var searchfrom = $('input[name=start]').val();        
    var searchto = $('input[name=end]').val();
    var product = $('select[name=productid]').val();
    $.ajax({
        type: 'POST',
        url: 'report.php',
        data: { from: searchfrom, to: searchto, productid: product },
        dataType: 'json',
        beforeSend:function(){
            // this is where we append a loading image
            //$('#ajax-panel').html('<div class="loading"><img src="/images/loading.gif" alt="Loading..." /></div>');
            $('#status-panel').show();
        },
        success: function(data){
            // successful request. parse the data into a grid.
            console.log(data["students"]);
            console.log(data["students"].length);
            loadGrid(data["students"]);
        },        
        error:function(){
            // failed request; give feedback to user
            $('#error-panel').show();
            $('#error-panel .error-log').html("Error");            
        }
    });
});
*/

function loadGrid(data)
{    
    $('#status-panel').hide();
    $('#error-panel').hide();
    $('.report-search-form').hide();
    $('.report-grid').show();

    //var i = 1;
    //for(var students in data) {
    for(var i = 0; i < data.length; i++){
        var $row = $('<tr></tr>');

        $row
            .append('<td>' + (i + 1) + '</td>')
            .append('<td>' + data[i]["NF"] + '</td>')
            .append('<td>' + data[i]["NL"] + '</td>')
            .append('<td>' + data[i]["UU"] + '</td>')
            .append('<td>' + data[i]["UC"] + '</td>')
            .append('<td>' + data[i]["UM"] + '</td>')

        $('.report-grid tbody').append($row);
            
    }
}
