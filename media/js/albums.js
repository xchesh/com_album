jQuery.noConflict();
jQuery(document).ready(function($) {
    $('.album input').change(function(){
        if($(this).prop("checked")){
            $(this).parent().addClass('check').find('img').animate({'opacity':'0.4'});
        }else{
            $(this).parent().removeClass('check').find('img').animate({'opacity':'1'});
        }
    });
});