$('.addtocart').click(function(e){
    $.ajax({ 
        url:'/courses/cart/lookup.php',
        type: "POST",
        data: { id: courseid },
        success: function(data){
            window.location.href="/courses/cart/";
        }
    });
});