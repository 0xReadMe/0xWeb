<html>
<head>
    <title>Вы не робот?</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        .page{
            padding: 20px;width: 300px; margin: 0 auto;
        }
        input[type=text]{
            width: 100px;
            height: 24px;
            margin-bottom: 5px;
        }
        img{
            float:left;
            margin-right: 10px;
        }
        input[type=submit]{
            color: #fff;
            background-color: #2b71b1;
            border-color: #0073cb;
            width: 100px;
            display: inline-block;
            margin-bottom: 0;
            font-weight: normal;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            background-image: none;
            border: 1px solid transparent;
            white-space: nowrap;
            padding: 4px 12px;
            font-size: 12px;
            line-height: 1.42857143;
            border-radius: 2px;
        }
    </style>
</head>
<body>
<div class="page">
    <form action="/gate/" method="post">
        <img src="data:image/jpeg;base64,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" alt="Captcha image">
        <input type="text" name="captcha" autofocus>
        <input type="hidden" name="captchaData" value="1560751574.8672d456bd05fba6d9f31536a027da38.01a4b091219a0fa8407af1926e5ee904">
	<input type="hidden" name="ret" value="/system.php">
        <input type="submit" value="Войти">
    </form>
</div>
</body>
</html>

