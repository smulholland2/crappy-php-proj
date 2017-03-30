$('.pass-input').keydown(function(e)
{
    if($(this).val().length >= 24 )
    {
        if(e.keyCode != 8)
        {
            var currentpass = $(this).val();
            alert("Passwords can only contain 24 characters");
            var maxpass = currentpass.substring(0,23);
            $(this).val(currentpass);
        }
    }
});

$('.user-input').keydown(function(e)
{
    if($(this).val().length >= 69 )
    {
        if(e.keyCode != 8)
        {
            var currentpass = $(this).val();
            alert("Username can only contain 69 characters");
            var maxpass = currentpass.substring(0,23);
            $(this).val(currentpass);
        }
    }
});

window.onload = function()
{
    var confirmpass = document.getElementById('confirmpass');
    confirmpass.onpaste = function(e)
    {
        e.preventDefault();
    }

    var confirmemail = document.getElementById('confirmemail');
    confirmemail.onpaste = function(e)
    {
        e.preventDefault();
    }
}