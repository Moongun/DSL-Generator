$(function(){
    console.log("DOM załadowany");
    
    $('.expand').on('click', function(){
        $(this).next().fadeToggle('slow');
    });
    
});