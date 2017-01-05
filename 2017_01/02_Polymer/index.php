<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <style>
    button {
        font-size: 1.2em;
        cursor: pointer;
    }
    </style>

    <script src="/node_modules/webcomponents.js/webcomponents-lite.min.js"></script>
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <link rel="import" href="/node_modules/@polymer/polymer/polymer.html" />

    <link rel="import" href="/component/x-test.html" />
    <link rel="import" href="/component/x-pug.html" />
    <link rel="import" href="/component/x-progress.html" />
    <link rel="import" href="/component/x-userinfo.html" />
</head>
<body>

<x-test></x-test>

<x-progress id="progress" value="10"></x-progress>
<div>
    <button data-progress="-5">감소</button>
    <button data-progress="5">증가</button>
    <button data-progress="-12">크게 감소</button>
    <button data-progress="12">크게 증가</button>
</div>

<script>
var progress = document.getElementById('progress');

$('button[data-progress]').click(function () {
    progress.value += parseInt(this.dataset.progress);
});
</script>

<?php
$user_json = json_encode([
    'name' => '모던이',
    'age' => '42',
    'gender' => '남',
]);
?>
<x-userinfo user="<?=htmlspecialchars($user_json)?>">클래식을 좋아하는 사람입니다.</x-userinfo>
<x-userinfo></x-userinfo>

</body>
</html>
