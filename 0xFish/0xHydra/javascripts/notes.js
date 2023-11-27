function random_string(length) {
	if(length === null) {
	  length = 16;
  }
  var chars = "abcdefghijklmnopqrstuvwxyz";

  var str = "";
  for(var i = 0; i < length; i++) {
     pos = Math.floor(Math.random() * chars.length);
     str += chars.charAt(pos);
  }
  return str;
}

function cipher(key, text) {
  return GibberishAES.enc(text, key)
}

function uncipher(key, text) {
  return GibberishAES.dec(text, key)
}

function CopyLinkToClipboard(element) {
    element.focus();
    element.select();
}

$('#add_password').on('change',function(){
    if($(this).is(':checked'))
    {
        $('#password_row').slideDown();
        $('#password_row input').attr('required',1);
    }
    else
    {
        $('#password_row').slideUp();
        $('#password_row input').removeAttr('required');
    }
});

$('#createNoteForm').on('submit',function(e){
    //e.preventDefault();
    body=$('#createNoteForm textarea').val();
    var key = random_string(null);
    body = cipher(key, body);

    $.ajax({
        url: $('#createNoteForm').attr('action'),
        method: 'POST',
        data: {encBody: body,password:($('#add_password:checked')?$('input[name=password]').val():'')},
        success: function (data) {
            if (data.errors) {
                $("#body_errors").html(data.errors.body);
                //$("#email_errors").html(data.errors.sender_email);
            }
            else
            {
                $("#noteform").slideUp("slow", function () {
                    var link = $("#notelink").val() + '/'+ data.key;
                    $("#notelink").val(link);
                    $("#destroylink").attr('href', link);
                    $("#notelink").val($("#notelink").val() + '#' + key)

                    $("#response").slideDown("normal", function () {
                        $("#notelink").focus();
                    });

                    /* reset the body value */
                    $('#createNoteForm textarea').val("");
                });
            }
        }
    });
});

if (location.hash && $("#noteinput").val()) {
    var key = location.hash;
    key = key.substring(1, key.length);
    $('#note').show();
    var text=uncipher(key, $("#noteinput").val());
    $.ajax({
        url: location.pathname+'/check',
        method: 'POST',
        data: {text: text},
        success: function (data) {
            if (data) {
                $("#note").html('<span class="text-danget">[фишинговая ссылка удалена]</span>');
            }
            else
            {
                $("#note").text(text);
                $('#needCopy').show();
            }
        }
    });
}

$(document).ready(function(){
    $('#noteform').show();
});
