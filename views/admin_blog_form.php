<?php
// views/admin_blog_form.php
if (!isset($_SESSION['user_id']) || $_SESSION['user_nivel'] != 'admin') {
    header('Location: /login');
    exit();
}

require_once 'models/BlogPost.php';
$blogModel = new BlogPost($db);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$post = null;

if ($id) {
    $query = "SELECT * FROM blog_posts WHERE id = ? LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->execute([$id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blogModel->id = $id;
    $blogModel->titulo = $_POST['titulo'];
    $blogModel->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['titulo'])));
    $blogModel->conteudo = $_POST['conteudo'];
    $blogModel->categoria = $_POST['categoria'];
    $blogModel->status = $_POST['status'];
    $blogModel->autor_id = $_SESSION['user_id'];
    $blogModel->imagem = $_POST['imagem']; // Simple text field for now

    if ($id) {
        $blogModel->update();
    } else {
        $blogModel->create();
    }
    header('Location: /admin?view=blog');
    exit();
}

$page_title = $id ? "Editar Matéria" : "Nova Matéria";
render_header();
?>

<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar logic here simplifies to keeping the view consistent -->
    <main class="flex-1 p-8 max-w-4xl mx-auto">
        <a href="/admin?view=blog" class="text-navy hover:text-orange flex items-center mb-8 font-bold">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            Voltar
        </a>

        <h1 class="text-3xl font-bold text-navy mb-10">
            <?php echo $page_title; ?>
        </h1>

        <form method="POST" class="bg-white p-10 rounded-3xl shadow-xl border border-gray-100 space-y-8">
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Título da
                    Matéria</label>
                <input type="text" name="titulo" required value="<?php echo $post ? $post['titulo'] : ''; ?>"
                    class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-navy focus:outline-none focus:ring-2 focus:ring-orange">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label
                        class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Categoria</label>
                    <input type="text" name="categoria" required value="<?php echo $post ? $post['categoria'] : ''; ?>"
                        class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-navy focus:outline-none focus:ring-2 focus:ring-orange"
                        placeholder="Dicas, Carreira, etc.">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Status</label>
                    <select name="status"
                        class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-navy focus:outline-none focus:ring-2 focus:ring-orange">
                        <option value="rascunho" <?php echo ($post && $post['status'] == 'rascunho') ? 'selected' : ''; ?>>Rascunho</option>
                        <option value="publicado" <?php echo ($post && $post['status'] == 'publicado') ? 'selected' : ''; ?>>Publicado</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">URL da
                    Imagem</label>
                <input type="text" name="imagem" value="<?php echo $post ? $post['imagem'] : ''; ?>"
                    class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-navy focus:outline-none focus:ring-2 focus:ring-orange"
                    placeholder="https://exemplo.com/imagem.jpg">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Conteúdo da
                    Matéria</label>
                <textarea name="conteudo" required rows="12"
                    class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-6 text-navy focus:outline-none focus:ring-2 focus:ring-orange"><?php echo $post ? $post['conteudo'] : ''; ?></textarea>
            </div>

            <button type="submit"
                class="w-full bg-navy text-white py-5 rounded-2xl font-bold text-lg hover:bg-orange transition shadow-xl mt-4 italic">Salvar
                e Atualizar Blog</button>
        </form>
    </main>
</div>

<?php render_footer(); ?>