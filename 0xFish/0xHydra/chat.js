if(currentUser){

    wsConfig={
        'timeout': 5000,
        'reconnection': true,
        'reconnectionDelay': 1000,
        'reconnectionDelayMax' : 5000,
        'reconnectionAttempts': 999
    };
    if(wsDisabled){
        wsConfig.transports=['polling'];
    }

    var webSocket = new io.connect((window.location.protocol=='http:'?'wss:':'ws:')+'//'+wsUri,wsConfig);

    webSocket.on('connect', function (user) {
        webSocket.emit('join', currentUser);
    });

    webSocket.on('user.unreaded-messages', function (data) {
        try{
            updateUnreaded(JSON.parse(data));
        }catch (e){}
    });

    //оповещение
    webSocket.on('system.notify', function (notification) {
        notification = JSON.parse(notification);
        if(currentUser && currentUser.notify!='disabled') {
            $.notify({
                title: notification.title,
                message: notification.message,
                icon: notification.image,
                url: notification.link
            });

            if(notification.important){
                beep();
                Notification.requestPermission( function(status) {
                    var n = new Notification(notification.title,
                        {
                            tag : 'hyd-exchange',
                            body: notification.message,
                            icon: notification.image
                        });
                });
            }
        }


        checkUnreaded();
    });

    //сообщение в паблик чат
    webSocket.on('chat.message', function (message) {
        message = JSON.parse(message);
        if(typeof(message.data)=='string'){
            $('ul.chat').prepend(message.data);
            $('ul.chat img').on('load', scrollPublicChat);
            scrollPublicChat();
        }else{
            myMsg=$('.chatarea .inner .chmessage[data-rand="'+message.rand+'"]');
            if(myMsg.length){
                myMsg.attr('data-id',message.id);
                myMsg.find('.loader').remove();
                myMsg.removeAttr('data-rand');
            }
            else {
                d = new Date();
                $('ul.chat').prepend('<li class="left clearfix" data-id="{{{$message->id}}}"  data-rand="'+message.rand+'"><span class="chat-img pull-left"><a href="'+message.profile+'"><img src="'+message.avatar+'" class="img-circle"/></a></span>'+
                    '<div class="chat-body"><div class=""><a href="'+message.profile+'">'+message.name+'</a>'+
                    '<small class="pull-right text-muted">'+ (d.getHours() < 10 ? '0' : '')+parseInt(d.getHours())+':'+ (d.getMinutes() < 10 ? '0' : '')+d.getMinutes()+'</small></div><span>'+message.message+'</span></div></li>');
                $('ul.chat img').on('load', scrollPublicChat);
                scrollPublicChat();

                var isChatOpen = getCookie('isChatOpen') || 0;
                if(isChatOpen == 0){
                    $('#unread-cnt').text(parseInt($('#unread-cnt').text()) + 1)
                }
            }
        }

    });

    //приватное сообщение
    webSocket.on('chat.private', function (message) {
        message = JSON.parse(message);
        if (message.user_id != currentUser.id) {
            //всплывающее уведомление
            if(currentUser && currentUser.notify!='disabled') {
                $.notify({
                    title: message.author_name,
                    message: message.text,
                    icon: message.avatar,
                    url: message.chat_url
                });
                beep();
            }
        }
        checkUnreaded();
    });
}

function sendPublicChatMessage(form){
    message=$('input[name=body]',form).val() || $('#text',form).val();
    Message={message:message,rand:Math.random().toString(),sender:$('input[name=sender]',form).val()};
    if(message.trim()!=''){
        scrollPublicChat();
        webSocket.emit('chat.send.message', Message);
    }
    $('input[name=body]',form).val('');
    return false;
}