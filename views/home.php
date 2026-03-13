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
                <a href="#cursos"
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
                                <?php echo number_format($c['preco_vista'], 2, ',', '.'); ?>
                            </p>
                            <p class="text-orange font-medium text-sm">ou <?php echo $c['parcelas']; ?>x de R$
                                <?php echo number_format($c['preco_parcelado'] ?? 0, 2, ',', '.'); ?>
                            </p>
                        </div>
                        <a href="https://api.whatsapp.com/send?phone=5511964811689&text=Olá! Gostaria de me matricular no curso: <?php echo urlencode($c['titulo']); ?>"
                            target="_blank"
                            class="w-full bg-navy text-white py-3 rounded-xl font-bold hover:bg-orange transition flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12c0 2.17.7 4.19 1.94 5.86L2.83 22l4.27-1.13C8.61 21.57 10.25 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm3.11 14.5c-.19 0-.36-.02-.49-.06-.3-.09-.59-.2-.84-.33-.61-.31-1.17-.74-1.63-1.21-.47-.46-.9-1.02-1.21-1.63-.13-.25-.24-.54-.33-.84-.04-.13-.06-.3-.06-.49 0-.25.07-.47.21-.66.11-.15.26-.3.42-.42.06-.05.11-.09.16-.13.11-.09.19-.18.25-.26.06-.08.1-.17.13-.27.03-.1.05-.19.05-.28 0-.11-.02-.21-.06-.3-.04-.09-.12-.19-.24-.31L10.2 9.06c-.1-.1-.2-.17-.31-.22-.11-.05-.23-.07-.37-.07-.15 0-.29.02-.42.07-.14.05-.27.11-.38.19-.11.08-.21.18-.28.28-.07.1-.11.19-.13.27l-.02.09c-.06.28-.09.58-.09.89 0 .61.12 1.15.35 1.62.24.47.57.97.98 1.48.41.51.91 1.01 1.48 1.48.51.41 1.01.74 1.48.98.47.23 1.01.35 1.62.35.31 0 .61-.03.89-.09l.09-.02c.08-.02.17-.06.27-.13.1-.07.2-.17.28-.28.08-.11.14-.24.19-.38.05-.13.07-.27.07-.42 0-.14-.02-.26-.07-.37-.05-.11-.12-.21-.22-.31l-1.64-1.64c-.12-.12-.22-.2-.31-.24-.09-.04-.19-.06-.3-.06-.09 0-.18.02-.28.05-.1.03-.19.07-.27.13-.08.06-.17.14-.26.25-.04.05-.08.1-.13.16-.12.16-.27.31-.42.42-.19.14-.41.21-.66.21z" />
                            </svg>
                            <span>Matricule-se</span>
                        </a>
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