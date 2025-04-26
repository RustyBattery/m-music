<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>video 360</title>
    @vite(['resources/js/app.js'])
    <style>
        body {
            margin: 0;
            overflow: hidden;
            font-family: Arial, sans-serif;
        }
        #info {
            position: absolute;
            top: 20px;
            left: 20px;
            color: white;
            background: rgba(0,0,0,0.5);
            padding: 10px;
            border-radius: 5px;
            z-index: 1000;
        }
    </style>
</head>
<body>
<a-scene>
    <a-assets>
        <!-- Замените этот URL на ваше 360° видео -->
        <video id="video360" autoplay loop muted crossorigin="anonymous"
               src="{{ asset('360/video.mp4') }}"></video>
    </a-assets>

    <!-- Основная сцена с видео -->
    <a-videosphere src="#video360" rotation="0 180 0"></a-videosphere>

    <!-- Камера с курсором -->
    <a-camera>
        <a-cursor></a-cursor>
    </a-camera>
</a-scene>

<script>
    // Автозапуск видео (необходимо для некоторых браузеров)
    document.querySelector('a-scene').addEventListener('loaded', function() {
        const video = document.querySelector('#video360');

        // Попытка автовоспроизведения с обработкой ошибок
        const playPromise = video.play();

        if (playPromise !== undefined) {
            playPromise.catch(error => {
                console.log("Автовоспроизведение запрещено, покажите кнопку воспроизведения");
                // Здесь можно добавить кнопку для ручного запуска
            });
        }
    });

    // Обработчик для полноэкранного режима при клике (опционально)
    document.addEventListener('click', function() {
        const scene = document.querySelector('a-scene');
        if (scene.requestFullscreen) {
            scene.requestFullscreen();
        } else if (scene.webkitRequestFullscreen) {
            scene.webkitRequestFullscreen();
        }
    }, { once: true });
</script>
</body>
</html>
