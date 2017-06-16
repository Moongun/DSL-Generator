$(function(){
    console.log("DOM załadowany");
    
    $('.expand').on('click', function(){
        $(this).find('div').fadeToggle('slow');
    });
});