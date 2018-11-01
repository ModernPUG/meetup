<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <title>HTML5 WebSocket Example</title>
</head>
<body>

<textarea id="txtChat" cols="20" rows="10"></textarea>

<div>
    <button id="btnConnect">연결</button>
    <button id="btnDisconnect">끊기</button>
</div>

<div>
    <input type="text" id="txtMsg" size="20">
    <button id="btnSend">전송</button>
</div>

<script>
var ws = null;
var txtChat = document.getElementById('txtChat');
var txtMsg = document.getElementById('txtMsg');

document.getElementById('btnConnect').onclick = function () {
    ws = new WebSocket("ws://dev:5882/ws/server.php");
    ws.onopen = function(e) {
        txtChat.value = "[Open]\n" + txtChat.value;
    };

    ws.onclose = function(e) {
        txtChat.value = "[Close]\n" + txtChat.value;
    };

    ws.onmessage = function(e) {
        txtChat.value = e.data + "\n" + txtChat.value;
    };
};

document.getElementById('btnSend').onclick = function () {
    ws.send(txtMsg.value);
}

document.getElementById('btnDisconnect').onclick = function () {
    ws.close();
}
</script>

</body>
</html>