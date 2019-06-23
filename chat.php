<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>简易聊天室</title>
    <style type="text/css">
        @media screen and (min-width: 320px) and (max-width: 1156px){
            .talk_con_mob{
                width:600px;
                height:500px;
                border:1px solid #666;
                margin:50px auto 0;
                background:#f9f9f9;
            }
            .talk_show_mob{
                width:580px;
                height:420px;
                border:1px solid #666;
                background:#fff;
                margin:10px auto 0;
                overflow:auto;
            }
            .talk_input_mob{
                width:580px;
                margin:10px auto 0;
            }
            .talk_word_mob{
                width:420px;
                height:26px;
                padding:0px;
                float:left;
                margin-left:10px;
                outline:none;
                text-indent:10px;
            }
        }
        .talk_con{
            width:600px;
            height:500px;
            border:1px solid #666;
            margin:50px auto 0;
            background:#f9f9f9;
        }
        .talk_show{
            width:580px;
            height:420px;
            border:1px solid #666;
            background:#fff;
            margin:10px auto 0;
            overflow:auto;
        }
        .talk_input{
            width:580px;
            margin:10px auto 0;
        }
        .whotalk{
            width:80px;
            height:30px;
            float:left;
            outline:none;
        }
        .talk_word{
            width:420px;
            height:26px;
            padding:0px;
            float:left;
            margin-left:10px;
            outline:none;
            text-indent:10px;
        }
        .talk_sub{
            width:56px;
            height:30px;
            float:right;
            margin-right:10px;
        }
        .atalk{
            margin:10px;
        }
        .atalk span{
            display:inline-block;
            background:#0181cc;
            border-radius:10px;
            color:#fff;
            padding:5px 10px;
        }
        .btalk{
            margin:10px;
            text-align:right;
        }
        .btalk span{
            display:inline-block;
            background:#ef8201;
            border-radius:10px;
            color:#fff;
            padding:5px 10px;
        }

        *{
            margin:0;
            padding:0;
        }
        .box{
            position: relative;
            top:100px;
            left:100px;
            width: 140px;
            height: 100px;
            background: #088cb7;
            -moz-border-radius: 12px;
            -webkit-border-radius: 12px;
            border-radius: 12px;
        }
        .box:before{
            position: absolute;
            content: "";
            width: 0;
            height: 0;
            right: 100%;
            top: 38px;
            border-top: 13px solid transparent;
            border-right: 26px solid #088cb7;
            border-bottom: 13px solid transparent;
        }
    </style>
</head>
<body>
<div class="talk_con" id="talk_con_id">
    <div class="talk_show" id="words">
        <div class="atalk"><span id="asay">欢迎进入聊天室</span></div>
    </div>
    <div class="talk_input"  id="talk_input_id">

        <select name="user_chat" class="user_chat">
            <option value="

"></option>
            <option value=""></option>
        </select>

        <input type="text" name="msg" id="chat_msg">
        <input type="button" value="发送" id="btn" >
    </div>
</div>
</body>
</html>
<script src="/jquery.js"></script>
<script type="text/javascript" src="/jquery.cookie.js"></script><script>
    //初始化
    var ws_server='ws://vm.chat_swoole.com:9503';
    var ws=new WebSocket(ws_server);
    //建立web连接
    ws.onopen=function(){
        //绑定事件
        $(document).on('click','#btn',function(){
            // $.cookie('user_name', null);return;
            var user_name=$.cookie('user_name');
            var user_id=$.cookie('user_id');
            var user_chat=$('.user_chat').val();
            //防止非法进入
            if(user_name==null){
                alert('请先设置用户名');
                window.location.href="user.php";
                return false;
            }
            var chat_msg=$("#chat_msg").val();
            var data={};
            data.chat_msg=chat_msg;
            var data={
                type:"message",
                text:data,
                user_id:user_id,
                user_chat:user_chat,
                date:Date.now()
            };
            ws.send(JSON.stringify(data));
        })
    }
    //接收服务器发送的数据
    ws.onmessage=function(d){
        var str=d.data;
        var arr=JSON.parse(str);
        if(arr.type=='message') {
            $(".talk_show").append(arr.text.chat_msg).append("<br/>");
            var data = $("#chat_msg").val('');
        }else{
            var _select="";
            $.each(arr,function(i,arr){
                var data=JSON.parse(arr);
                _select+="<option>"+data.user_name+"</option>";
            });
            $(".user_chat").html(_select);
            $(".talk_show").append(arr.chat_msg).append("<br/>");
            var data = $("#chat_msg").val('');

        }
    }
    console.log(ws);
</script>