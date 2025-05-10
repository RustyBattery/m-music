import './bootstrap';
import 'aframe';
import 'aframe-stereo-component';

document.addEventListener('DOMContentLoaded', () => {
    if (window.AFRAME) {
        console.log('✅ A-Frame загружен! Версия:', AFRAME.version);

        // Динамическое добавление элемента (доп. проверка)
        const scene = document.querySelector('a-scene');
        if (scene) {
            // const sphere = document.createElement('a-sphere');
            // sphere.setAttribute('position', '1 1.5 -3');
            // sphere.setAttribute('color', 'green');
            // scene.appendChild(sphere);
            // console.log('Динамически добавлен зелёный шар!');
        }
    } else {
        console.error('❌ A-Frame не загружен!');
    }
});

