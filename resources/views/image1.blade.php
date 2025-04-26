<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>image 360</title>
    @vite(['resources/js/app.js'])
    @vite('resources/css/app.css')
</head>
<body>

<a-scene>
    <a-sky src="{{ asset('360/img-1.jpg') }}" rotation="0 -90 0"></a-sky>

    <a-entity position="0 3 0" id="cones-container"></a-entity>

    <a-camera position="0 3 5">
{{--        <a-cursor></a-cursor>--}}
    </a-camera>

    <script>
        // Параметры для каждого конуса (цвет, скорость, амплитуда движения)
        const conesConfig = [
            { color: "#00ffff", speed: 0.002,  radius: 5, maxOffset: 3 },
            { color: "#ff00ff", speed: 0.001,  radius: 5, maxOffset: 4 },
            { color: "#ffff00", speed: 0.0008, radius: 5, maxOffset: 2.5 },
            { color: "#00ff00", speed: 0.0009, radius: 5, maxOffset: 3.5 }
        ];

        // Создаём конусы
        const container = document.querySelector("#cones-container");
        conesConfig.forEach((config, index) => {
            const cone = document.createElement("a-cone");

            cone.setAttribute("id", `sliding-cone-${index}`);
            cone.setAttribute("height", "20");
            cone.setAttribute("radius-top", "0");
            cone.setAttribute("radius-bottom", config.radius);
            cone.setAttribute("color", config.color);
            cone.setAttribute("position", "0 3 0"); // Центр конуса (вершина будет выше)
            cone.setAttribute("material", "opacity: 0.03; transparent: true");

            container.appendChild(cone);

            // Запускаем анимацию для каждого конуса
            animateCone(cone, config.speed, config.maxOffset);
        });

        // Функция для анимации конуса
        function animateCone(cone, speed, maxOffset) {
            let time = Math.random() * 100; // Разные начальные фазы

            function update() {
                time += speed;

                // Движение основания по XZ
                const slideX = Math.sin(time * 1.3) * maxOffset;
                const slideZ = Math.cos(time * 0.7) * maxOffset;

                // Наклон в сторону движения
                const tiltX = -slideZ * 10;
                const tiltZ = slideX * 10;

                cone.setAttribute("position", { x: slideX, y: 1.5, z: slideZ });
                cone.setAttribute("rotation", `${tiltX} 0 ${tiltZ}`);

                requestAnimationFrame(update);
            }

            update();
        }
    </script>


</a-scene>


</body>
</html>
