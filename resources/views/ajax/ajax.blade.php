<!doctype html>
<html lang="en">
<head>
    <meta chars>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/js/jquery-1.12.4.min.js"></script>
    <title>Document</title>
</head>
<body>
<a href="Javascript:;">123</a>
</body>
</html>
<script>
    $('a').click(function () {
        $.ajax({
            type:'get',
            url:"http://1809.lumen_api.com/ajax",
            dataType:'jsonp',
            jsonp:'callback',
             function(res){
                console.log(res);
            }
        });
    });


</script>