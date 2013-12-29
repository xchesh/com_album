$(document).ready(function() {
    $('.gallery .image a').fancybox();
    $(".gallery  a.iframe").fancybox(
    { 
          "frameWidth" : 600,	
          "frameHeight" : 400 
    });
})
$(window).load(function(){
    image_ready ();
})
$(window).resize(function(){
    image_ready ();
})

function image_ready (){
    if ($(window).width()>640){
        var height_a = $('.gallery .image');
        var wide = {
            lenght:0,
            data: {}
        };
        var narrow = {
            lenght:0,
            data:{}
        };
        height_a.each(function(indx){
            if ($(this).outerHeight(true)>$(this).outerWidth(true)){
                narrow.lenght++;
                narrow.data[indx] = $(this);
                $(this).width('12.5%').find('img').height('100%');
            }else{
                wide.lenght++;
                wide.data[indx] = $(this);
                $(this).width('29%').find('img').height('100%');
            }
        });
        if (narrow.lenght>0){
            for(var key in narrow.data){
                height_a.eq(key).appendTo($('.gallery'));
            }
        }
    }else{
        $('.gallery .image').css({
            'width':'46%',
            'max-width': '46%'
        });
    }
}