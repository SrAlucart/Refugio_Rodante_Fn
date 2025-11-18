<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiénes Somos </title>
    <link rel="stylesheet" href="{{ asset('css/quienessomos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>
<style>
    .nav-link-wrapper a {
        text-decoration: none;
        color: white;
        padding: 10px;
        transition: color 0.3s ease;
    }

    @media (max-width: 768px) {
        .titulo {
            margin-left: -40px;
            margin-top: 10px;
            font-size: 20px;
            font-weight: normal;
        }

        .descripcion {
            margin-left: -40px;
            font-size: 15px;
            width: 118%;
        }
    }
</style>



<body>
   <header>
        <div class="logo-container">
            <div class="left-side">
                <a href="/"><img src="{{ asset('img/refugiorodante2.png') }}" alt="Logo"></a>
            </div>
            <div class="right-side">
                <h1>REFUGIO RODANTE</h1>
            </div>
            <div class="menu-toggle" id="menu-toggle">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
        </div>
        <nav id="nav-menu" class="nav-links">
            <div class="nav-link-wrapper"><a href="/inde">Inicio</a></div>
            <div class="nav-link-wrapper"><a href="/informacion">Más información</a></div>
            <div class="nav-link-wrapper"><a href="/quienessomos">Quienes Somos</a></div>
            <div class="nav-link-wrapper"><a href="/login">Iniciar Sesión</a></div>
        </nav>
    </header>



    <div class="tu-aliado">
        <h3 class="subtitulo">Tu aliado en estacionamiento seguro y confiable</h3>
        <h1 class="titulo">Refugio Rodante</h1>
        <p class="descripcion">
            Descubre cómo facilitamos la reserva de parqueaderos con servicios destacados y atención personalizada.
        </p>
    </div>

    </head>

    <body>
        <div class="comentario">
            <div class="testimonial-section">
                <div class="quote-circles">
                    <div class="circle"></div>
                    <div class="circle"></div>
                </div>
                <div class="quote">
                    Refugio Rodante ha transformado la forma en que organizo mis reservas de parqueadero. ¡Es rápido, fácil y confiable!
                </div>
                <div class="client-info">
                    Carlos Pérez, Cliente frecuente
                </div>
            </div>



            <div class="mission-section">
                <h3 class="section-title">Nuestros Valores</h3>
                <h1 class="main-title">Nuestra Misión</h1>

                <p class="mission-text">
                    Proveer soluciones accesibles y seguras para el estacionamiento de vehículos.
                </p>

                <p class="mission-text">
                    Fomentar la confianza y satisfacción de nuestros clientes a través de servicios de calidad.
                </p>

                <p class="mission-text">
                    Contribuir al bienestar de la comunidad ofreciendo opciones de estacionamiento confiables y sostenibles.
                </p>


            </div>
        </div>
        <br><br><br><br><br><br><br>

        <!-- ==================================FILOSOFIA================================== -->


        <div class="contenedor">
            <div class="encabezado">
                <h1 style="margin-left: -15px;">Nuestra Filosofía</h1>
                <p>En Refugio Rodante, nos guiamos por principios que aseguran la excelencia en cada interacción.</p>
            </div>

            <div class="rejilla-filosofia">
                <div class="tarjeta-filosofia">
                    <div class="contenedor-icono">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h2>Confianza</h2>
                    <p>Garantizamos un servicio seguro y transparente que genera confianza en nuestros clientes.</p>
                </div>

                <div class="tarjeta-filosofia">
                    <div class="contenedor-icono">
                        <i class="bi bi-lightbulb"></i>
                    </div>
                    <h2>Innovación</h2>
                    <p>Implementamos tecnología avanzada para mejorar la experiencia de reserva y estacionamiento.</p>
                </div>

                <div class="tarjeta-filosofia">
                    <div class="contenedor-icono">
                        <i class="bi bi-tree"></i>
                    </div>
                    <h2>Sostenibilidad</h2>
                    <p>Promovemos prácticas responsables y sostenibles en nuestras operaciones.</p>
                </div>

                <div class="tarjeta-filosofia">
                    <div class="contenedor-icono">
                        <i class="bi bi-universal-access"></i>
                    </div>
                    <h2>Accesibilidad</h2>
                    <p>Ofrecemos soluciones adaptadas a las necesidades de todos nuestros usuarios.</p>
                </div>
            </div>
        </div>




        <br><br><br>




        <!-- ==============================================FOOTER============================================0 -->

        <style>
            .logo img {
                transform: scale(1.5);
                margin-bottom: 20px;
                margin: 20px;
                border-radius: 5px;
            }
        </style>
        <!--==============================================FOOTER============================================0 -->
        <footer class="footer">
            <div class="container">
                <div class="logo">
                    <img src="img/refugiorodante2.png" style="border-radius: 60px;" alt="Parking Logo">
                </div>
                <div class="content">
                    <div class="ubicacion">
                        <h3>Ubicación</h3>
                        <p><img src="img/maps.png" alt="Ubicación" class="icon">Cra 14 No. 89-48 (Of. 202)</p>
                        <p><img src="img/maps.png" alt="Ciudad" class="icon">Bogotá - Colombia</p>
                    </div>
                    <div class="contact">
                        <h3>Contacto</h3>
                        <p><img src="img/celular.png" alt="PBX" class="icon"><span>PBX: </span>+57 (1) 519 00 77</p>
                        <p><img src="img/celular.png" alt="Servicio al cliente" class="icon"><span>Servicio al cliente:</span>+57 323 449 9666</p>
                        <p><img src="img/correo.png" alt="Correo" class="icon"><span>Correo:</span><a href="mailto:servicioalcliente@parking.net.co">servicioalcliente@gmail.com </a></p>
                    </div>
                    <div class="legal">
                        <h3>Legal</h3>
                        <p><img src="img/icono doc.png" class="icon"><a href="index.php?pagina=termino-y-condiciones">Término y condiciones politica de privacidad </a></p>
                        <p><img src="img/icono doc.png" alt="Cumplimiento" class="icon"><a href="#">Cumplimiento</a></p>
                    </div>
                    <div class="social"><a href="https://web.facebook.com/gaming/play/?store_visit_source=gaming_tab"><img src="img/facebook.png" alt="Facebook"></a><a href="https://www.instagram.com/"><img src="img/instagram.png" alt="Instagram"></a></div>
                </div>
                <div class="copyright">
                    <p>©2020 Parking - Todos los derechos reservados</p>
                </div>
            </div>
        </footer>


       
        <script src="{{ asset('js/bilboard.js') }}"></script>
        
    </body>

</html>