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
            <a href="/home" class="flex items-center space-x-2">
                <div class="bg-navy p-2 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <span class="text-2xl font-bold text-navy">Aula Direta</span>
            </a>
            <div class="hidden md:flex space-x-8 items-center font-medium">
                <a href="#" class="hover:text-orange transition">Cursos</a>
                <a href="#" class="hover:text-orange transition">EJA</a>
                <a href="#" class="hover:text-orange transition">Blog</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/admin" class="bg-navy text-white px-5 py-2 rounded-full hover-bg-navy transition">Painel</a>
                    <a href="/logout" class="text-gray-600 hover:text-red-500 transition">Sair</a>
                <?php else: ?>
                    <a href="/login" class="text-navy hover:text-orange transition">Entrar</a>
                    <a href="#"
                        class="bg-orange text-white px-6 py-2 rounded-full hover-bg-orange transition shadow-lg">Matricule-se</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>