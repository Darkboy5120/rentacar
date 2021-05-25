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
            import { DRACOLoader } from './controller/libraries/three/examples/jsm/loaders/DRACOLoader.js';

            let mixer;

            const clock = new THREE.Clock();
            const container = document.getElementById( 'w-header' );

            //const stats = new Stats();
            //container.appendChild( stats.dom );

            const renderer = new THREE.WebGLRenderer( { antialias: true } );
            renderer.setPixelRatio( window.devicePixelRatio );
            renderer.setSize( window.innerWidth, window.innerHeight );
            renderer.outputEncoding = THREE.sRGBEncoding;
            container.appendChild( renderer.domElement );

            const pmremGenerator = new THREE.PMREMGenerator( renderer );

            const scene = new THREE.Scene();
            scene.background = new THREE.Color( 0xbfe3dd );
            scene.environment = pmremGenerator.fromScene( new RoomEnvironment(), 0.04 ).texture;

            const camera = new THREE.PerspectiveCamera( 40, window.innerWidth / window.innerHeight, 1, 100 );
            camera.position.set( 5, 2, 8 );

            const controls = new OrbitControls( camera, renderer.domElement );
            controls.target.set( 0, 0.5, 0 );
            controls.update();
            controls.enabled = false;

            const dracoLoader = new DRACOLoader();
            dracoLoader.setDecoderPath( '/gltf/' );

            var model;

            const loader = new GLTFLoader();
            loader.setDRACOLoader( dracoLoader );
            loader.load( './controller/3dmodels/castle.glb', function ( gltf ) {

                model = gltf.scene;
                //model.position.set( 1, 1, 0 );
                model.position.set( -2, -3, -5 );
                //model.scale.set( 0.01, 0.01, 0.01 );
                model.scale.set( 1, 1, 1 );
                scene.add( model );

                //mixer = new THREE.AnimationMixer( model );
                //mixer.clipAction( gltf.animations[ 0 ] ).play();

                animate();

            }, function ( e ) {
                if (e.loaded === e.total) {
                    hideLoadingScreen();
                }
            }, function ( e ) {
                console.error( e );
            } );


            window.onresize = function () {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();

                renderer.setSize( window.innerWidth, window.innerHeight );
            };

            function animate() {

                requestAnimationFrame( animate );

                const delta = clock.getDelta();
                model.rotation.y += 0.01;

                //mixer.update( delta );

                controls.update();

                //stats.update();

                renderer.render( scene, camera );

            }
        </script>
    </body>
</html>