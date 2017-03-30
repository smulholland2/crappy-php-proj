$('.tree-toggle').click(function () {
	$(this).parent().children('ul.tree').toggle(200);
});
$('.tree-toggle').parent().children('ul.tree').toggle(200);

$('.admin-menu-item').click(function(e){  
  $.ajax({
    type: 'POST',
    url: 'formLoader.php',
    data: { form: $(this).attr("id")},
    beforeSend:function(){
      // this is where we append a loading image
      //$('#ajax-panel').html('<div class="loading"><img src="/images/loading.gif" alt="Loading..." /></div>');
    },
    success:function(data){
      // successful request; clear the container and load the new form.
      $('.admin-form-container').html("");
      $('.admin-form-container').load(data);
    },
    error:function(){
      // failed request; give feedback to user
      //$('#ajax-panel').html('<p class="error"><strong>Oops!</strong> Try that again in a few moments.</p>');
    }
  });
});