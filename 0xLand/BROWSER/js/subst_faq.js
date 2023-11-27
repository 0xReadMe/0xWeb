$(document).ready(function(){
    
   $('span a').bind('click', function(e){
       var p = $(this).parents('li')[0];
       
       p = $(p);
       
       if (p.hasClass('opened')){
           p.removeClass('opened').addClass('closed');
       } else {
           p.removeClass('closed').addClass('opened');
       }
       
       e.stopPropagation();
       return false;
   }) 
    
   $('.title').click(function(){
		$(this).parent().find('.descr').slideToggle();
   });
    
})

