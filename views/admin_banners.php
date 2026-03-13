<?php
// views/admin_banners.php
if (!isset($_SESSION['user_id']) || $_SESSION['user_nivel'] != 'admin') {
    header('Location: /login');
    exit();
}

require_once 'models/Banner.php';
$bannerModel = new Banner($db);

// Handle Delete
if (isset($_GET['delete'])) {
    $bannerModel->delete($_GET['delete']);
    header('Location: /admin?view=banners');
    exit();
}

$banners = $bannerModel->getAll();

$page_title = "Gerenciar Carrossel";
render_header();
?>

<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="w-64 bg-navy text-white hidden md:block">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-orange">Admin</h2>
        </div>
        <nav class="mt-6">
            <a href="/admin" class="block py-3 px-6 hover:bg-white/10 transition">Dashboard</a>
            <a href="/admin?view=courses" class="block py-3 px-6 hover:bg-white/10 transition">Cursos</a>
            <a href="/admin?view=blog" class="block py-3 px-6 hover:bg-white/10 transition">Blog</a>
            <a href="/admin?view=banners" class="block py-3 px-6 bg-orange text-white font-bold">Carrossel</a>
            <a href="/admin?view=comments" class="block py-3 px-6 hover:bg-white/10 transition">Comentários</a>
            <a href="/logout" class="block py-3 px-6 hover:bg-red-500 transition mt-10 text-red-300">Sair</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold text-navy">Gerenciar Carrossel</h1>
            <a href="/admin?view=banner_form"
                class="bg-orange text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:scale-105 transition">Novo
                Banner</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($banners as $b): ?>
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 group">
                    <div class="h-48 overflow-hidden bg-navy relative">
                        <img src="<?php echo $b['imagem']; ?>"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute top-4 right-4 flex space-x-2">
                            <a href="/admin?view=banner_form&id=<?php echo $b['id']; ?>"
                                class="bg-white/90 p-2 rounded-lg text-blue-600 hover:bg-blue-600 hover:text-white transition shadow">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </a>
                            <a href="/admin?view=banners&delete=<?php echo $b['id']; ?>"
                                onclick="return confirm('Excluir este banner?')"
                                class="bg-white/90 p-2 rounded-lg text-red-600 hover:bg-red-600 hover:text-white transition shadow">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </a>
                        </div>
                        <?php if ($b['status'] == 'inativo'): ?>
                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                <span
                                    class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold uppercase">Inativo</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-navy truncate">
                            <?php echo $b['titulo'] ?: 'Banner sem título'; ?>
                        </h3>
                        <p class="text-xs text-gray-400 mt-1">Ordem:
                            <?php echo $b['ordem']; ?>
                        </p>
                        <?php if ($b['link']): ?>
                            <p class="text-[10px] text-orange mt-2 truncate">
                                <?php echo $b['link']; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($banners)): ?>
            <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200">
                <p class="text-gray-400">Nenhum banner cadastrado ainda.</p>
                <a href="/admin?view=banner_form" class="text-orange font-bold mt-4 inline-block hover:underline">Adicionar
                    Primeiro</a>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php render_footer(); ?>