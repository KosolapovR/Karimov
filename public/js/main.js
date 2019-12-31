$(document).ready(function(){
    
    var $main_photo = $("#photo__main");
    var $secondary_photo_1 = $('#photo__secondary--1');
    var $secondary_photo_2 = $('#photo__secondary--2');
    var $secondary_photo_3 = $('#photo__secondary--3');
    
    $('.photos__item').on('click', function(){
        if(!$('img').is('#photo__main__fade')){
            var buffer = $main_photo.attr('src');
        
        $('.photo__main').append(
            "<img src='" + buffer + "' id='photo__main__fade' alt='product' style='position:absolute;z-index:1000;top:0;'>"
        );
         
        $('#photo__main__fade').fadeOut(400, function(){$(this).remove()});

        $main_photo.attr('src', $(this).attr('src'));
        $(this).attr('src', buffer);
        }
    });
    
    //поиск по сайту
    
    let $search = $('#search');
    let start = new Date();
    $search.on('keyup', function(){

        let now = new Date();
        if(now - start > 1000){
            console.log($(this).val());
            start = now;
        }
    });
    
});