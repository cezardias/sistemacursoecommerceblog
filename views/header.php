<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo isset($page_title) ? $page_title . " - Aula Direta" : "Aula Direta - Portal Educacional"; ?>
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Swiper.js for Carousel -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .bg-navy {
            background-color: #112140;
        }

        .text-navy {
            color: #112140;
        }

        .bg-orange {
            background-color: #FF7800;
        }

        .text-orange {
            color: #FF7800;
        }

        .border-orange {
            border-color: #FF7800;
        }

        .hover-bg-navy:hover {
            background-color: #0d1a33;
        }

        .hover-bg-orange:hover {
            background-color: #e66c00;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900">
    <nav class="shadow-md sticky top-0 z-50" style="background-color: #ffffff;">
        <div class="container mx-auto px-6 py-2 flex justify-between items-center">
            <a href="/index.php?url=home" class="flex items-center">
                <img src="/assets/images/logo.png?v=1.7" alt="Aula Direta" class="h-24 md:h-32">
            </a>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-button" class="md:hidden text-navy focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
            </button>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-4 items-center">
                <a href="/index.php?url=cursos"
                    class="bg-navy text-white px-5 py-2 rounded-full hover:bg-orange transition shadow-lg text-sm font-bold">Cursos</a>
                <a href="/index.php?url=blog"
                    class="bg-navy text-white px-5 py-2 rounded-full hover:bg-orange transition shadow-lg text-sm font-bold">Blog</a>

                <a href="/index.php?url=cart"
                    class="relative group bg-navy p-2 rounded-full hover:bg-orange transition shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <?php
                    $total_items = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
                    if ($total_items > 0):
                        ?>
                        <span
                            class="absolute -top-2 -right-2 bg-orange text-white text-[10px] font-bold h-4 w-4 rounded-full flex items-center justify-center animate-bounce">
                            <?php echo $total_items; ?>
                        </span>
                    <?php endif; ?>
                </a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/index.php?url=admin"
                        class="bg-navy text-white px-5 py-2 rounded-full hover:bg-orange transition shadow-lg font-bold">Painel</a>
                    <a href="/index.php?url=logout"
                        class="bg-red-500 text-white px-5 py-2 rounded-full hover:bg-red-600 transition shadow-lg font-bold">Sair</a>
                <?php else: ?>
                    <a href="/index.php?url=login"
                        class="bg-navy text-white px-5 py-2 rounded-full hover:bg-orange transition shadow-lg font-bold">Entrar</a>
                    <a href="https://wa.me/5511964811689?text=Olá! Gostaria de me matricular em um curso." target="_blank"
                        class="bg-navy text-white px-6 py-2 rounded-full hover:bg-orange transition shadow-lg flex items-center justify-center space-x-2 font-bold">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.801.981 3.824 1.499 5.888 1.5h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg>
                        <span>Matricule-se</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 px-6 py-4 space-y-3">
            <a href="/index.php?url=cursos"
                class="block bg-navy text-white text-center py-3 rounded-full font-bold shadow-md">Cursos</a>
            <a href="/index.php?url=blog"
                class="block bg-navy text-white text-center py-3 rounded-full font-bold shadow-md">Blog</a>
            <a href="/index.php?url=cart"
                class="block bg-navy text-white text-center py-3 rounded-full font-bold shadow-md">Carrinho
                (<?php echo $total_items; ?>)</a>
            <hr>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/index.php?url=admin"
                    class="block bg-navy text-white text-center py-3 rounded-full font-bold shadow-md">Meu Painel</a>
                <a href="/index.php?url=logout"
                    class="block bg-red-500 text-white text-center py-3 rounded-full font-bold shadow-md">Sair</a>
            <?php else: ?>
                <a href="/index.php?url=login"
                    class="block bg-navy text-white text-center py-3 rounded-full font-bold shadow-md">Entrar</a>
                <a href="/index.php?url=cursos"
                    class="block bg-navy text-white text-center py-3 rounded-full font-bold shadow-md flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.801.981 3.824 1.499 5.888 1.5h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                    </svg>
                    <span>Matricule-se</span>
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function () {
            document.getElementById('mobile-menu').classList.togg
            le('hidden');
        });
    </script>