jQuery('.well').hide();
jQuery('.faq').click(function(){
    $this = jQuery(this);
    if($this.hasClass('active')){
        jQuery('.faq').removeClass('active');
        jQuery('.well').slideUp();
    } else {
        jQuery('.faq').removeClass('active');
        jQuery('.well').slideUp();        
        $this.find('div').slideDown();
        $this.addClass('active');
    }
});