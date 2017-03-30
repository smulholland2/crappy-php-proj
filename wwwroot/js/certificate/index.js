var h = document.getElementById('collapsing-bordered-table').scrollHeight;
var uboxes = document.getElementsByClassName("usern");
var dboxes = document.getElementsByClassName("dob");
var boxes = uboxes.length + dboxes.length;

jQuery('.welcome-msg').hide();
jQuery('.cert-login-forms').hide();
jQuery('.dobform').hide();
jQuery('.usernform').hide();

jQuery('.dob').click(function(e) {
    e.preventDefault();
    jQuery('.welcome-msg').show();
    jQuery('.cert-login-forms').show();
    jQuery('.dobform').show();
    jQuery('.usernform').hide();
    scrollToForm();
    
});
jQuery('.usern').click(function(e) {        
    e.preventDefault();
    jQuery('.welcome-msg').show();
    jQuery('.cert-login-forms').show();
    jQuery('.usernform').show();
    jQuery('.dobform').hide();
    scrollToForm();
    
});

function scrollToForm() {
    var rect1 = uboxes[0].getBoundingClientRect();
    var rect2 = uboxes[2].getBoundingClientRect();
    console.log(rect1.top + " " + rect2.top);
    if(rect1.top === rect2.top) {
        var scrollY = boxes * uboxes[0].scrollHeight / 5;
        console.log(scrollY);        
        window.scrollTo(0,scrollY);
    } else {
        var scrollY = boxes * uboxes[0].scrollHeight;        
        window.scrollTo(0,scrollY);
    }        
}
$('.date').datepicker({    
    autoclose: true,
    clearBtn: true,
    orientation: "bottom left",
    todayHighlight: true,
    maxViewMode: 2,
});
