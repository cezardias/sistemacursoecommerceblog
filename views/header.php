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
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/home" class="flex items-center">
                <img src="/assets/images/logo.png" alt="Aula Direta" class="h-12 md:h-16">
            </a>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-button" class="md:hidden text-navy focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
            </button>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8 items-center font-medium">
                <a href="/home#cursos" class="hover:text-orange transition">Cursos</a>
                <a href="#" class="hover:text-orange transition">EJA</a>
                <a href="#" class="hover:text-orange transition">Blog</a>

                <a href="/cart" class="relative group">
                    <svg class="w-6 h-6 text-navy group-hover:text-orange transition" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
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
                    <a href="/admin" class="bg-navy text-white px-5 py-2 rounded-full hover-bg-navy transition">Painel</a>
                    <a href="/logout" class="text-gray-600 hover:text-red-500 transition">Sair</a>
                <?php else: ?>
                    <a href="/login" class="text-navy hover:text-orange transition">Entrar</a>
                    <a href="/home#cursos"
                        class="bg-orange text-white px-6 py-2 rounded-full hover-bg-orange transition shadow-lg">Matricule-se</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 px-6 py-4 space-y-4">
            <a href="/home#cursos" class="block text-navy font-medium">Cursos</a>
            <a href="#" class="block text-navy font-medium">EJA</a>
            <a href="#" class="block text-navy font-medium">Blog</a>
            <a href="/cart" class="block text-navy font-medium">Carrinho (<?php echo $total_items; ?>)</a>
            <hr>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/admin" class="block text-navy font-bold">Meu Painel</a>
                <a href="/logout" class="block text-red-500 font-bold">Sair</a>
            <?php else: ?>
                <a href="/login" class="block text-navy font-bold">Entrar</a>
                <a href="/home#cursos"
                    class="block bg-orange text-white text-center py-3 rounded-xl font-bold">Matricule-se</a>
            <?php endif; ?>
        </div>
    </nav>

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function () {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>