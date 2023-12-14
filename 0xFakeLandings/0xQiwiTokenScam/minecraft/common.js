(function(){

	$("#group").click(function(){
		var group = $(this).val();
		if (group.includes("case")) return
		$.post( "http://realdonate.ru/js/js.php", { nickname: $('input[name="nickname"]').val(), group: group } )
			.done(function( data ){
				/*if (data != "") {
					data = $.parseJSON(data);
					var arrays = $("#group").children();
					for (var i = 0; i < arrays.length; i++) {
						var yourString = data[i].replace( /[^\d.]/g, '' );
						//if (data[i].indexOf("-" + yourString) !=-1  || parseInt(yourString) < 1) {
							
							if (parseInt(yourString) > 1) {
								if (!(yourString.includes('-' + yourString))) {
									arrays[i].text = data[i];
								}
							}
						//console.log(parseInt(data[i]));
					}
				}*/
				if (data != "") {
					if (data.includes('У вас')) {
						$('#buyOk').attr("disabled", true);
						$('#buyOk').val(data);
					} else {
						$('#buyOk').attr("disabled", false);
						$('#buyOk').val(data);
					}
				} else {
					
						$('#buyOk').attr("disabled", false);
						$('#buyOk').val("Купить");
				}
				
			})
	});

}())