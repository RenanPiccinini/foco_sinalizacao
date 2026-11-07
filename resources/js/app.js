import Alpine from 'alpinejs';
import * as THREE from 'three';
import confetti from 'canvas-confetti';

window.Alpine = Alpine;
window.confetti = confetti;

Alpine.start();

// Dispara confetes se houver novo protocolo registrado na tela
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('ticket-success-alert')) {
        try {
            confetti({
                particleCount: 90,
                spread: 70,
                origin: { y: 0.6 },
                colors: ['#f59e0b', '#10b981', '#38bdf8', '#ffffff']
            });
        } catch (e) {
            console.warn(e);
        }
    }

    // Inicializa Cena 3D Three.js se o container existir
    const canvasContainer = document.getElementById('hero-3d-canvas');
    if (canvasContainer) {
        initHero3D(canvasContainer);
    }

    // Inicializa Efeito 3D Tilt nos cards
    init3DTilt();

    // Inicializa Parallax no Scroll
    initParallaxScroll();
});

/**
 * Cena 3D Interativa em Three.js:
 * Representa o ecossistema de Mobilidade Urbana Inteligente,
 * com ondas verdes luminosas, malha viária dinâmica e nós semafóricos conectados.
 */
function initHero3D(container) {
    const width = container.clientWidth || window.innerWidth;
    const height = container.clientHeight || 600;

    const scene = new THREE.Scene();
    scene.fog = new THREE.FogExp2(0x020611, 0.0018);

    const camera = new THREE.PerspectiveCamera(60, width / height, 0.1, 1000);
    camera.position.set(0, 20, 65);

    const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    container.innerHTML = '';
    container.appendChild(renderer.domElement);

    // Luzes da cena
    const ambientLight = new THREE.AmbientLight(0x0f2752, 1.2);
    scene.add(ambientLight);

    const blueLight = new THREE.PointLight(0x0284c7, 3, 120);
    blueLight.position.set(-25, 30, 20);
    scene.add(blueLight);

    const amberLight = new THREE.PointLight(0xf59e0b, 3.5, 120);
    amberLight.position.set(25, 20, 15);
    scene.add(amberLight);

    const greenLight = new THREE.PointLight(0x10b981, 4, 120);
    greenLight.position.set(0, 10, 30);
    scene.add(greenLight);

    // Malha viária em Grid 3D de perspectiva
    const gridHelper = new THREE.GridHelper(180, 45, 0x1d4ed8, 0x0a1d3d);
    gridHelper.position.y = -12;
    scene.add(gridHelper);

    // Criação de Curvas de Tráfego 3D (Rodovias e Ondas Verdes)
    const curves = [
        new THREE.CatmullRomCurve3([
            new THREE.Vector3(-60, -10, -50),
            new THREE.Vector3(-25, -2, -20),
            new THREE.Vector3(0, 5, 5),
            new THREE.Vector3(30, 0, 30),
            new THREE.Vector3(60, -8, 60),
        ]),
        new THREE.CatmullRomCurve3([
            new THREE.Vector3(50, -8, -60),
            new THREE.Vector3(20, 2, -25),
            new THREE.Vector3(-5, 8, 0),
            new THREE.Vector3(-35, -2, 25),
            new THREE.Vector3(-55, -10, 50),
        ]),
        new THREE.CatmullRomCurve3([
            new THREE.Vector3(-40, -11, -30),
            new THREE.Vector3(0, -6, 0),
            new THREE.Vector3(40, -11, 40),
        ])
    ];

    curves.forEach((curve, index) => {
        const points = curve.getPoints(100);
        const geometry = new THREE.BufferGeometry().setFromPoints(points);
        const color = index === 0 ? 0x10b981 : (index === 1 ? 0xf59e0b : 0x38bdf8);
        const material = new THREE.LineBasicMaterial({
            color: color,
            transparent: true,
            opacity: 0.65,
            linewidth: 2
        });
        const line = new THREE.Line(geometry, material);
        scene.add(line);
    });

    // Partículas de Fluxo Contínuo de Tráfego (Carros / Fótons de Dados)
    const particleCount = 180;
    const particleGeometry = new THREE.BufferGeometry();
    const positions = new Float32Array(particleCount * 3);
    const colors = new Float32Array(particleCount * 3);

    const colorPalette = [
        new THREE.Color(0x10b981), // Verde semáforo
        new THREE.Color(0xf59e0b), // Âmbar semáforo
        new THREE.Color(0x38bdf8), // Cyan inteligente
        new THREE.Color(0xffffff)  // Farol LED branco
    ];

    const particleCurves = [];
    const particleProgress = [];

    for (let i = 0; i < particleCount; i++) {
        const assignedCurve = curves[i % curves.length];
        const progress = Math.random();
        particleCurves.push(assignedCurve);
        particleProgress.push(progress);

        const point = assignedCurve.getPoint(progress);
        positions[i * 3] = point.x + (Math.random() - 0.5) * 1.5;
        positions[i * 3 + 1] = point.y + (Math.random() - 0.5) * 1.5;
        positions[i * 3 + 2] = point.z + (Math.random() - 0.5) * 1.5;

        const c = colorPalette[Math.floor(Math.random() * colorPalette.length)];
        colors[i * 3] = c.r;
        colors[i * 3 + 1] = c.g;
        colors[i * 3 + 2] = c.b;
    }

    particleGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    particleGeometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));

    const particleMaterial = new THREE.PointsMaterial({
        size: 1.4,
        vertexColors: true,
        transparent: true,
        opacity: 0.9,
        blending: THREE.AdditiveBlending,
    });

    const particleSystem = new THREE.Points(particleGeometry, particleMaterial);
    scene.add(particleSystem);

    // Objeto 3D: Torre Semafórica Futurista
    const semaphoreGroup = new THREE.Group();
    semaphoreGroup.position.set(16, 2, 8);
    semaphoreGroup.rotation.y = -Math.PI / 4;

    // Coluna metálica galvanizada
    const poleGeometry = new THREE.CylinderGeometry(0.5, 0.6, 24, 16);
    const poleMaterial = new THREE.MeshStandardMaterial({
        color: 0x64748b,
        metalness: 0.85,
        roughness: 0.2
    });
    const pole = new THREE.Mesh(poleGeometry, poleMaterial);
    pole.position.y = 0;
    semaphoreGroup.add(pole);

    // Braço horizontal projetado
    const armGeometry = new THREE.CylinderGeometry(0.35, 0.4, 12, 16);
    const arm = new THREE.Mesh(armGeometry, poleMaterial);
    arm.rotation.z = Math.PI / 2;
    arm.position.set(-5, 9, 0);
    semaphoreGroup.add(arm);

    // Corpo do grupo focal
    const boxGeometry = new THREE.BoxGeometry(2.4, 7, 2);
    const boxMaterial = new THREE.MeshStandardMaterial({
        color: 0x090d16,
        metalness: 0.4,
        roughness: 0.4
    });
    const semaphoreBox = new THREE.Mesh(boxGeometry, boxMaterial);
    semaphoreBox.position.set(-9.5, 8.5, 0);
    semaphoreGroup.add(semaphoreBox);

    // As três lentes LED (Vermelho, Amarelo, Verde)
    const lensGeometry = new THREE.SphereGeometry(0.8, 16, 16);

    const redMaterial = new THREE.MeshStandardMaterial({
        color: 0xef4444,
        emissive: 0xef4444,
        emissiveIntensity: 0.3
    });
    const redLens = new THREE.Mesh(lensGeometry, redMaterial);
    redLens.position.set(-9.5, 10.7, 0.8);
    semaphoreGroup.add(redLens);

    const yellowMaterial = new THREE.MeshStandardMaterial({
        color: 0xf59e0b,
        emissive: 0xf59e0b,
        emissiveIntensity: 0.4
    });
    const yellowLens = new THREE.Mesh(lensGeometry, yellowMaterial);
    yellowLens.position.set(-9.5, 8.5, 0.8);
    semaphoreGroup.add(yellowLens);

    const greenMaterial = new THREE.MeshStandardMaterial({
        color: 0x10b981,
        emissive: 0x10b981,
        emissiveIntensity: 1.8
    });
    const greenLens = new THREE.Mesh(lensGeometry, greenMaterial);
    greenLens.position.set(-9.5, 6.3, 0.8);
    semaphoreGroup.add(greenLens);

    scene.add(semaphoreGroup);

    // Nós IoT conectados no espaço
    const nodesGroup = new THREE.Group();
    const nodeGeometry = new THREE.SphereGeometry(0.7, 16, 16);
    const nodeMaterial = new THREE.MeshStandardMaterial({
        color: 0x38bdf8,
        emissive: 0x0284c7,
        emissiveIntensity: 1.2
    });

    const nodeCoords = [
        [-30, 4, -15],
        [-12, 10, -5],
        [8, 6, -20],
        [28, 12, 10],
        [-20, 8, 22],
        [35, -2, 28]
    ];

    nodeCoords.forEach(coord => {
        const node = new THREE.Mesh(nodeGeometry, nodeMaterial);
        node.position.set(coord[0], coord[1], coord[2]);
        nodesGroup.add(node);
    });
    scene.add(nodesGroup);

    // Mouse Tracking para Parallax Suave
    let mouseX = 0;
    let mouseY = 0;
    let targetX = 0;
    let targetY = 0;

    window.addEventListener('mousemove', (e) => {
        mouseX = (e.clientX - window.innerWidth / 2) * 0.0012;
        mouseY = (e.clientY - window.innerHeight / 2) * 0.0012;
    });

    // Loop de Animação
    let clock = new THREE.Clock();

    function animate() {
        requestAnimationFrame(animate);
        const elapsedTime = clock.getElapsedTime();

        // Interpolação suave do mouse
        targetX += (mouseX - targetX) * 0.05;
        targetY += (mouseY - targetY) * 0.05;

        camera.position.x = targetX * 35;
        camera.position.y = 20 - targetY * 20;
        camera.lookAt(0, 0, 0);

        // Movimento do fluxo de tráfego pelas curvas
        const posArray = particleGeometry.attributes.position.array;
        for (let i = 0; i < particleCount; i++) {
            particleProgress[i] += 0.003 + (i % 5) * 0.0006;
            if (particleProgress[i] > 1) {
                particleProgress[i] = 0;
            }
            const pt = particleCurves[i].getPoint(particleProgress[i]);
            posArray[i * 3] = pt.x;
            posArray[i * 3 + 1] = pt.y;
            posArray[i * 3 + 2] = pt.z;
        }
        particleGeometry.attributes.position.needsUpdate = true;

        // Pulso do semáforo "Onda Verde"
        const greenPulse = 1.2 + Math.sin(elapsedTime * 3) * 0.8;
        greenMaterial.emissiveIntensity = greenPulse;
        greenLight.intensity = 2.5 + Math.sin(elapsedTime * 3) * 1.5;

        // Leve rotação dos nós da cidade inteligente
        nodesGroup.rotation.y = elapsedTime * 0.08;
        semaphoreGroup.position.y = 2 + Math.sin(elapsedTime * 1.5) * 0.4;

        renderer.render(scene, camera);
    }

    animate();

    // Redimensionamento
    window.addEventListener('resize', () => {
        const newWidth = container.clientWidth || window.innerWidth;
        const newHeight = container.clientHeight || 600;
        camera.aspect = newWidth / newHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(newWidth, newHeight);
    });
}

/**
 * Efeito 3D Tilt nos cards interativos com luz reflexiva
 */
function init3DTilt() {
    const cards = document.querySelectorAll('[data-tilt]');

    cards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateX = ((y - centerY) / centerY) * -12;
            const rotateY = ((x - centerX) / centerX) * 12;

            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)`;
            card.style.transition = 'transform 0.5s ease-out';
        });

        card.addEventListener('mouseenter', () => {
            card.style.transition = 'none';
        });
    });
}

/**
 * Efeito Parallax em elementos flutuantes durante o scroll
 */
function initParallaxScroll() {
    const parallaxElements = document.querySelectorAll('[data-parallax-speed]');
    if (parallaxElements.length === 0) return;

    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;

        parallaxElements.forEach(el => {
            const speed = parseFloat(el.getAttribute('data-parallax-speed') || '0.2');
            const yPos = -(scrolled * speed);
            el.style.transform = `translate3d(0, ${yPos}px, 0)`;
        });
    }, { passive: true });
}
