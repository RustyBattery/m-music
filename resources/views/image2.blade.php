<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Мета-теги для iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="360 Панорама">
    <link rel="apple-touch-icon" href="{{ asset('icon.png') }}">

    <!-- Web App Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <title>image 360</title>

    @vite(['resources/js/app.js'])

    <style>
        #fullscreen-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            padding: 10px 15px;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #fullscreen-button:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        /* Скрываем кнопку в полноэкранном режиме */
        :fullscreen #fullscreen-button,
        :-webkit-full-screen #fullscreen-button,
        :-moz-full-screen #fullscreen-button {
            display: none;
        }

        /* Принудительный поворот для мобильных в портрете */
        @media screen and (max-width: 768px) and (orientation: portrait) {
            a-scene {
                transform: rotate(90deg);
                transform-origin: left top;
                width: 100vh;
                height: 100vw;
                position: absolute;
                top: 100%;
                left: 0;
            }
        }

        .a-enter-vr {
            right: 20px;
            bottom: 20px;
        }

        a-scene {
            overflow: hidden;
        }

        .a-sky {
            position: absolute;
            width: 150%;
            height: 150%;
            left: -25%;
            top: -25%;
        }
    </style>
</head>
<body class="bg-red-300">
<button id="fullscreen-button">Полный экран</button>
<div id="rotate-message">
    <p>Пожалуйста, поверните устройство в альбомный режим</p>
</div>

<a-scene>
    <a-sky src="{{ asset('360/img-2.jpg') }}" rotation="0 -90 0" radius="10000"></a-sky>
    <a-camera
        fov="80"
        wasd-controls-enabled="false"
        look-controls="pointerLockEnabled: true"
    ></a-camera>
</a-scene>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fullscreenButton = document.getElementById('fullscreen-button');
        const rotateMessage = document.getElementById('rotate-message');
        const scene = document.querySelector('a-scene');

        // Проверка поддержки Fullscreen API
        if (!document.fullscreenEnabled) {
            fullscreenButton.style.display = 'none';
        }

        // Обработчик кнопки полноэкранного режима
        fullscreenButton.addEventListener('click', async () => {
            try {
                // 1. Вход в полноэкранный режим
                if (scene.requestFullscreen) await scene.requestFullscreen();
                else if (scene.webkitRequestFullscreen) await scene.webkitRequestFullscreen();

                // 2. Попытка блокировки ориентации
                if (screen.orientation?.lock) {
                    await screen.orientation.lock('landscape').catch(e => {
                        console.warn("Ориентация не заблокирована:", e);
                        showRotateMessage();
                    });
                } else {
                    showRotateMessage();
                }
            } catch (e) {
                console.error("Ошибка полноэкранного режима:", e);
            }
        });

        // Проверка ориентации при загрузке и изменении размера
        function checkOrientation() {
            if (window.innerHeight > window.innerWidth) {
                rotateMessage.style.display = 'flex';
            } else {
                rotateMessage.style.display = 'none';
            }
        }

        window.addEventListener('resize', checkOrientation);
        checkOrientation();

        document.querySelector('a-scene').addEventListener('loaded', function () {
            const sky = document.querySelector('a-sky');
            // Увеличиваем масштаб текстуры
            sky.setAttribute('material', 'repeat', '1 1');
            // // Убедимся, что нет белых границ
            // sky.setAttribute('material', 'color', '#000');
        });

        // Автозапуск полноэкранного режима (по желанию)
        // setTimeout(() => fullscreenButton.click(), 1000);
    });

    function resizePano() {
        const pano = document.getElementById('pano');
        const aspect = window.innerWidth / window.innerHeight;

        // Вертикальные экраны (9:16)
        if (aspect < 1) {
            pano.setAttribute('scale', '1.5 1.5 1.5');
        }
        // Горизонтальные экраны (16:9)
        else {
            pano.setAttribute('scale', '1 1 1');
        }
    }

    window.addEventListener('resize', resizePano);
    document.querySelector('a-scene').addEventListener('loaded', resizePano);
</script>
</body>
</html>
