<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Мета-теги для iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="360 Панорама">
    <link rel="apple-touch-icon" href="{{ asset('icon.png') }}">

    <!-- Web App Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <title>360 Панорама</title>

    @vite(['resources/js/app.js'])

    <style>
        /* Жесткий сброс стилей */
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background: #000;
        }

        a-scene {
            display: block;
            width: 100%;
            height: 100%;
        }

        #fullscreen-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            padding: 10px 15px;
            background: rgba(0,0,0,0.7);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #rotate-message {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            color: white;
            z-index: 10000;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
    </style>
</head>
<body>
{{--<button id="fullscreen-button">Полный экран</button>--}}
<div id="rotate-message">
    <p>Пожалуйста, поверните устройство в альбомный режим</p>
</div>

{{--<a-scene>--}}
{{--    <a-sky src="{{ asset('360/img-4.jpg') }}" rotation="0 -90 0"></a-sky>--}}
{{--    <a-camera fov="80" look-controls="pointerLockEnabled: true"></a-camera>--}}
{{--</a-scene>--}}

<a-scene antialias="true">
    <!-- Paths to left and right images -->
    <a-assets>
        <img id="left" src="{{ asset('360/img-4.jpg') }}">
        <img id="right" src="{{ asset('360/img-4.jpg') }}">
    </a-assets>

    <!-- Camera -->
    <a-entity camera look-controls position="0 0 0" stereocam="eye:left;"></a-entity>

    <!-- Sky sphere -->
    <a-sky id="sky1" src="#left" stereo="eye:left"></a-sky>
    <a-sky id="sky2" src="#right" stereo="eye:right"></a-sky>

{{--    <-- or alternatively -->--}}

    <!--<a-sky id="sky1" src="http://i.imgur.com/YAaxpv6.jpg" stereo="eye:left"></a-sky>-->
    <!--<a-sky id="sky2" src="http://i.imgur.com/JUxTnzK.jpg" stereo="eye:right"></a-sky>-->


</a-scene>




<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fullscreenButton = document.getElementById('fullscreen-button');
        const rotateMessage = document.getElementById('rotate-message');
        const scene = document.querySelector('a-scene');

        // Проверка поддержки Fullscreen API
        fullscreenButton.style.display = document.fullscreenEnabled ? 'block' : 'none';

        // Обработчик кнопки
        fullscreenButton.addEventListener('click', () => {
            if (scene.requestFullscreen) scene.requestFullscreen();
            else if (scene.webkitRequestFullscreen) scene.webkitRequestFullscreen();
        });

        // Проверка ориентации
        function checkOrientation() {
            rotateMessage.style.display = (window.innerHeight > window.innerWidth) ? 'flex' : 'none';
        }

        window.addEventListener('resize', checkOrientation);
        checkOrientation();

    });
</script>
</body>
</html>
