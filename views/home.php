<?php render_header(); ?>

<!-- Hero Section -->
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
                <a href="#"
                    class="border-2 border-white text-white px-8 py-4 rounded-full font-bold text-center hover:bg-white hover:text-navy transition">
                    Saiba Mais
                </a>
            </div>
        </div>
        <div class="md:w-1/2 mt-12 md:mt-0 relative">
            <div class="absolute -top-10 -right-10 w-64 h-64 bg-orange opacity-10 rounded-full blur-3xl"></div>
            <!-- Idealmente uma das imagens enviadas aqui -->
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                alt="Estudante" class="rounded-3xl shadow-2xl border-8 border-navy/50">
        </div>
    </div>
</section>

<!-- Courses Grid -->
<section id="cursos" class="py-24">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-navy mb-4">Explore as Nossas <span
                        class="text-orange">Especialidades</span></h2>
                <p class="text-gray-600 max-w-md">Os melhores investimentos para sua carreira profissional.</p>
            </div>
            <a href="#" class="text-navy font-bold hover:text-orange transition mt-4 md:mt-0 flex items-center">
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
                                <?php echo number_format($c['preco_vista'], 2, ',', '.'); ?></p>
                            <p class="text-orange font-medium text-sm">ou <?php echo $c['parcelas']; ?>x de R$
                                <?php echo number_format($c['preco_parcelado'] / $c['parcelas'], 2, ',', '.'); ?></p>
                        </div>
                        <a href="https://api.whatsapp.com/send?phone=5561999361189&text=Olá! Gostaria de me matricular no curso: <?php echo urlencode($c['titulo']); ?>"
                            target="_blank"
                            class="w-full bg-navy text-white py-3 rounded-xl font-bold hover:bg-orange transition block text-center">Matricule-se</a>
                    </div>
                </div>
            <?php endforeach; ?>
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