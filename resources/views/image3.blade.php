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
            background: rgba(0,0,0,1);
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

        .vr-container {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
        }
        .eye-view {
            width: 50%;
            height: 100%;
            overflow: hidden;
            position: relative;
        }
        #leftScene, #rightScene {
            width: 200%;
            height: 100%;
            position: absolute;
        }
        .vr-button {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            padding: 12px 24px;
            background: rgba(0,0,0,0.8);
            color: white;
            border: 2px solid white;
            border-radius: 30px;
            font-size: 18px;
        }
    </style>
</head>
<body>
<button id="fullscreen-button">Полный экран</button>
<div id="rotate-message">
    <p>Пожалуйста, поверните устройство в альбомный режим</p>
</div>

{{--<a-scene vr-mode-ui="enabled: false" embedded>--}}
{{--    <!-- Панорама 360 -->--}}
{{--    <a-sky src="{{ asset('360/img-3.jpg') }}" rotation="0 -90 0"></a-sky>--}}

{{--    <!-- Камера с VR-режимом -->--}}
{{--    <a-entity position="0 1.6 0">--}}
{{--        <a-camera--}}
{{--            wasd-controls-enabled="false"--}}
{{--            look-controls="pointerLockEnabled: true"--}}
{{--            stereo="eye: left; ipd: 0.065"--}}
{{--            vr-mode-ui="enabled: false">--}}
{{--        </a-camera>--}}
{{--    </a-entity>--}}
{{--</a-scene>--}}

<div class="vr-container">
    <div class="eye-view">
        <a-scene id="leftScene" embedded>
            <a-sky src="{{ asset('360/img-3.jpg') }}" rotation="0 -90 0"></a-sky>
            <a-camera position="0 1.6 0" rotation="0 0 0" wasd-controls-enabled="false"></a-camera>
        </a-scene>
    </div>
    <div class="eye-view">
        <a-scene id="rightScene" embedded>
            <a-sky src="{{ asset('360/img-3.jpg') }}" rotation="0 -90 0"></a-sky>
            <a-camera position="0 1.6 0" rotation="0 0 0" wasd-controls-enabled="false"></a-camera>
        </a-scene>
    </div>
</div>

{{--<button class="vr-button" id="vrButton">VR MODE</button>--}}

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
<script>
    const vrButton = document.getElementById('vrButton');
    const leftScene = document.getElementById('leftScene');
    const rightScene = document.getElementById('rightScene');
    let isVrMode = false;
    let ipd = 0.065; // Межзрачковое расстояние (в метрах)

    // Функция для обновления камер
    function updateCameras() {
        if (isVrMode) {
            // Смещаем камеры для стерео-эффекта
            const leftCam = leftScene.querySelector('a-camera');
            const rightCam = rightScene.querySelector('a-camera');

            leftCam.setAttribute('position', `${-ipd/2} 1.6 0`);
            rightCam.setAttribute('position', `${ipd/2} 1.6 0`);

            // Синхронизируем поворот камер
            function syncRotation() {
                const rotation = leftCam.getAttribute('rotation');
                rightCam.setAttribute('rotation', rotation);
                if (isVrMode) requestAnimationFrame(syncRotation);
            }
            syncRotation();
        }
    }

    // Переключение VR-режима
    vrButton.addEventListener('click', () => {
        isVrMode = !isVrMode;
        vrButton.textContent = isVrMode ? 'ОБЫЧНЫЙ РЕЖИМ' : 'VR РЕЖИМ';

        if (isVrMode) {
            document.querySelector('body').requestFullscreen();
            updateCameras();

            // Блокировка ориентации (если поддерживается)
            if (screen.orientation && screen.orientation.lock) {
                screen.orientation.lock('landscape').catch(e => {
                    console.warn("Не удалось заблокировать ориентацию:", e);
                });
            }
        } else {
            // Возвращаем камеры в исходное положение
            const cameras = document.querySelectorAll('a-camera');
            cameras.forEach(cam => cam.setAttribute('position', '0 1.6 0'));

            if (document.fullscreenElement) {
                document.exitFullscreen();
            }
        }
    });

    // Обработчик изменения ориентации
    window.addEventListener('orientationchange', () => {
        if (isVrMode) {
            alert("Для лучшего опыта зафиксируйте устройство в ландшафтном режиме");
        }
    });
</script>
</body>
</html>
