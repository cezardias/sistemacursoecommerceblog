<?php
// views/admin_comments.php
if (!isset($_SESSION['user_id']) || $_SESSION['user_nivel'] != 'admin') {
    header('Location: /login');
    exit();
}

require_once 'models/Comment.php';
require_once 'models/User.php';
$commentModel = new Comment($db);
$userModel = new User($db);

// Handle Actions
if (isset($_GET['approve'])) {
    $commentModel->updateStatus($_GET['approve'], 'aprovado');
    header('Location: /admin?view=comments');
    exit();
}
if (isset($_GET['delete'])) {
    $commentModel->delete($_GET['delete']);
    header('Location: /admin?view=comments');
    exit();
}
if (isset($_GET['block'])) {
    $userModel->updateStatus($_GET['block'], 'bloqueado');
    header('Location: /admin?view=comments');
    exit();
}

// Handle Reply
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment_id']) && isset($_POST['resposta'])) {
    $commentModel->reply($_POST['comment_id'], $_POST['resposta']);
    header('Location: /admin?view=comments');
    exit();
}

$comments = $commentModel->readAll();

$page_title = "Moderar Comentários";
render_header();
?>

<div class="flex min-h-screen bg-gray-50 text-navy">
    <aside class="w-64 bg-navy text-white hidden md:block">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-orange">Admin</h2>
        </div>
        <nav class="mt-6">
            <a href="/admin" class="block py-3 px-6 hover:bg-white/10 transition">Dashboard</a>
            <a href="/admin?view=blog" class="block py-3 px-6 hover:bg-white/10 transition">Blog</a>
            <a href="/admin?view=comments" class="block py-3 px-6 bg-orange text-white font-bold">Comentários</a>
            <a href="/logout" class="block py-3 px-6 hover:bg-red-500 transition mt-10 text-red-300">Sair</a>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold mb-10">Gerenciar Comentários</h1>

        <div class="space-y-6">
            <?php while ($c = $comments->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                    <div class="flex flex-col md:flex-row justify-between mb-6">
                        <div>
                            <span class="text-xs font-bold text-orange uppercase tracking-widest block mb-1">
                                <?php echo $c['post_titulo']; ?>
                            </span>
                            <h4 class="text-lg font-bold">
                                <?php echo $c['usuario_nome']; ?>
                            </h4>
                            <span class="text-xs text-gray-400">
                                <?php echo date('d/m/Y H:i', strtotime($c['created_at'])); ?>
                            </span>
                        </div>
                        <div class="flex space-x-2 mt-4 md:mt-0">
                            <?php if ($c['status'] == 'pendente'): ?>
                                <a href="/admin?view=comments&approve=<?php echo $c['id']; ?>"
                                    class="bg-green-500 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-green-600 transition">Aprovar</a>
                            <?php endif; ?>
                            <a href="/admin?view=comments&delete=<?php echo $c['id']; ?>"
                                onclick="return confirm('Excluir?')"
                                class="bg-red-50 text-red-500 px-4 py-2 rounded-xl text-xs font-bold hover:bg-red-500 hover:text-white transition">Excluir</a>
                            <a href="/admin?view=comments&block=<?php echo $c['usuario_id']; ?>"
                                onclick="return confirm('Bloquear este usuário?')"
                                class="bg-gray-100 text-gray-600 px-4 py-2 rounded-xl text-xs font-bold hover:bg-navy hover:text-white transition">Bloquear
                                Usuário</a>
                        </div>
                    </div>

                    <p class="text-gray-700 bg-gray-50 p-6 rounded-2xl border border-gray-100 italic">"
                        <?php echo $c['comentario']; ?>"
                    </p>

                    <?php if (isset($c['resposta_admin']) && $c['resposta_admin']): ?>
                        <div class="mt-4 p-4 bg-orange/5 border-l-4 border-orange rounded-r-xl">
                            <span class="text-[10px] font-bold text-orange uppercase block mb-1">Sua Resposta:</span>
                            <p class="text-sm text-gray-600">
                                <?php echo $c['resposta_admin']; ?>
                            </p>
                        </div>
                    <?php else: ?>
                        <form method="POST" class="mt-6 flex space-x-2">
                            <input type="hidden" name="comment_id" value="<?php echo $c['id']; ?>">
                            <input type="text" name="resposta" placeholder="Responder comentário..." required
                                class="flex-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange">
                            <button type="submit"
                                class="bg-navy text-white px-6 py-3 rounded-xl font-bold text-xs hover:bg-orange transition uppercase tracking-widest">Responder</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>

            <?php if ($comments->rowCount() == 0): ?>
                <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200">
                    <p class="text-gray-400">Nenhum comentário por enquanto.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php render_footer(); ?>