//$("#wrapper").hide();
//$("#wrapper").fadeIn(2000);

//$("#errordiv").hide();
//$("#errordiv").fadeIn(2000);

$("#unbox").focus();

$("#mobile_menu").hide();
$("#menubtn, #closemenu, #tospanish2, #toenglish2, .mobilec").click(function(){
    $("#mobile_menu").toggle();
});

$("#our_courses, #testimonies, #mobilef, #accreditations, #worldd, #our_clients, footer").click(function(){
    $("#mobile_menu").hide();
});

$(".spanish").hide();

$("#tospanish,#tospanish2").click(function(){
    $(".english").hide();
    $(".spanish").show();
    $('.epurchase').removeClass('visible-xs');
    $('.spurchase').addClass('visible-xs');
});

$("#toenglish,#toenglish2").click(function(){
    $(".spanish").hide();
    $(".english").show();
    $('.epurchase').addClass('visible-xs');
    $('.spurchase').removeClass('visible-xs');
});

$(".navbar-collapse a").click(function(){
    $(".navbar-collapse").removeClass("in");
});
window.onload = function() {
    var forms = document.getElementsByTagName('form')
    for(var i = 0; i < forms.length; i++)
    {
        forms[i].reset();
    }
};
window.onunload = function(){};