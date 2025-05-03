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
    </style>
</head>
<body>
<button id="fullscreen-button">Полный экран</button>
<div id="rotate-message">
    <p>Пожалуйста, поверните устройство в альбомный режим</p>
</div>

<a-scene vr-mode-ui="enabled: true">
    <a-sky src="{{ asset('360/img-3.jpg') }}" rotation="0 -90 0"></a-sky>
    <!-- Камеры для стерео-эффекта -->
    <a-entity camera="active: true" position="0 1.6 0" wasd-controls-enabled="false">
        <!-- Левая камера -->
        <a-entity camera="active: false" stereo="eye: left" rotation="0 0 0"></a-entity>
        <!-- Правая камера -->
        <a-entity camera="active: false" stereo="eye: right" rotation="0 0 0"></a-entity>
    </a-entity>

    <!-- Контроллеры для VR -->
    <a-entity laser-controls="hand: right"></a-entity>
    <a-entity laser-controls="hand: left"></a-entity>
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
    // Автоматический вход в VR-режим при наличии гарнитуры
    document.querySelector('a-scene').addEventListener('loaded', function() {
        if (navigator.getVRDisplays) {
            navigator.getVRDisplays().then(function(displays) {
                if (displays.length > 0) {
                    const scene = document.querySelector('a-scene');
                    scene.enterVR();
                }
            });
        }
    });
</script>
</body>
</html>
