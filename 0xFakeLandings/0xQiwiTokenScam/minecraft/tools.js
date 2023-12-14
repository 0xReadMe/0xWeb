function getOnline(){
	$.post('http://realdonate.ru/controller.php', {online: 'online'}, function(data){
		$('#online').html(' '+ data +' ');
	});
}

setInterval('getOnline()', 3000);


function Buy(){
	var name = $("[name = 'name']").val();
	var group = $("[name = 'group']").val();
	$.post('http://realdonate.ru/js/pay.php', {name: name, group: group}, function(data){
		if(data == 'error'){$('#error').show('slow').html('Ошибка. Свяжитесь с администратором вк - vk.com/deinvater')}
		else{location.href = data}
	});
}

$('a[href^="#"]').click(function(){
        var el = $(this).attr('href');
        $('body').animate({scrollTop: $(el).offset().top - 300}, 1500);
        return false; 
});
