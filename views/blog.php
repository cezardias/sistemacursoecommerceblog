<?php
// views/blog.php
$page_title = "Blog - Aula Direta";
render_header();

require_once 'models/BlogPost.php';
$blogModel = new BlogPost($db);
$posts = $blogModel->readAll(true);
?>

<section class="bg-navy py-12">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl font-bold text-white mb-4">Blog Aula Direta</h1>
        <p class="text-gray-300">Notícias, dicas e novidades sobre educação e carreira.</p>
    </div>
</section>

<section class="py-16">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <?php while ($row = $posts->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 group">
                    <div class="h-48 overflow-hidden bg-gray-200">
                        <?php if ($row['imagem']): ?>
                            <img src="<?php echo $row['imagem']; ?>" alt="<?php echo $row['titulo']; ?>"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <?php else: ?>
                            <div class="flex items-center justify-center h-full text-gray-400 text-5xl">📰</div>
                        <?php endif; ?>
                    </div>
                    <div class="p-8">
                        <span class="text-xs font-bold text-orange uppercase tracking-widest mb-3 block">
                            <?php echo $row['categoria']; ?>
                        </span>
                        <h2 class="text-2xl font-bold text-navy mb-4 group-hover:text-orange transition">
                            <?php echo $row['titulo']; ?>
                        </h2>
                        <p class="text-gray-500 mb-6 line-clamp-3">
                            <?php echo strip_tags($row['conteudo']); ?>
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-400">
                                <?php echo date('d/m/Y', strtotime($row['created_at'])); ?>
                            </span>
                            <a href="/post?slug=<?php echo $row['slug']; ?>"
                                class="text-navy font-bold hover:text-orange flex items-center">
                                Ler mais
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <?php if ($posts->rowCount() == 0): ?>
            <div class="text-center py-20">
                <div class="text-6xl mb-6">🏜️</div>
                <h2 class="text-2xl font-bold text-navy">Ainda não temos matérias publicadas.</h2>
                <p class="text-gray-500 mt-2">Fique ligado, novidades em breve!</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php render_footer(); ?>