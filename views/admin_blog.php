<?php
// views/admin_blog.php
if (!isset($_SESSION['user_id']) || $_SESSION['user_nivel'] != 'admin') {
    header('Location: /login');
    exit();
}

require_once 'models/BlogPost.php';
$blogModel = new BlogPost($db);

// Handle Delete
if (isset($_GET['delete'])) {
    $blogModel->delete($_GET['delete']);
    header('Location: /admin?view=blog');
    exit();
}

$posts = $blogModel->readAll();

$page_title = "Gerenciar Blog";
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
            <a href="/admin?view=blog" class="block py-3 px-6 bg-orange text-white font-bold">Blog</a>
            <a href="/admin?view=comments" class="block py-3 px-6 hover:bg-white/10 transition">Comentários</a>
            <a href="/logout" class="block py-3 px-6 hover:bg-red-500 transition mt-10 text-red-300">Sair</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold text-navy">Postagens do Blog</h1>
            <a href="/admin?view=blog_form"
                class="bg-orange text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:scale-105 transition">Nova
                Matéria</a>
        </div>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-400 text-xs uppercase tracking-widest">
                        <th class="px-6 py-4 font-bold">Título</th>
                        <th class="px-6 py-4 font-bold">Categoria</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php while ($row = $posts->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-bold text-navy block">
                                    <?php echo $row['titulo']; ?>
                                </span>
                                <span class="text-xs text-gray-400">
                                    <?php echo date('d/m/y', strtotime($row['created_at'])); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">
                                    <?php echo $row['categoria']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($row['status'] == 'publicado'): ?>
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full uppercase">Publicado</span>
                                <?php else: ?>
                                    <span
                                        class="px-3 py-1 bg-yellow-100 text-yellow-700 text-[10px] font-bold rounded-full uppercase">Rascunho</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="/post?slug=<?php echo $row['slug']; ?>" target="_blank"
                                    class="text-gray-400 hover:text-navy transition">Ver</a>
                                <a href="/admin?view=blog_form&id=<?php echo $row['id']; ?>"
                                    class="text-blue-500 hover:underline font-bold">Editar</a>
                                <a href="/admin?view=blog&delete=<?php echo $row['id']; ?>"
                                    onclick="return confirm('Excluir esta matéria?')"
                                    class="text-red-500 hover:underline font-bold">Excluir</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php render_footer(); ?>