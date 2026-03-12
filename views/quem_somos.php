<?php
// views/quem_somos.php
$page_title = "Quem Somos";
render_header();
?>

<div class="bg-white">
    <!-- Hero Section -->
    <section class="py-20 bg-navy text-white text-center">
        <div class="container mx-auto px-6 max-w-4xl">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Quem Somos</h1>
            <p class="text-xl text-gray-300">Conheça a história e o propósito da Aula Direta.</p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-24">
        <div class="container mx-auto px-6 max-w-4xl">
            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed space-y-8">
                <p class="text-2xl font-semibold text-navy">
                    A Aula Direta nasceu com o propósito de transformar vidas por meio da educação.
                </p>

                <p>
                    Acreditamos que o conhecimento é uma das ferramentas mais poderosas para gerar oportunidades,
                    promover crescimento profissional e construir um futuro melhor.
                </p>

                <p>
                    Atuamos como conectores de pessoas a cursos técnicos, profissionalizantes e programas educacionais
                    reconhecidos, oferecendo acesso a formações que realmente fazem diferença no mercado de trabalho.
                </p>

                <p>
                    Nosso objetivo é tornar a educação mais acessível, prática e alinhada às demandas profissionais
                    atuais.
                </p>

                <div class="bg-gray-50 p-8 rounded-3xl border border-gray-100 my-12">
                    <p class="italic text-navy">
                        "Na Aula Direta, cada aluno é protagonista da própria história. Por isso, buscamos oferecer
                        orientação, suporte e caminhos que facilitem o acesso ao aprendizado de qualidade, ajudando
                        nossos estudantes a desenvolver habilidades, ampliar suas oportunidades e conquistar novos
                        espaços no mercado."
                    </p>
                </div>

                <p>
                    Acreditamos na educação como motor de transformação social e profissional. Por isso, trabalhamos
                    para aproximar nossos alunos de instituições de ensino reconhecidas, garantindo acesso a programas
                    educacionais que combinam flexibilidade, qualidade e foco no desenvolvimento de carreira.
                </p>

                <p>
                    Mais do que oferecer cursos, a Aula Direta existe para incentivar pessoas a acreditarem no próprio
                    potencial e investirem no seu crescimento.
                </p>

                <div class="pt-8 border-t border-gray-100 text-center">
                    <h2 class="text-3xl font-bold text-navy mb-4">Aula Direta</h2>
                    <p class="text-orange font-bold text-xl uppercase tracking-widest">Educação que abre caminhos para o
                        futuro.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Visual Banner -->
    <section class="py-12 bg-gray-50 mb-12">
        <div class="container mx-auto px-6 flex flex-wrap justify-around items-center gap-8">
            <div class="flex flex-col items-center">
                <span class="text-4xl mb-2">🚀</span>
                <span class="font-bold text-navy">Crescimento</span>
            </div>
            <div class="flex flex-col items-center">
                <span class="text-4xl mb-2">🎓</span>
                <span class="font-bold text-navy">Formação</span>
            </div>
            <div class="flex flex-col items-center">
                <span class="text-4xl mb-2">🤝</span>
                <span class="font-bold text-navy">Suporte</span>
            </div>
        </div>
    </section>
</div>

<?php render_footer(); ?>