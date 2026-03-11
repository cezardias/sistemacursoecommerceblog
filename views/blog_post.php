<?php
// views/blog_post.php
require_once 'models/BlogPost.php';
require_once 'models/Comment.php';

$blogModel = new BlogPost($db);
$commentModel = new Comment($db);

$post = $blogModel->readOneBySlug($_GET['slug']);

if (!$post || ($post['status'] != 'publicado' && (!isset($_SESSION['user_nivel']) || $_SESSION['user_nivel'] != 'admin'))) {
    header('Location: /blog');
    exit();
}

$page_title = $post['titulo'];
render_header();

// Handle Comment Submission
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comentario']) && isset($_SESSION['user_id'])) {
    $commentModel->post_id = $post['id'];
    $commentModel->usuario_id = $_SESSION['user_id'];
    $commentModel->comentario = $_POST['comentario'];
    if ($commentModel->create()) {
        $msg = "Seu comentário foi enviado para moderação e aparecerá em breve!";
    }
}

$comments = $commentModel->readByPost($post['id']);
?>

<div class="bg-white">
    <!-- Post Header -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6 max-w-4xl">
            <span class="text-orange font-bold uppercase tracking-widest text-sm mb-4 block">
                <?php echo $post['categoria']; ?>
            </span>
            <h1 class="text-4xl md:text-5xl font-bold text-navy mb-6 leading-tight">
                <?php echo $post['titulo']; ?>
            </h1>
            <div class="flex items-center text-gray-400 text-sm">
                <span class="font-bold text-navy">
                    <?php echo $post['autor_nome']; ?>
                </span>
                <span class="mx-3">•</span>
                <span>
                    <?php echo date('d/m/Y', strtotime($post['created_at'])); ?>
                </span>
            </div>
        </div>
    </section>

    <!-- Post Content -->
    <article class="py-16">
        <div class="container mx-auto px-6 max-w-4xl">
            <?php if ($post['imagem']): ?>
                <img src="<?php echo $post['imagem']; ?>" class="w-full rounded-3xl shadow-2xl mb-12"
                    alt="<?php echo $post['titulo']; ?>">
            <?php endif; ?>

            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                <?php echo nl2br($post['conteudo']); ?>
            </div>

            <hr class="my-16 border-gray-100">

            <!-- Comments Section -->
            <div id="comments">
                <h3 class="text-3xl font-bold text-navy mb-10">Comentários (
                    <?php echo $comments->rowCount(); ?>)
                </h3>

                <?php if ($msg): ?>
                    <div class="bg-green-50 text-green-700 p-6 rounded-2xl mb-10 italic border border-green-100 text-sm">
                        <?php echo $msg; ?>
                    </div>
                <?php endif; ?>

                <div class="space-y-8 mb-16">
                    <?php while ($c = $comments->fetch(PDO::FETCH_ASSOC)): ?>
                        <div class="bg-gray-50 p-8 rounded-3xl border border-gray-100">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-bold text-navy">
                                        <?php echo $c['usuario_nome']; ?>
                                    </h4>
                                    <span class="text-xs text-gray-400">
                                        <?php echo date('d/m/Y H:i', strtotime($c['created_at'])); ?>
                                    </span>
                                </div>
                            </div>
                            <p class="text-gray-600">
                                <?php echo nl2br($c['comentario']); ?>
                            </p>

                            <?php if ($c['resposta_admin']): ?>
                                <div class="mt-6 ml-6 p-6 bg-white rounded-2xl border-l-4 border-orange">
                                    <h5 class="text-sm font-bold text-orange mb-2">Resposta do Admin</h5>
                                    <p class="text-gray-600 text-sm">
                                        <?php echo nl2br($c['resposta_admin']); ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Comment Form -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="bg-navy p-10 rounded-3xl shadow-2xl text-white">
                        <h4 class="text-2xl font-bold mb-6">Deixe seu comentário</h4>
                        <form action="/post?slug=<?php echo $post['slug']; ?>#comments" method="POST">
                            <textarea name="comentario" required rows="4"
                                class="w-full bg-navy/50 border border-white/20 rounded-2xl p-4 text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-orange mb-6"
                                placeholder="Escreva aqui seu comentário..."></textarea>
                            <button type="submit"
                                class="bg-orange text-white px-8 py-4 rounded-full font-bold hover:bg-white hover:text-navy transition shadow-lg">Enviar
                                Comentário</button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12 bg-gray-50 rounded-3xl border border-dashed border-gray-300">
                        <p class="text-gray-500">Você precisa estar <a href="/login"
                                class="text-orange font-bold underline">logado</a> para comentar.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </article>
</div>

<?php render_footer(); ?>