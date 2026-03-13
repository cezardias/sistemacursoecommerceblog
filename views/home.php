<?php render_header(); ?>

<!-- Hero Carousel -->
<?php if (!empty($banners)): ?>
    <section class="relative bg-navy py-6 md:py-10">
        <div class="container mx-auto px-6">
            <div class="swiper heroSwiper rounded-3xl overflow-hidden md:max-w-[75%] mx-auto shadow-2xl">
                <div class="swiper-wrapper">
                    <?php foreach ($banners as $b): ?>
                        <div class="swiper-slide relative aspect-[2/1] md:aspect-[3/1] w-full bg-navy">
                            <img src="<?php echo $b['imagem']; ?>" class="w-full h-full object-contain">
                            <?php if ($b['titulo'] || $b['link']): ?>
                                <div
                                    class="absolute inset-0 bg-navy/20 flex items-center">
                                    <div class="px-6 md:px-12">
                                        <div class="max-w-md text-white drop-shadow-2xl">
                                            <?php if ($b['titulo']): ?>
                                                <h2 class="text-lg md:text-3xl lg:text-4xl font-bold mb-2 md:mb-4 leading-tight">
                                                    <?php echo $b['titulo']; ?>
                                                </h2>
                                            <?php endif; ?>
                                            <?php if ($b['link']): ?>
                                                <a href="<?php echo $b['link']; ?>"
                                                    class="bg-orange text-white px-4 py-1.5 md:px-6 md:py-3 rounded-full font-bold inline-block hover:bg-white hover:text-navy transition shadow-lg text-[10px] md:text-sm">
                                                    Saiba Mais
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
                <!-- Add Navigation -->
                <div class="swiper-button-next !text-white opacity-40 hover:opacity-100 transition scale-75 !hidden md:!flex"></div>
                <div class="swiper-button-prev !text-white opacity-40 hover:opacity-100 transition scale-75 !hidden md:!flex"></div>
            </div>
        </div>
    </section>

    <script>     var swiper = new Swiper(".heroSwiper", {         loop: true,         autoplay: {             delay: 5000,             disableOnInteraction: false,         },         pagination: {             el: ".swiper-pagination",             clickable: true,         },         navigation: {             nextEl: ".swiper-button-next",             prevEl: ".swiper-button-prev",         },     });
    </script>

    <style>
        .swiper-pagination-bullet {
            background: #fff;
            opacity: 0.5;
        }

        .swiper-pagination-bullet-active {
            background: #F97316;
            opacity: 1;
        }
    </style>
<?php else: ?>
    <!-- Hero Section (Fallback) -->
    <section class="relative bg-navy overflow-hidden py-20">
        <div class="container mx-auto px-6 flex flex-col md:flex-row items-center relative z-10">
            <div class="md:w-1/2 text-white">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    O seu futuro <span class="text-orange underline">começa aqui.</span>
                </h1>
                <p class="text-xl text-gray-300 mb-10 max-w-lg">
                    Desenvolva competências estratégicas e transforme sua forma de liderar com os melhores cursos do
                    mercado.
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#cursos"
                        class="bg-orange text-white px-8 py-4 rounded-full font-bold text-center hover-bg-orange transition shadow-2xl flex items-center justify-center">
                        Ver Cursos <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </svg>
                    </a>
                    <a href="#cursos"
                        class="border-2 border-white text-white px-8 py-4 rounded-full font-bold text-center hover:bg-white hover:text-navy transition">
                        Saiba Mais
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 mt-12 md:mt-0 relative">
                <div class="absolute -top-10 -right-10 w-64 h-64 bg-orange opacity-10 rounded-full blur-3xl"></div>
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="Estudante" class="rounded-3xl shadow-2xl border-8 border-navy/50">
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Courses Grid -->
<section id="cursos" class="py-24">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-navy mb-4">Explore as Nossas <span
                        class="text-orange">Especialidades</span></h2>
                <p class="text-gray-600 max-w-md">Os melhores investimentos para sua carreira profissional.</p>
            </div>
            <a href="/index.php?url=cursos"
                class="text-navy font-bold hover:text-orange transition mt-4 md:mt-0 flex items-center">
                Ver Todos <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($courses as $c): ?>
                <div
                    class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 overflow-hidden border border-gray-100">
                    <div class="h-48 overflow-hidden bg-navy flex items-center justify-center">
                        <?php if ($c['imagem']): ?>
                            <img src="<?php echo $c['imagem']; ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="text-white text-6xl opacity-20">🎓</div>
                        <?php endif; ?>
                    </div>
                    <div class="p-6">
                        <span
                            class="text-xs font-bold uppercase tracking-wider text-orange mb-2 block"><?php echo $c['categoria']; ?></span>
                        <h3 class="text-xl font-bold text-navy mb-3"><?php echo $c['titulo']; ?></h3>
                        <p class="text-gray-500 text-sm mb-6 line-clamp-2"><?php echo $c['descricao']; ?></p>
                        <div class="mb-6">
                            <p class="text-gray-400 text-xs">À vista por:</p>
                            <p class="text-2xl font-bold text-navy">R$
                                <?php echo number_format($c['preco_vista'], 2, ',', '.'); ?>
                            </p>
                            <p class="text-orange font-medium text-sm">ou <?php echo $c['parcelas']; ?>x de R$
                                <?php echo number_format($c['preco_parcelado'] ?? 0, 2, ',', '.'); ?>
                            </p>
                        </div>
                        <a href="https://api.whatsapp.com/send?phone=5511964811689&text=Olá! Gostaria de me matricular no curso: <?php echo urlencode($c['titulo']); ?>"
                            target="_blank"
                            class="w-full bg-navy text-white py-3 rounded-full font-bold hover:bg-orange transition flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.801.981 3.824 1.499 5.888 1.5h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                            </svg>
                            <span>Matricule-se</span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="py-24 bg-gray-50 border-t border-gray-100">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-navy mb-4">Últimas do <span
                        class="text-orange">Blog</span></h2>
                <p class="text-gray-600 max-w-md">Fique por dentro das novidades e dicas de carreira.</p>
            </div>
            <a href="/index.php?url=blog"
                class="bg-navy text-white px-6 py-2 rounded-full font-bold hover:bg-orange transition mt-4 md:mt-0 flex items-center shadow-lg">
                Ir para o Blog <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </a>
        </div>

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
    </div>
</section>

<!-- Trust Banner -->
<section class="bg-navy py-12">
    <div class="container mx-auto px-6 flex flex-wrap justify-around items-center gap-8 opacity-80">
        <div class="flex items-center space-x-3 text-white">
            <svg class="w-10 h-10 text-orange" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z">
                </path>
            </svg>
            <span class="font-bold">Certificado MEC</span>
        </div>
        <div class="flex items-center space-x-3 text-white">
            <svg class="w-10 h-10 text-orange" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z">
                </path>
            </svg>
            <span class="font-bold">Qualidade Certificada</span>
        </div>
        <div class="flex items-center space-x-3 text-white">
            <svg class="w-10 h-10 text-orange" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z">
                </path>
            </svg>
            <span class="font-bold">Suporte Individual</span>
        </div>
    </div>
</section>

<?php render_footer(); ?>