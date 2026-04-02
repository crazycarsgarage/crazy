<?php
// 1. Incluir la librería de Redsys
require_once('RedsysAPI.php'); 

$miObj = new RedsysAPI;

// 2. Datos del pedido (IMPORTANTE: Aquí deberás capturar el total real de tu carrito)
// Redsys no admite puntos ni comas. 125.50€ -> 12550
$amount = "12550"; 
$id = "ORDER-" . time(); 
$fuc = "999008881"; // Cambia por tu FUC real del Sabadell
$terminal = "1";
$moneda = "978"; 
$trans = "0"; 
$urlWeb = "https://crazycarsgarage.com"; // Tu dominio real
$urlOK = $urlWeb . "/exito.html?ref=" . $id; 
$urlKO = $urlWeb . "/pago.php"; // Si falla, que vuelva a la página de pago
$urlCallback = $urlWeb . "/notificacion.php"; 

// 3. Configurar parámetros
$miObj->setParameter("DS_MERCHANT_AMOUNT", $amount);
$miObj->setParameter("DS_MERCHANT_ORDER", $id);
$miObj->setParameter("DS_MERCHANT_MERCHANTCODE", $fuc);
$miObj->setParameter("DS_MERCHANT_CURRENCY", $moneda);
$miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE", $trans);
$miObj->setParameter("DS_MERCHANT_TERMINAL", $terminal);
$miObj->setParameter("DS_MERCHANT_MERCHANTURL", $urlCallback);
$miObj->setParameter("DS_MERCHANT_URLOK", $urlOK);
$miObj->setParameter("DS_MERCHANT_URLKO", $urlKO);

// 4. Generar firma
$clave = "sq7HpVPS33PnS4H8758AZ6x4"; // Cambia por tu CLAVE real SHA256
$params = $miObj->createMerchantParameters();
$signature = $miObj->createMerchantSignature($clave);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crazy Cars Garage - Pasarela de Pago - Crazy Business | Tienda de Herramientas de Pintura y Taller de Chapa y Pintura</title>

    <meta name="author" content="ciberbross90">
    <meta name="copyright" content="ciberbross90">

    <meta name="description" content="Distribuidor oficial de pistolas de pintura NA y Norber Alonso. Especialistas en chapa y pintura con envío a toda España y Europa. Taller experto en chapa, pintura automotriz de alta gama, lunas y cristales en Serranillos del Valle. Distribuidor oficial de pistolas de pintura NA y Norber Alonso. ¡Calidad Crazy Business!">
    <meta name="keywords" content="pistolas pintura NA, Norber Alonso, herramientas pintura automotriz Europa, taller chapa y pintura Madrid, Crazy Cars Garage shop, taller chapa y pintura serranillos del valle, taller chapa y pintura griñon, taller chapa y pintura humanes de madrid, taller chapa y pintura cubas de la sagra, taller chapa y pintura carranque, lunas coche, pistolas pintura NA, pistolas pintura Norber Alonso, pistolas pintura envio a España, pistolas pintura envio a Europa, Crazy Cars Garage, Crazy Bussiness">
    <meta name="robots" content="index, follow">,
    
    <meta property="og:title" content="Crazy Cars Garage - Expertos en Chapa y Pintura - Crazy Business">
    <meta property="og:description" content="Especialistas en chapa, carrocería, pintura de alta gama, gestion de lunas y cristales, y distribución oficial de herramientas de pintura profesional.">
    <meta property="og:image" content="crazy logo.webp">
    <meta property="og:url" content="https://crazycarsgarage.github.io/crazycars/">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --crazy-turquoise: #000000; /* Fondo negro solicitado */
            --crazy-fuchsia: #FF00FF;
            --crazy-dark: #1a1a1a;
            --accent-turquoise: #40E0D0;
        }

        body { background-color: var(--crazy-turquoise); font-family: 'Roboto', sans-serif; margin: 0; }
        .font-crazy { font-family: 'Permanent Marker', cursive; }
        
        .nav-bar { background-color: var(--crazy-fuchsia); width: 100%; box-shadow: 0 4px 15px rgba(255, 0, 255, 0.4); }
        
        .main-container {
            background: white;
            border: 4px solid var(--crazy-dark);
            box-shadow: 10px 10px 0px var(--crazy-fuchsia);
        }

        .input-gris {
            background-color: #f3f4f6;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
            outline: none;
        }
        .input-gris:focus { border-color: var(--crazy-fuchsia); background-color: #fff; }
        
        .banner-envio {
            background-color: #fffbeb;
            border: 2px dashed #f59e0b;
            color: #92400e;
        }
        /* CORRECCIÓN: Estilo para permitir el scroll en los modales */
        .modal-content-scroll {
            max-height: 70vh;
            overflow-y: auto;
            padding-right: 10px; /* Espacio para la barra si aparece */
        }

        /* Estilo personalizado para la barra de scroll (opcional) */
        .modal-content-scroll::-webkit-scrollbar {
            width: 8px;
        }
        .modal-content-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .modal-content-scroll::-webkit-scrollbar-thumb {
            background: var(--crazy-fuchsia);
            border-radius: 10px;
        }
        #cookieBanner {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 99999;
            background: white;
            display: block; 
        }
    </style>

<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@graph": [
    {
      "@type": "AutoPartsStore",
      "@id": "https://crazycarsgarage.github.io/tienda.html#organization",
      "name": "Crazy Cars Garage & Shop",
      "url": "https://crazycarsgarage.github.io/crazycars/tienda.html",
      "logo": "https://crazycarsgarage.github.io/crazycars/crazy logo.webp",
      "description": "Distribuidor oficial de pistolas de pintura NA y Norber Alonso. Envío profesional a toda España y Europa.",
      "areaServed": [
        {
          "@type": "Country",
          "name": "Spain"
        },
        {
          "@type": "Continent",
          "name": "Europe"
        }
      ],
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "CALLE LOS CEREZOS 32", 
        "addressLocality": "Serranillos del Valle",
        "postalCode": "28979",
        "addressRegion": "Madrid",
        "addressCountry": "ES"
      },
      "sameAs": [
        "https://www.facebook.com/david.vergaracaraballos/?locale=es_LA",
        "https://www.instagram.com/crazy_cars_garage_davidvergara?igsh=Zzlia2ozbXNvNG9u"
      ]
    },
    {
      "@type": "Product",
      "name": "Pistola R25 NA CSC Hibrida SMILEY",
      "image": "https://crazycarsgarage.github.io/crazycars/smiley.webp",
      "description": "Pistola híbrida profesional edición Smiley para acabados de alta gama.",
      "brand": { "@type": "Brand", "name": "NA" },
      "sku": "R25-SMILEY",
      "offers": {
        "@type": "Offer",
        "price": "320.00",
        "priceCurrency": "EUR",
        "availability": "https://schema.org/InStock",
        "itemCondition": "https://schema.org/NewCondition",
        "areaServed": ["ES", "EU"]
      }
    },
    {
      "@type": "Product",
      "name": "Pistola R25 NA CSC Hibrida RED EDITION PRO",
      "image": "https://crazycarsgarage.github.io/crazycars/red_edition_pro.webp",
      "description": "Edición profesional Red Edition Pro para pintores exigentes.",
      "brand": { "@type": "Brand", "name": "NA" },
      "sku": "R25-RED-PRO",
      "offers": {
        "@type": "Offer",
        "price": "320.01",
        "priceCurrency": "EUR",
        "availability": "https://schema.org/InStock",
        "areaServed": ["ES", "EU"]
      }
    },
    {
      "@type": "Product",
      "name": "Pistola R25 NA HVLP GREN EDITION PRO",
      "image": "https://crazycarsgarage.github.io/crazycars/green_edition_pro.webp",
      "description": "Tecnología HVLP Green Edition para máximo ahorro y acabado espejo.",
      "brand": { "@type": "Brand", "name": "NA" },
      "sku": "R25-GREEN-PRO",
      "offers": {
        "@type": "Offer",
        "price": "320.01",
        "priceCurrency": "EUR",
        "availability": "https://schema.org/InStock",
        "areaServed": ["ES", "EU"]
      }
    },
    {
      "@type": "Product",
      "name": "Pistola R25 NA CSC R78 ROY PINTACARROS",
      "image": "https://crazycarsgarage.github.io/crazycars/roy_pintacarros.webp",
      "description": "Edición especial Roy Pintacarros. Precisión extrema.",
      "brand": { "@type": "Brand", "name": "NA" },
      "sku": "R25-ROY",
      "offers": {
        "@type": "Offer",
        "price": "320.01",
        "priceCurrency": "EUR",
        "availability": "https://schema.org/InStock",
        "areaServed": ["ES", "EU"]
      }
    },
    {
      "@type": "Product",
      "name": "Pistola R25 NA CSC VULKAN PRO",
      "image": "https://crazycarsgarage.github.io/crazycars/vulcan.webp",
      "description": "Pistola Vulkan Pro. Potencia y control para el taller profesional.",
      "brand": { "@type": "Brand", "name": "NA" },
      "sku": "R25-VULKAN",
      "offers": {
        "@type": "Offer",
        "price": "320.01",
        "priceCurrency": "EUR",
        "availability": "https://schema.org/InStock",
        "areaServed": ["ES", "EU"]
      }
    {
      "@type": "Product",
      "name": "Pistola NA Ionizer Antiestatica PRO",
      "image": "https://crazycarsgarage.github.io/crazycars/ionizer_NA.webp",
      "description": "Pistola NA Ionizer Antiestatica PRO con soporte Magnetico y Manometro NA.",
      "brand": { "@type": "Brand", "name": "NA" },
      "sku": "NA Ionizer Antiestatica PRO",
      "offers": {
        "@type": "Offer",
        "price": "720.00",
        "priceCurrency": "EUR",
        "availability": "https://schema.org/InStock",
        "areaServed": ["ES", "EU"]
      }
    {
      "@type": "Product",
      "name": "Pistola R25 NA Clear Black PRO",
      "image": "https://crazycarsgarage.github.io/crazycars/clear_black_pro_r25.webp",
      "description": "Pistola R25 NA Clear Black PRO. Potencia y control.",
      "brand": { "@type": "Brand", "name": "NA" },
      "sku": "R25 Clear Black",
      "offers": {
        "@type": "Offer",
        "price": "359.00",
        "priceCurrency": "EUR",
        "availability": "https://schema.org/InStock",
        "areaServed": ["ES", "EU"]
      }
    {
      "@type": "Product",
      "name": "Pistola NA R25 PRO Hibrida FIRE 1.3",
      "image": "https://crazycarsgarage.github.io/crazycars/fire_pro_r25.webp",
      "description": "Pistola R25 NA Fire PRO. La especialista en el trabajo diario.",
      "brand": { "@type": "Brand", "name": "NA" },
      "sku": "R25 Fire PRO",
      "offers": {
        "@type": "Offer",
        "price": "320.01",
        "priceCurrency": "EUR",
        "availability": "https://schema.org/InStock",
        "areaServed": ["ES", "EU"]
      }
    {
      "@type": "Product",
      "name": "Manometro Volumetrico NA Aguja Magnetica Rojo - Negro",
      "image": "https://crazycarsgarage.github.io/crazycars/manometro_NA_magnt_R_N.webp",
      "description": "Manometro Volumetrico NA Aguja Magnetica Rojo - Negro.",
      "brand": { "@type": "Brand", "name": "NA" },
      "sku": "Manometro volumetrico con aguja magnetica",
      "offers": {
        "@type": "Offer",
        "price": "35.00",
        "priceCurrency": "EUR",
        "availability": "https://schema.org/InStock",
        "areaServed": ["ES", "EU"]
      }
    {
      "@type": "Product",
      "name": "Cabezal NA ULTRA FINO Para Clear Black",
      "image": "https://crazycarsgarage.github.io/crazycars/cabezal_ultra_fino_CB.webp",
      "description": "Cabezal NA ULTRA FINO Para Clear Black.",
      "brand": { "@type": "Brand", "name": "NA" },
      "sku": "Cabezal Clear Black",
      "offers": {
        "@type": "Offer",
        "price": "59.00",
        "priceCurrency": "EUR",
        "availability": "https://schema.org/InStock",
        "areaServed": ["ES", "EU"]
      }
    {
      "@type": "Product",
      "name": "Adaptador Para Pistolas NA, Sata NR92-NR95, IWATA W400 AS1.6",
      "image": "https://crazycarsgarage.github.io/crazycars/adap_sata_NR92_NR95.webp",
      "description": "Adaptador Para Pistolas NA, Sata NR92-NR95, IWATA W400 AS1.6.",
      "brand": { "@type": "Brand", "name": "NA" },
      "sku": "Adaptador PPS",
      "offers": {
        "@type": "Offer",
        "price": "18.98",
        "priceCurrency": "EUR",
        "availability": "https://schema.org/InStock",
        "areaServed": ["ES", "EU"]
      }
    {
      "@type": "Product",
      "name": "Manometro Volumetrico NA COMPACT",
      "image": "https://crazycarsgarage.github.io/crazycars/manometro_NA_compact.webp",
      "description": "Manometro Volumetrico Norber Alonso de calidad.",
      "brand": { "@type": "Brand", "name": "NA" },
      "sku": "Manometro_compact",
      "offers": {
        "@type": "Offer",
        "price": "29.00",
        "priceCurrency": "EUR",
        "availability": "https://schema.org/InStock",
        "areaServed": ["ES", "EU"]
      }
    }
  ]
}
</script>

<link rel="canonical" href="https://crazycarsgarage.github.io/crazycars/">

</head>

<body class="flex flex-col min-h-screen">

<section class="relative w-full h-[25vh] md:h-[55vh] overflow-hidden">
    <img src="urban_BMW.webp" class="w-full h-full object-cover object-top" alt="Trabajo profesional de chapa y pintura Crazy Cars Garage">
    <img src="crazy art.webp" class="absolute top-0 right-0 h-full w-auto object-cover z-10" alt="Crazy Cars Garage - Tienda de Pistolas de Pintura">
</section>

<nav class="nav-bar text-white sticky top-0 z-50">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex flex-col md:flex-row justify-center md:justify-between items-center py-3">
            <h2><a href="index.html" class="text-2xl font-bold hidden md:block font-crazy">CRAZY BUSINESS S.L.</a></h2>
            <ul class="flex flex-wrap justify-center gap-4 text-sm md:text-lg uppercase font-crazy">
                <li><a href="index.html" class="nav-link px-3 py-2 block text-white"><i class="fas fa-home"></i></a></li>
                <li><a href="historia.html" class="nav-link px-3 py-2 block">Quienes somos</a></li>
                <li><a href="autos_locos.html" class="nav-link px-3 py-2 block">Autos Locos</a></li>
                <li><a href="chapa_pintura_lunas_serranillos_del_valle.html" class="nav-link px-3 py-2 block">Servicios</a></li>
                <li><a href="podcast.html" class="nav-link px-3 py-2 block">Podcast</a></li>
                <li><a href="tienda.html" class="nav-link px-3 py-2 block">Tienda</a></li>
                <li><a href="carrito.html" class="nav-link px-3 py-2 block"><i class="fas fa-shopping-cart"></i></a></li>
            </ul>
        </div>
    </div>
</nav>
    <main class="container mx-auto px-4 py-12 max-w-5xl flex-grow">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            
            <div class="space-y-6">
                <div class="main-container rounded-3xl p-6 h-fit">
                    <h2 class="text-2xl font-crazy mb-6 border-b-4 border-gray-100 pb-2">Resumen del Pedido</h2>
                    <div id="resumen-productos" class="space-y-4"></div>
                    
                    <div id="banner-info-envio" class="banner-envio mt-6 p-4 rounded-xl text-sm font-bold flex items-center gap-3">
                        <i class="fas fa-truck"></i>
                        <span id="texto-envio">Selecciona un país para calcular envío</span>
                    </div>

                    <div class="mt-6 pt-4 border-t-2 border-gray-100 space-y-2">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal:</span>
                            <span id="subtotal">0.00€</span>
                        </div>
                        <div class="flex justify-between text-gray-600 border-b pb-2">
                            <span>Gastos de envío:</span>
                            <span id="gastos-envio">0.00€</span>
                        </div>
                        <div class="flex justify-between text-2xl font-bold">
                            <span>TOTAL:</span>
                            <span id="total-pago" class="text-[#FF00FF]">0.00€</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-container rounded-3xl p-6">
                <h2 class="text-2xl font-crazy mb-6 border-b-4 border-gray-100 pb-2">Datos de Envío</h2>
                <form id="form-pago" class="space-y-4">
                    <div class="flex gap-4">
                        <div style="width: 40%;">
                        <input type="text" placeholder="Nombre" class="input-gris" required>
                        </div>
                        <div style="width: 60%;">
                        <input type="text" placeholder="Apellidos" class="input-gris" required>
			</div>
                    </div>
                    <input type="text" placeholder="Dirección completa" class="input-gris" required>
                    
                    <div class="flex gap-4">
                        <div style="width: 70%;">
                            <input type="text" placeholder="Ciudad" class="input-gris" required>
                        </div>
                        <div style="width: 30%;">
                            <input type="text" placeholder="C.P." class="input-gris" required>
                        </div>
                    </div>

                    <div>
                        <select id="pais" class="input-gris" required onchange="actualizarPrecios()">
                            <option value="" disabled selected>Selecciona tu país...</option>
                            <option value="EU">Alemania</option>
                            <option value="Latam">Argentina</option>
                            <option value="EU">Austria</option>
                            <option value="EU">Bélgica</option>
                            <option value="Latam">Bolivia</option>
                            <option value="Brasil">Brasil</option>
                            <option value="NAmerica">Canadá</option>
                            <option value="Latam">Chile</option>
                            <option value="Colombia">Colombia</option>
                            <option value="Latam">Costa Rica</option>
                            <option value="Latam">Cuba</option>
                            <option value="EU">Dinamarca</option>
                            <option value="Latam">Ecuador</option>
                            <option value="Latam">El Salvador</option>
                            <option value="España">España</option>
                            <option value="NAmerica">Estados Unidos</option>
                            <option value="EU">Finlandia</option>
                            <option value="EU">Francia</option>
                            <option value="UK">Gibraltar</option>
                            <option value="EU">Grecia</option>
                            <option value="Groenlandia">Groenlandia</option>
                            <option value="Latam">Guatemala</option>
                            <option value="Latam">Haití</option>
                            <option value="Latam">Honduras</option>
                            <option value="EU">Irlanda</option>
                            <option value="EU">Italia</option>
                            <option value="EU">Luxemburgo</option>
                            <option value="Latam">México</option>
                            <option value="Latam">Nicaragua</option>
                            <option value="EU">Países Bajos</option>
                            <option value="Latam">Panamá</option>
                            <option value="Latam">Paraguay</option>
                            <option value="Latam">Perú</option>
                            <option value="EU">Portugal</option>
                            <option value="Latam">República Dominicana</option>
                            <option value="EU">Rumanía</option>
                            <option value="EU">Suecia</option>
                            <option value="UK">Reino Unido</option>
                            <option value="Latam">Uruguay</option>
                            <option value="Latam">Venezuela</option>
                        </select>
                    </div>

                    <input type="email" placeholder="Email de contacto" class="input-gris" required>
                    <input type="tel" placeholder="Teléfono" class="input-gris" required>
                    
<form action="https://sis.redsys.es/sis/realizarPago" method="POST"> 
    <input type="hidden" name="Ds_SignatureVersion" value="HMAC_SHA256_V1"/>
    <input type="hidden" name="Ds_MerchantParameters" value="<?php echo $params; ?>"/>
    <input type="hidden" name="Ds_Signature" value="<?php echo $signature; ?>"/>
    
    <button type="submit" class="bg-[#40E0D0] text-black font-bold py-3 px-8 rounded-full uppercase w-full hover:scale-105 transition-all">
        Confirmar y Pagar
    </button>
</form>
			<div class="flex justify-center w-full mt-4 mb-8">
			<a href="carrito.html" class="inline-block bg-white text-[#FF00FF] px-4 py-2 rounded-full font-crazy  hover:bg-[#40E0D0] transition-colors text-xl"><i class="fas fa-arrow-left mr-2"></i> Volver</a>
			</div>
                </form>
            </div>
        </div>
    </main>

<footer class="bg-gray-900 text-white pt-10 pb-6 border-t-4 border-[#FF00FF]">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="flex flex-col md:flex-row justify-between items-center md:items-start gap-10">
            
            <div class="text-center md:text-left flex-1">
                <h3 class="text-xl md:text-2xl text-[#40E0D0] mb-4 font-crazy">Síguenos</h3>
                <div class="flex gap-4 justify-center md:justify-start mb-6">
                    <a href="https://www.facebook.com/david.vergaracaraballos/?locale=es_LA" target="_blank" class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-xl hover:scale-110 transition shadow-lg"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/crazy_cars_garage_davidvergara?igsh=Zzlia2ozbXNvNG9u" target="_blank" class="w-12 h-12 bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-500 rounded-full flex items-center justify-center text-xl hover:scale-110 transition shadow-lg"><i class="fab fa-instagram"></i></a>
                    <a href="https://wa.me/34652748175" target="_blank" class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-xl hover:scale-110 transition shadow-lg"><i class="fab fa-whatsapp"></i></a>
                </div>
                <h3 class="text-xl text-[#40E0D0] mb-1 font-crazy uppercase">Contacto</h3>
                <p class="text-sm text-gray-300 mb-1">
                <p class="text-sm text-gray-300">Tienda: <a href="mailto:crazycarsgarageserranillos@gmail.com" class="hover:text-[#FF00FF] transition">crazycarsgarageserranillos@gmail.com</a></p>
                <p class="text-sm text-gray-300">Taller: <a href="mailto:anonimonaranja@gmail.com" class="hover:text-[#FF00FF] transition">anonimonaranja@gmail.com</a></p>
                <p class="text-sm text-gray-300">Telf: <a href="tel:+34652748175" class="hover:text-[#FF00FF] transition">+34 652 74 81 75</a></p>

            </div>

            <div class="flex flex-col md:flex-row items-center md:items-end bg-gray-800 p-5 rounded-2xl border border-[#40E0D0] shadow-2xl gap-6 flex-1 md:justify-end">
                <div class="text-center md:text-right">
                    <h3 class="text-lg text-[#FF00FF] mb-1 uppercase font-crazy">Ubicación</h3>
                    <p class="text-sm leading-tight text-white">Calle Los Cerezos 32</p>
                    <p class="text-sm mb-4 text-gray-300">Serranillos del Valle, Madrid</p>
                    <a href="https://www.google.com/maps/search/?api=1&query=Calle+Los+Cerezos+32+Serranillos+del+Valle+Madrid" target="_blank" class="inline-block bg-[#40E0D0] text-gray-900 font-bold py-2 px-6 rounded-full text-[10px] hover:bg-white transition uppercase shadow-md">VER EN MAPA</a>
                </div>
                <div class="w-full md:w-64 h-32 md:h-40 overflow-hidden rounded-lg border border-gray-700 shadow-inner">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3049.5637255474324!2d-3.8923485!3d40.1519541!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd4193da4c2642d7%3A0x633190881f33f381!2sC.%20de%20los%20Cerezos%2C%2032%2C%2028979%20Serranillos%20del%20Valle%2C%20Madrid!5e0!3m2!1ses!2ses!4v1700000000000" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>

        <div class="text-center mt-12 pt-6 border-t border-gray-800">
            <div class="flex flex-wrap justify-center gap-4 md:gap-8 text-[14px] uppercase font-bold text-white-500 mb-4">
                <button onclick="toggleModal('modalLegal')" class="hover:text-[#40E0D0] transition">Aviso Legal</button>
                <button onclick="toggleModal('modalUso')" class="hover:text-[#40E0D0] transition">Condiciones de Uso</button>
                <button onclick="toggleModal('modalPrivacidad')" class="hover:text-[#40E0D0] transition">Política de Privacidad</button>
                <a href="https://ec.europa.eu/consumers/odr/" target="_blank" class="hover:text-[#40E0D0] transition uppercase">Resolución de Litigios UE</a>
            </div>
            <div class="flex flex-wrap justify-center gap-4 md:gap-8 text-[14px] uppercase font-bold text-white-500 mb-6">
                <button onclick="toggleModal('modalReparacion')" class="hover:text-[#40E0D0] transition">Condiciones de Reparación</button>
                <button onclick="toggleModal('modalVentaDetallada')" class="hover:text-[#40E0D0] transition">Politica de Venta, Cancelacion/Devolucion</button>
                <button onclick="toggleModal('modalCookies')" class="hover:text-[#40E0D0] transition">Cookies</button>
            </div>
            <p class="text-white-600 text-[10px] tracking-widest italic"><a href="index.html">© 2024 Crazy Business S.L.</a> - CIF B22801138</p>
        </div>
    </div>
</footer>

<div id="modalCookies" class="fixed inset-0 bg-black bg-opacity-90 z-[100000] hidden flex items-center justify-center p-4">
    <div class="bg-white text-gray-800 max-w-2xl w-full rounded-3xl border-4 border-gray-400 shadow-2xl overflow-hidden">
        <div class="p-6 md:p-10 text-sm space-y-6 text-justify modal-content">
            <h2 class="font-bold uppercase text-xl border-b pb-2 text-gray-900">Política de cookies</h2>
            <p>Política de cookies. Crazy Business no utiliza cookies para recoger información de los usuarios. Únicamente se utilizan cookies propias y de terceros con finalidad técnica para permitir la navegación a través del sitio web y la utilización de las diferentes opciones y servicios que en ella existen.</p>
            <p>El portal del que es titular Crazy Business contiene enlaces a sitios web de terceros, cuyas políticas de privacidad son ajenas a la de Crazy Business. Al acceder a tales sitios web usted puede decidir si acepta sus políticas de privacidad y de cookies. Con carácter general, si navega por internet usted puede aceptar o rechazar las cookies de terceros desde las opciones de configuración de su navegador.</p>
        </div>
        <div class="p-4 text-center border-t bg-gray-50">
            <button onclick="toggleModal('modalCookies')" class="bg-black text-white px-8 py-2 rounded-full font-bold uppercase text-xs hover:bg-gray-700 transition">Cerrar</button>
        </div>
    </div>
</div>

<div id="modalPrivacidad" class="fixed inset-0 bg-black bg-opacity-90 z-[100000] hidden flex items-center justify-center p-4">
    <div class="bg-white text-gray-800 max-w-4xl w-full rounded-3xl border-4 border-[#FF00FF] shadow-2xl overflow-hidden">
        <div class="p-6 border-b flex justify-between items-center bg-gray-50 rounded-t-3xl">
            <h2 class="font-crazy text-2xl text-[#FF00FF] uppercase">Política de Privacidad</h2>
            <button onclick="toggleModal('modalPrivacidad')" class="text-gray-400 hover:text-black text-3xl transition">&times;</button>
        </div>
        
        <div class="p-6 md:p-10 text-sm space-y-6 text-justify modal-content overflow-y-auto" style="max-height: 70vh;">
            
            <div class="bg-gray-50 border-2 border-gray-200 rounded-xl overflow-hidden mb-8">
                <div class="bg-gray-200 p-2 font-bold text-center uppercase text-xs tracking-widest">Información Básica sobre Protección de Datos</div>
                <table class="w-full text-xs">
                    <tr class="border-b border-gray-200">
                        <td class="p-3 font-bold bg-gray-100 w-1/3">Responsable</td>
                        <td class="p-3">CRAZY BUSINESS S.L.</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="p-3 font-bold bg-gray-100">Finalidad</td>
                        <td class="p-3">Gestión de servicios de taller, venta de productos y envío de comunicaciones comerciales.</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="p-3 font-bold bg-gray-100">Legitimación</td>
                        <td class="p-3">Ejecución de contrato (servicios) y Consentimiento del interesado (publicidad).</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="p-3 font-bold bg-gray-100">Destinatarios</td>
                        <td class="p-3">No se ceden datos a terceros, salvo obligación legal o proveedores de transporte.</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-bold bg-gray-100">Derechos</td>
                        <td class="p-3">Acceso, rectificación, supresión y otros derechos explicados en la información adicional.</td>
                    </tr>
                </table>
            </div>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#40E0D0] inline-block">1. Contacto para Privacidad</h3>
                <p>Para cualquier cuestión relacionada con el tratamiento de sus datos personales o para ejercer sus derechos, puede contactar directamente con nuestro responsable de privacidad a través del correo electrónico: <strong>anonimonaranja@gmail.com</strong>.</p>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#40E0D0] inline-block">2. Bases Legítimas del Tratamiento</h3>
                <p>Tratamos sus datos bajo dos fundamentos legales distintos dependiendo de la interacción:</p>
                <ul class="list-disc ml-5 mt-2 space-y-2">
                    <li><strong>Ejecución de Contrato:</strong> Para la gestión de reparaciones, pedidos y facturación, es obligatorio que nos facilite su <strong>nombre, apellidos, teléfono y dirección completa</strong>. Sin estos datos, no podríamos prestarle el servicio solicitado.</li>
                    <li><strong>Interés Legítimo y Consentimiento:</strong> Para el envío de ofertas personalizadas, newsletters o el análisis de uso de la web, solicitaremos su consentimiento previo. El resto de datos no obligatorios se tratarán bajo esta base.</li>
                </ul>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#40E0D0] inline-block">3. Conservación de Datos</h3>
                <p>Los datos personales proporcionados para la ejecución del contrato se conservarán mientras se mantenga la relación comercial y, posteriormente, durante los plazos exigidos por la legislación fiscal y civil para la atención de posibles responsabilidades.</p>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#40E0D0] inline-block">4. Derechos del Interesado</h3>
                <p>Usted tiene derecho a obtener confirmación sobre si estamos tratando sus datos. Puede ejercer sus derechos de acceso, rectificación, supresión, limitación y portabilidad enviando un e-mail a la dirección arriba indicada acompañando copia de su DNI.</p>
            </section>

        </div>
        
        <div class="p-4 text-center border-t bg-gray-50 rounded-b-3xl">
            <button onclick="toggleModal('modalPrivacidad')" class="bg-black text-white px-10 py-2 rounded-full font-bold uppercase text-xs hover:bg-[#FF00FF] transition-all shadow-lg">Entendido</button>
        </div>
    </div>
</div>

<div id="modalLegal" class="fixed inset-0 bg-black bg-opacity-90 z-[100000] hidden flex items-center justify-center p-4">
    <div class="bg-white text-gray-800 max-w-4xl w-full rounded-3xl border-4 border-[#40E0D0] shadow-2xl overflow-hidden">
        <div class="p-6 border-b flex justify-between items-center bg-gray-50 rounded-t-3xl">
            <h2 class="font-crazy text-2xl text-[#40E0D0] uppercase">Aviso Legal</h2>
            <button onclick="toggleModal('modalLegal')" class="text-gray-400 hover:text-black text-3xl transition">&times;</button>
        </div>
        
        <div class="p-6 md:p-10 text-sm space-y-6 text-justify modal-content overflow-y-auto" style="max-height: 70vh;">
            
            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#FF00FF] inline-block">1. Datos Identificativos</h3>
                <p class="mb-4">En cumplimiento con el artículo 10 de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y del Comercio Electrónico (LSSI-CE), se facilitan los siguientes datos:</p>
                
                <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200 space-y-2">
                    <p><strong>Titular:</strong> CRAZY BUSINESS S.L.</p>
                    <p><strong>NIF:</strong> B22801138</p>
                    <p><strong>Domicilio Social:</strong> Calle Los Cerezos 32, 28979 Serranillos del Valle (Madrid)</p>
                    <p><strong>Email:</strong> anonimonaranja@gmail.com</p>
                    <p class="pt-2 mt-2 border-t border-gray-200 text-gray-700">
                        <strong>Datos Registrales:</strong> Inscrita en el Registro Mercantil de Madrid, 
                        Tomo <strong>47895</strong>, Folio <strong>142</strong>, Sección <strong>8</strong>, Hoja <strong>M-845122</strong>, Inscripción 1ª.
                    </p>
                </div>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#FF00FF] inline-block">2. Propiedad Intelectual</h3>
                <p>CRAZY BUSINESS S.L. es titular de todos los derechos de propiedad intelectual e industrial de su página web, así como de los elementos contenidos en la misma (imágenes, sonido, audio, vídeo, software o textos; marcas o logotipos, combinaciones de colores, estructura y diseño, etc.).</p>
                <p>Queda expresamente prohibida la reproducción, distribución y comunicación pública de la totalidad o parte de los contenidos de esta página web con fines comerciales, en cualquier soporte y por cualquier medio técnico, sin la autorización de la empresa.</p>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#FF00FF] inline-block">3. Exclusión de Responsabilidad</h3>
                <p>El titular no se hace responsable, en ningún caso, de los daños y perjuicios de cualquier naturaleza que pudieran ocasionar, a título enunciativo: errores u omisiones en los contenidos, falta de disponibilidad del portal o la transmisión de virus o programas maliciosos, a pesar de haber adoptado todas las medidas tecnológicas necesarias para evitarlo.</p>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#FF00FF] inline-block">4. Enlaces (Links)</h3>
                <p>En el caso de que en la web se dispusiesen enlaces hacia otros sitios de Internet, CRAZY BUSINESS S.L. no ejercerá ningún tipo de control sobre dichos sitios y contenidos. En ningún caso asumirá responsabilidad alguna por los contenidos de algún enlace perteneciente a un sitio web ajeno.</p>
            </section>

        </div>
        
        <div class="p-4 text-center border-t bg-gray-50 rounded-b-3xl">
            <button onclick="toggleModal('modalLegal')" class="bg-black text-white px-10 py-2 rounded-full font-bold uppercase text-xs hover:bg-[#40E0D0] transition-all shadow-lg">Cerrar</button>
        </div>
    </div>
</div>

<div id="modalReparacion" class="fixed inset-0 bg-black bg-opacity-90 z-[100000] hidden flex items-center justify-center p-4">
    <div class="bg-white text-gray-800 max-w-5xl w-full rounded-3xl border-4 border-[#40E0D0] shadow-2xl overflow-hidden">
        <div class="p-6 border-b flex justify-between items-center bg-gray-50 rounded-t-3xl">
            <h2 class="font-crazy text-2xl text-[#40E0D0] uppercase">Condiciones de Taller y Reparación</h2>
            <button onclick="toggleModal('modalReparacion')" class="text-gray-400 hover:text-black text-3xl transition">&times;</button>
        </div>
        
        <div class="p-6 md:p-10 text-sm space-y-6 text-justify modal-content overflow-y-auto" style="max-height: 75vh;">
            
            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#FF00FF] inline-block">1. Aplicación y Resguardo de Depósito</h3>
                <p>Estas condiciones regulan los servicios de chapa, pintura y mecánica prestados por <strong>CRAZY BUSINESS S.L.</strong> (CIF B22801138) en nuestro centro de Serranillos del Valle. La entrega del vehículo implica la aceptación de estas condiciones y la firma del Resguardo de Depósito/Orden de Trabajo.</p>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#FF00FF] inline-block">2. Presupuestos y Diagnóstico</h3>
                <p>Las estimaciones iniciales se basan en la información del cliente. Si al desmontar el vehículo (especialmente en trabajos de chapa tras un siniestro) aparecen daños ocultos, se informará al cliente y solo se procederá tras su aceptación del nuevo presupuesto. Los presupuestos tienen una validez de 12 días hábiles.</p>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#FF00FF] inline-block">3. Custodia y Abandono</h3>
                <p>El depósito del vehículo está incluido en el precio de reparación. Una vez terminada la reparación y avisado el cliente, este dispone de <strong>3 días hábiles</strong> para recoger el coche. A partir del cuarto día, se devengarán gastos de estancia y custodia según las tarifas vigentes del taller.</p>
                <p class="text-red-600 font-bold">Importante: Crazy Cars Garage no se hace responsable de objetos personales dejados en el interior del vehículo.</p>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#FF00FF] inline-block">4. Garantía de Reparación</h3>
                <p>Todas nuestras reparaciones están garantizadas por <strong>3 meses o 2.000 kilómetros</strong> (lo que antes suceda), conforme al R.D. 1457/1986. Las piezas nuevas instaladas cuentan con la garantía legal de 3 años otorgada por el fabricante. La garantía se anula si el vehículo es manipulado por terceros tras nuestra intervención.</p>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#FF00FF] inline-block">5. Piezas de Repuesto</h3>
                <p>El cliente tiene derecho a recuperar las piezas sustituidas siempre que lo solicite al depositar el vehículo. En caso contrario, Crazy Cars Garage procederá a su gestión como residuo según la normativa medioambiental. Nos reservamos el derecho de no instalar piezas aportadas por el cliente si estas comprometen la seguridad vial.</p>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#FF00FF] inline-block">6. Pruebas y Seguro</h3>
                <p>Al firmar el resguardo, el cliente autoriza a realizar las pruebas en carretera necesarias para verificar la reparación. El cliente declara que el vehículo dispone de Seguro de Responsabilidad Civil obligatorio en vigor.</p>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#FF00FF] inline-block">7. Pago y Retención</h3>
                <p>El pago se realizará mediante tarjeta, efectivo (dentro de los límites legales) o transferencia antes de retirar el vehículo. Conforme al Art. 1.780 del Código Civil, el taller podrá retener el vehículo hasta que la factura sea abonada íntegramente.</p>
            </section>

            <section class="bg-gray-100 p-4 rounded-lg border-l-4 border-[#40E0D0]">
                <p class="text-[10px] text-gray-500 uppercase">
                    Crazy Business S.L. | Calle Los Cerezos 32, 28979 Serranillos del Valle (Madrid).<br>
                    Contacto: anonimonaranja@gmail.com | Tel: +34 652 74 81 75
                </p>
            </section>
        </div>
        
        <div class="p-4 text-center border-t bg-gray-50 rounded-b-3xl">
            <button onclick="toggleModal('modalReparacion')" class="bg-black text-white px-10 py-2 rounded-full font-bold uppercase text-xs hover:bg-[#40E0D0] transition-all shadow-lg">Cerrar</button>
        </div>
    </div>
</div>

<div id="modalVentaDetallada" class="fixed inset-0 bg-black bg-opacity-90 z-[100000] hidden flex items-center justify-center p-4">
    <div class="bg-white text-gray-800 max-w-5xl w-full rounded-3xl border-4 border-[#FF00FF] shadow-2xl overflow-hidden">
        <div class="p-6 border-b flex justify-between items-center bg-gray-50 rounded-t-3xl">
            <h2 class="font-crazy text-2xl text-[#FF00FF] uppercase">Condiciones Generales de Venta</h2>
            <button onclick="toggleModal('modalVentaDetallada')" class="text-gray-400 hover:text-black text-3xl transition">&times;</button>
        </div>
        
        <div class="p-6 md:p-10 text-sm space-y-6 text-justify modal-content overflow-y-auto" style="max-height: 75vh;">
            
            <p class="italic text-gray-600">Las presentes condiciones se aplican a las ventas realizadas por <strong>CRAZY BUSINESS S.L.</strong>, con CIF B22801138 y domicilio en Calle Los Cerezos 32, 28979 Serranillos del Valle (Madrid), a través de esta página web.</p>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#40E0D0] inline-block">1. Proceso de Pedido</h3>
                <p>Para adquirir nuestras pistolas, barnices o pinturas, el cliente deberá añadir los productos a la "cesta". Es necesario registrarse con datos reales (nombre, dirección de envío y contacto). La venta se considerará definitiva una vez enviado el correo de confirmación y recibido el pago íntegro.</p>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#40E0D0] inline-block">2. Productos y Stock</h3>
                <p>Nuestros productos de pintura y barnices están sujetos a disponibilidad de stock. En caso de rotura de stock de un barniz o resina específica, contactaremos con el cliente para ofrecer una alternativa de similar calidad o el reembolso total. <strong>Nota importante:</strong> Es responsabilidad del cliente verificar la compatibilidad química de las pinturas y barnices con la superficie a tratar.</p>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#40E0D0] inline-block">3. Tarifas y Pago</h3>
                <p>Los precios se expresan en euros e incluyen IVA. Los gastos de envío se calcularán según el peso de los botes de pintura o equipos de pulverización. Crazy Business S.L. se reserva el derecho de modificar precios sin previo aviso, garantizando siempre el precio vigente en el momento de la validación del pedido.</p>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#40E0D0] inline-block">4. Entrega de Materiales</h3>
                <p>Realizamos envíos a toda la Península y Baleares. Debido a la naturaleza inflamable de algunas pinturas y barnices, el transporte se realiza cumpliendo la normativa vigente de mercancías. Si el producto llega con el precinto abierto o el envase dañado, el cliente debe hacerlo constar en el albarán del transportista.</p>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#40E0D0] inline-block">5. Responsabilidad y Garantía</h3>
                <p>Las pistolas de pintura cuentan con la garantía legal de 3 años. <strong>Exclusiones:</strong> No se aceptarán garantías por atascos debidos a una mala limpieza tras el uso, ni por mezclas de componentes químicos no recomendadas. Crazy Business S.L. no se hace responsable de los daños producidos por una aplicación incorrecta de los barnices o pinturas suministrados.</p>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#40E0D0] inline-block">6. Derecho de Desistimiento</h3>
                <p>El cliente dispone de 14 días naturales para devolver el producto. <strong>Excepción:</strong> No se admitirá la devolución de pinturas personalizadas (colores a medida) o botes de barniz cuyo precinto de seguridad haya sido abierto, por motivos de protección de la salud y calidad del producto.</p>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#40E0D0] inline-block">7. Protección de Datos</h3>
                <p>Sus datos serán tratados por Crazy Business S.L. para la gestión del pedido y envío. Puede ejercer sus derechos de acceso, rectificación o supresión enviando un correo a <strong>anonimonaranja@gmail.com</strong>.</p>
            </section>

            <section class="bg-gray-100 p-4 rounded-lg border-l-4 border-[#FF00FF]">
                <p class="text-[10px] text-gray-500">
                    Legislación aplicable: Reino de España. Jurisdicción: Juzgados y Tribunales del domicilio del consumidor.
                </p>
            </section>
        </div>
        
        <div class="p-4 text-center border-t bg-gray-50 rounded-b-3xl">
            <button onclick="toggleModal('modalVentaDetallada')" class="bg-black text-white px-10 py-2 rounded-full font-bold uppercase text-xs hover:bg-[#FF00FF] transition-all shadow-lg">Entendido, cerrar</button>
        </div>
    </div>
</div>

<div id="modalUso" class="fixed inset-0 bg-black bg-opacity-90 z-[100000] hidden flex items-center justify-center p-4">
    <div class="bg-white text-gray-800 max-w-4xl w-full rounded-3xl border-4 border-[#40E0D0] shadow-2xl overflow-hidden">
        <div class="p-6 border-b flex justify-between items-center bg-gray-50 rounded-t-3xl">
            <h2 class="font-crazy text-2xl text-[#40E0D0] uppercase">Condiciones de Uso</h2>
            <button onclick="toggleModal('modalUso')" class="text-gray-400 hover:text-black text-3xl transition">&times;</button>
        </div>
        
        <div class="p-6 md:p-10 text-sm space-y-6 text-justify modal-content overflow-y-auto" style="max-height: 70vh;">
            
            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#FF00FF] inline-block">1. Obligaciones y Responsabilidad del Usuario</h3>
                <p>El usuario se compromete a utilizar los servicios y contenidos del portal de forma diligente, correcta y lícita. Queda terminantemente prohibido:</p>
                <ul class="list-disc ml-5 mt-2 space-y-1">
                    <li>Utilizar los contenidos con fines o efectos contrarios a la ley, a la moral y a las buenas costumbres generalmente aceptadas.</li>
                    <li>Reproducir, copiar o distribuir los servicios a menos que se cuente con la autorización expresa del titular.</li>
                    <li>Vulnerar derechos de propiedad intelectual o industrial pertenecientes a CRAZY BUSINESS S.L. o a terceros.</li>
                    <li>Emplear la información del portal para remitir publicidad, comunicaciones con fines de venta directa o cualquier otra clase de finalidad comercial no solicitada.</li>
                </ul>
                <p>El usuario responderá de los daños y perjuicios de toda naturaleza que la empresa pueda sufrir como consecuencia del incumplimiento de estas obligaciones.</p>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#FF00FF] inline-block">2. Propiedad Intelectual sobre Comentarios y Opiniones</h3>
                <p>Aquellos usuarios que envíen observaciones, opiniones o comentarios a través de los servicios habilitados en el portal autorizan a CRAZY BUSINESS S.L. para su reproducción, distribución, comunicación pública y transformación.</p>
                <p>Esta autorización se entiende realizada:</p>
                <ul class="list-disc ml-5 mt-2 space-y-1">
                    <li>A título gratuito.</li>
                    <li>Por todo el tiempo de protección de derechos de autor previsto legalmente.</li>
                    <li>Sin limitación territorial.</li>
                </ul>
                <p>CRAZY BUSINESS S.L. se reserva el derecho de no publicar o retirar aquellos comentarios que resulten contrarios a la ley, la moral, el orden público o que atenten contra la dignidad de terceros.</p>
            </section>

            <section>
                <h3 class="font-bold text-gray-900 uppercase mb-2 border-b-2 border-[#FF00FF] inline-block">3. Reserva de Derechos</h3>
                <p>CRAZY BUSINESS S.L. se reserva la facultad de interrumpir el acceso al portal o excluir al usuario en caso de observar conductas contrarias a las reglas internas o que puedan perturbar el buen funcionamiento, imagen o prestigio de la marca.</p>
            </section>

        </div>
        
        <div class="p-4 text-center border-t bg-gray-50 rounded-b-3xl">
            <button onclick="toggleModal('modalUso')" class="bg-black text-white px-10 py-2 rounded-full font-bold uppercase text-xs hover:bg-[#40E0D0] transition-all shadow-lg">Aceptar y cerrar</button>
        </div>
    </div>
</div>

<div id="cookie-law-banner" class="fixed bottom-0 left-0 w-full z-[9999] p-4">
    <div class="max-w-4xl mx-auto bg-black border border-[#40E0D0]/30 rounded-2xl shadow-[0_0_30px_rgba(0,0,0,0.9)] p-6 backdrop-blur-md">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-center md:text-left">
                <h3 class="text-[#40E0D0] font-marker text-xl mb-1">¿UNAS COOKIES, CRAZY?</h3>
                <p class="text-gray-300 text-xs md:text-sm leading-relaxed">
                    Usamos cookies para mejorar tu experiencia. Al aceptar, nos ayudas a optimizar la web. Si rechazas, solo usaremos las técnicas necesarias.
                </p>
            </div>
            <div class="flex gap-3 shrink-0">
                <button onclick="handleCookies('rechazado')" class="border border-gray-500 text-gray-400 px-6 py-2 rounded-xl font-bold uppercase text-xs hover:bg-gray-800 transition-all">
                    RECHAZAR
                </button>
                <button onclick="handleCookies('aceptado')" class="bg-[#40E0D0] text-black px-8 py-2 rounded-xl font-bold uppercase text-xs hover:scale-105 transition-all shadow-[0_0_15px_rgba(64,224,208,0.4)]">
                    ACEPTAR
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function saveCookieChoice() {
        const banner = document.getElementById('cookie-law-banner');
        if (banner) {
            banner.style.display = 'none';
            // Guardamos en el navegador que ya se aceptó
            localStorage.setItem('crazy_cookies_accepted', 'true');
        }
    }

    (function checkCookies() {
        const alreadyAccepted = localStorage.getItem('crazy_cookies_accepted');
        const banner = document.getElementById('cookie-law-banner');
        
        if (alreadyAccepted === 'true' && banner) {
            banner.style.display = 'none';
        }
    })();

    function toggleModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.toggle('hidden');
            if (!modal.classList.contains('hidden')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        }
    }
</script>

    <script>
        let subtotalGlobal = 0;

        function cargarCarrito() {
            const resumen = document.getElementById('resumen-productos');
            const subtotalE = document.getElementById('subtotal');
            let carrito = JSON.parse(localStorage.getItem('crazy_cart')) || [];
            if (carrito.length === 0) { window.location.href = "carrito.html"; return; }

            let suma = 0;
            resumen.innerHTML = '';
            carrito.forEach(item => {
                suma += item.precio * item.cantidad;
                resumen.innerHTML += `
                    <div class="flex justify-between items-center text-sm border-b border-gray-50 pb-2">
                        <div class="flex items-center gap-3">
                            <img src="${item.imagen}" class="w-10 h-10 object-cover rounded">
                            <span><span class="font-bold">${item.cantidad}x</span> ${item.nombre}</span>
                        </div>
                        <span class="font-bold">${(item.precio * item.cantidad).toFixed(2)}€</span>
                    </div>`;
            });
            subtotalGlobal = suma;
            subtotalE.innerText = suma.toFixed(2) + '€';
            actualizarPrecios();
        }

function actualizarPrecios() {
    const selector = document.getElementById('pais');
    const pais = selector.value;
    const nombrePais = selector.options[selector.selectedIndex].text;
    
    const gastosE = document.getElementById('gastos-envio');
    const totalE = document.getElementById('total-pago');
    const textoEnvio = document.getElementById('texto-envio');
    
    let envio = 0;

    if (pais === "España") {
    if (subtotalGlobal >= 50) {
        envio = 0;
        textoEnvio.innerText = "¡Envío gratuito a España aplicado por pedido superior a 59€!.";
    } else {
        envio = 12.95;
        textoEnvio.innerText = "Gastos de envío nacional: 12,95€ (Gratis en pedidos +59€)";
    }
    } else if (pais === "EU") {
        envio = 71.95;
        textoEnvio.innerText = `Gastos de envío a ${nombrePais}: 71,95€ aplicados.`;
    } else if (pais === "UK") {
        envio = 125.95;
        textoEnvio.innerText = "Gastos de envío a ${nombrePais}: 125,95€ aplicados.";
    } else if (pais === "Latam") {
        envio = 90.95;
        textoEnvio.innerText = `Gastos de envío a ${nombrePais}: 90,95€ aplicados.`;
    } else if (pais === "Brasil") {
        envio = 119.95;
        textoEnvio.innerText = `Gastos de envío a ${nombrePais}: 119,95€ aplicados.`;
    } else if (pais === "Groenlandia") {
        envio = 132.95;
        textoEnvio.innerText = `Gastos de envío a ${nombrePais}: 132,95€ aplicados. Costes de aranceles a cargo del cliente`;
    } else if (pais === "NAmerica") {
        envio = 90.95;
        textoEnvio.innerText = `Gastos de envío a ${nombrePais}: 90,95€ aplicados. Costes de aranceles a cargo del cliente`;
    } else {
        envio = 0;
        textoEnvio.innerText = "Selecciona un país para calcular envío";
    }

    gastosE.innerText = envio.toFixed(2) + '€';
    totalE.innerText = (subtotalGlobal + envio).toFixed(2) + '€';
}

        document.addEventListener('DOMContentLoaded', cargarCarrito);
        document.getElementById('form-pago').addEventListener('submit', (e) => {
            e.preventDefault();
            alert("¡Pedido recibido! Redirigiendo a pasarela de pago segura...");
        });
    </script>
</body>
</html>