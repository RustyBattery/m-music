<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="mobile-web-app-capable" content="yes">
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

        .vr-button {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            padding: 10px 20px;
            background: rgba(0,0,0,0.7);
            color: white;
            border: none;
            border-radius: 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
<button id="fullscreen-button">Полный экран</button>
<div id="rotate-message">
    <p>Пожалуйста, поверните устройство в альбомный режим</p>
</div>

<a-scene vr-mode-ui="enabled: false" embedded>
    <!-- Панорама 360 -->
    <a-sky src="{{ asset('360/img-3.jpg') }}" rotation="0 -90 0"></a-sky>

    <!-- Камера с VR-режимом -->
    <a-entity position="0 1.6 0">
        <a-camera
            wasd-controls-enabled="false"
            look-controls="pointerLockEnabled: true"
            stereo="eye: left; ipd: 0.065"
            vr-mode-ui="enabled: false">
        </a-camera>
    </a-entity>
</a-scene>

<button class="vr-button" id="vrButton">VR MODE</button>

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

    // Переключение VR-режима
    const vrButton = document.getElementById('vrButton');
    const scene = document.querySelector('a-scene');

    vrButton.addEventListener('click', function() {
        if (scene.is('vr-mode')) {
            scene.exitVR();
            vrButton.textContent = 'VR MODE';
        } else {
            scene.enterVR();
            vrButton.textContent = 'EXIT VR';
        }
    });

    // Автоматическая подстройка под мобильные устройства
    if (/Mobi|Android/i.test(navigator.userAgent)) {
        document.querySelector('a-camera').setAttribute('stereo', 'ipd', '0.065');
    }
</script>
</body>
</html>
