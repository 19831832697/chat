<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>输入用户名</title>
</head>
<body>
<form action="" method="post">
    用户名:<input type="text" name="user_name" id="user_name"><br/>
    <input type="button" id="btn" value="进入聊天室">
</form>
</body>
</html>
<script src="/jquery.js"></script>
<script>
    //初始化
    var ws_server='ws://vm.chat_swoole.com:9502';
    var ws=new WebSocket(ws_server);
    //建立web连接
    ws.onopen=function(){
        //绑定事件
        $(document).on('click','#btn',function(){
            var user_name=$("#user_name").val();
            var data={};
            data.user_name=user_name;

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
        if(arr.code==1){
            alert(arr.msg);
        }else if(arr.code==2){
            window.location.href="/chat.php";
        }
    }
    console.log(ws);
</script>