<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>image 360</title>
    @vite(['resources/js/app.js'])
</head>
<body>
<a-scene>
    <!-- Используем <a-sky> с атрибутом src -->
    <a-sky src="{{ asset('360/img-3.jpg') }}" rotation="0 -90 0"></a-sky>

    <!-- Добавляем курсор для взаимодействия -->
    <a-camera>
{{--        <a-cursor></a-cursor>--}}
    </a-camera>
</a-scene>
</body>
</html>
