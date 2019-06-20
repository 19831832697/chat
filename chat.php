<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>简易聊天室</title>
</head>
<body>
<h3>欢迎来到聊天室</h3>
<h3><a href="p_chat.php">选择好友私聊</a></h3>
<input type="text" name="msg" id="chat_msg">
<input type="button" id="btn" value="发送"><hr/>
<div class="talk_show">

</div>
</body>
</html>
<script src="/jquery.js"></script>
<script>
    //初始化
    var ws_server='ws://vm.chat_swoole.com:9503';
    var ws=new WebSocket(ws_server);
    //建立web连接
    ws.onopen=function(){
        //绑定事件
        $(document).on('click','#btn',function(){
            var chat_msg=$("#chat_msg").val();
            var data={};
            data.chat_msg=chat_msg;

            var data={
                type:"message",
                text:data,
            };
            ws.send(JSON.stringify(data));
        })
    }
    //接收服务器发送的数据
    ws.onmessage=function(d){
        var str=d.data;
        var arr=JSON.parse(str);
        $(".talk_show").append(arr.text.chat_msg).append("<br/>");
        var data=$("#chat_msg").val('');
    }
    console.log(ws);
</script>