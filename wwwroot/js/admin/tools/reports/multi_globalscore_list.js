$('.save-data').click(function(){
    var btnId = $(this).attr('id');
    var idArr = btnId.split('-');
    var id = idArr[2];
    var tableId = '#report-table-'+id;
    console.log(btnId);
    console.log(idArr);
    console.log(id);
    $(tableId).tableExport({type:'csv',ignoreColumn: [0]});
});