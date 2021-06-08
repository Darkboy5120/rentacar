<?php
if ($ci0->existSession("user_data")) {
    header('Location: ?p=home');
    exit;
}
$ci0->setSession("securitykey", $ci0->getSecurityKey());
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" sizes="32x32" href="media/images/main_logo.png" />
        <!-- ScrollReveal -->
        <script src="https://unpkg.com/scrollreveal"></script>
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/0d40d8f017.js" crossorigin="anonymous"></script>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="view/pages/styles/welcome.css">
		<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

        <title></title>
    </head>
    <body>
        <main>
            <?php include "view/components/navbar.php";?>
            <div class="fixed-location">
                <span><?=$l_arr["global"]["txt_0"]?> <span data-location=""></span></span>
            </div>
            <div class="container">
                <section class="w-header" id="w-header">
                    <div class="bg-text">
                        <h1>Rentacar</h1>
                        <p>Tu servicio de renta de autos</p>
                    </div>
                </section>
				<h1 id="titulo" data-aos="fade-right">Registro fácil y rápido</h1>
				<div id="uno" data-aos="fade-right">
				<h2 id="primero">Dentro de la aplicación, contamos con un sistema de registro
				rápido y sencillo, para que el usuario pueda acceder a los beneficios que nuestra aplicación
				ofrece al público.</h2>
				<img id="registro" src="media\images\registro.gif" alt="Registro">
				</div>
				<h1 id="titulo" data-aos="fade-left">Calidad y precio</h1>
				<div id="dos" data-aos="fade-left">
				<img id="autos" src="media\images\listadeautos.gif" alt="Autos">
				<h2 id="segundo">Contamos con una selección variada de automóviles, para los
				gustos de nuestros usuarios, así como un muy buen precio, accesible y cómodo.</h2>
				</div>
				<h1 id="titulo" data-aos="fade-right">Sistema de busqueda</h1>
				<div id="tres" data-aos="fade-right">
				<h2 id="tercero">Tenemos una interfaz de búsqueda eficiente y fácil de llenar,
				para poder ofrecer la mejor experiencia al usuario.</h2>
				<img id="busqueda" src="media\images\busqueda.gif" alt="Busqueda">
				</div>
				<div id="descarga" data-aos="flip-down">
					<center>
					<img id="logodescarga" src="media\images\main_logo.png" alt="">
					<h2>¡Instala la aplicación ahora!</h2></center>
				</div>

                <?php include "view/components/footer.php";?>
            </div>
        </main>

        <?php include "view/components/loading-screen.php";?>

        <script>
            l_arr = <?php echo json_encode($l_arr);?>;
        </script>
        <script src="controller/components/modal.js"></script>
        <script src="controller/components/request-me.js"></script>
        <script src="controller/components/alert-me.js"></script>
        <script src="controller/components/loading-screen.js"></script>
        <script src="controller/pages/welcome.js"></script>
        <script type="module">
            import * as THREE from './controller/libraries/three/build/three.module.js';
            import Stats from './controller/libraries/three/examples/jsm/libs/stats.module.js';
            import { OrbitControls } from './controller/libraries/three/examples/jsm/controls/OrbitControls.js';
            import { RoomEnvironment } from './controller/libraries/three/examples/jsm/environments/RoomEnvironment.js';
            import { GLTFLoader } from './controller/libraries/three/examples/jsm/loaders/GLTFLoader.js';
            import { FBXLoader } from './controller/libraries/three/examples/jsm/loaders/FBXLoader.js';
            import { DRACOLoader } from './controller/libraries/three/examples/jsm/loaders/DRACOLoader.js';

			let camera, scene, renderer, stats;

			const clock = new THREE.Clock();

			let mixer;

			init();
			animate();

			function init() {

				const container = document.querySelector("#w-header");

				camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 2000 );
				camera.position.set( 100, 200, 500 );

				scene = new THREE.Scene();
				scene.background = new THREE.Color( 0xa0a0a0 );
				scene.fog = new THREE.Fog( 0xa0a0a0, 200, 1000 );

				const hemiLight = new THREE.HemisphereLight( 0x222222, .5 );
				hemiLight.position.set( 0, 200, 0 );
				scene.add( hemiLight );

				const dirLight = new THREE.DirectionalLight( 0xffffff );
				dirLight.position.set( -300, 300, 100 );
				dirLight.castShadow = true;
				dirLight.shadow.camera.top = 150;
				dirLight.shadow.camera.bottom = - 150;
				dirLight.shadow.camera.left = - 150;
				dirLight.shadow.camera.right = 150;
				scene.add( dirLight );

				// scene.add( new THREE.CameraHelper( dirLight.shadow.camera ) );

				// ground
				const mesh = new THREE.Mesh( new THREE.PlaneGeometry( 2000, 2000 ), new THREE.MeshPhongMaterial( { color: 0x999999, depthWrite: false } ) );
				mesh.rotation.x = - Math.PI / 2;
				mesh.receiveShadow = true;
				scene.add( mesh );

				const grid = new THREE.GridHelper( 2000, 20, 0x000000, 0x000000 );
				grid.material.opacity = 0.2;
				grid.material.transparent = true;
				scene.add( grid );

				// model
				const loader = new FBXLoader();
				loader.load( './controller/3dmodels/car_arrival.fbx', function ( object ) {

					mixer = new THREE.AnimationMixer( object );

					//const action = mixer.clipAction( object.animations[ 0 ] );
					//action.play();

					object.traverse( function ( child ) {

						if ( child.isMesh ) {

							child.castShadow = true;
							child.receiveShadow = true;

						}

					} );

					scene.add( object );

                }, function ( e ) {
                    if (e.loaded === e.total) {
                        hideLoadingScreen();
                    }
                }, function ( e ) {
                    console.error( e );
                } );

				renderer = new THREE.WebGLRenderer( { antialias: true } );
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setSize( window.innerWidth, window.innerHeight );
				renderer.shadowMap.enabled = true;
				container.appendChild( renderer.domElement );

				const controls = new OrbitControls( camera, renderer.domElement );
				controls.target.set( 0, 100, 0 );
				controls.update();
                controls.enabled = false;

				window.addEventListener( 'resize', onWindowResize );

				// stats
				//stats = new Stats();
				//container.appendChild( stats.dom );

			}

			function onWindowResize() {

				camera.aspect = window.innerWidth / window.innerHeight;
				camera.updateProjectionMatrix();

				renderer.setSize( window.innerWidth, window.innerHeight );

			}

			//

			function animate() {

				requestAnimationFrame( animate );

				const delta = clock.getDelta();

                scene.rotation.y += 0.01;

				//if ( mixer ) mixer.update( delta );

				renderer.render( scene, camera );

				//stats.update();

			}
        </script>
		<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
		<script>
  			AOS.init();
		</script>
    </body>
</html>