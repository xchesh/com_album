jQuery.noConflict();
jQuery(document).ready(function($) {
    $('.gallery .image a').fancybox();
    $(".gallery  a.iframe").fancybox(
    { 
          "frameWidth" : 600,	
          "frameHeight" : 400 
    });
})
jQuery(window).load(function(){
    image_ready ();
})
jQuery(window).resize(function(){
    image_ready ();
})

function image_ready (){
    if (jQuery('.gallery').width()>640){
        var height_a = jQuery('.gallery .image');
        var wide = {
            lenght:0,
            data: {}
        };
        var narrow = {
            lenght:0,
            data:{}
        };
        height_a.each(function(indx){
            if (jQuery(this).outerHeight(true)>jQuery(this).outerWidth(true)){
                narrow.lenght++;
                narrow.data[indx] = jQuery(this);
                jQuery(this).width('12.5%').find('img').height('100%');
            }else{
                wide.lenght++;
                wide.data[indx] = jQuery(this);
                jQuery(this).width('29%').find('img').height('100%');
            }
        });
        if (narrow.lenght>0){
            for(var key in narrow.data){
                height_a.eq(key).appendTo(jQuery('.gallery'));
            }
        }
    }else{
        jQuery('.gallery .image').css({
            'width':'46%',
            'max-width': '46%'
        });
    }
}