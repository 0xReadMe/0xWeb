(function(window, $, undefined){
    
    function showUl(e){
        $('li.lang').each(function(){
            $(this).show();
        })
    }
    
    function hideUl(e){
        $('li.lang').each(function(){
            $(this).hide();
        })
    }
    
    $("div.langmenu").on('mouseover', showUl);
    $("div.langmenu").on('mouseleave', hideUl);
    
    
})(window, $)

