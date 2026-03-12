<?php
// views/politica_privacidade.php
$page_title = "Política de Privacidade";
render_header();
?>

<div class="bg-white">
    <!-- Hero Section -->
    <section class="py-20 bg-navy text-white text-center">
        <div class="container mx-auto px-6 max-w-4xl">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Política de Privacidade</h1>
            <p class="text-xl text-gray-300">Como cuidamos dos seus dados na Aula Direta.</p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-24">
        <div class="container mx-auto px-6 max-w-4xl">
            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed space-y-12">

                <div class="space-y-4">
                    <h2 class="text-2xl font-bold text-navy border-b-2 border-orange pb-2 inline-block">1. Compromisso
                        com a Privacidade</h2>
                    <p>A Aula Direta respeita a privacidade de seus usuários e está comprometida em proteger os dados
                        pessoais coletados durante o uso do site. Esta política explica como as informações são
                        coletadas, utilizadas e protegidas.</p>
                </div>

                <div class="space-y-4">
                    <h2 class="text-2xl font-bold text-navy border-b-2 border-orange pb-2 inline-block">2. Dados
                        Coletados</h2>
                    <p>Podemos coletar as seguintes informações:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Nome completo</li>
                        <li>CPF ou documento de identificação</li>
                        <li>E-mail</li>
                        <li>Telefone</li>
                        <li>Endereço</li>
                        <li>Informações de pagamento</li>
                        <li>Dados de navegação no site</li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <h2 class="text-2xl font-bold text-navy border-b-2 border-orange pb-2 inline-block">3. Finalidade do
                        Uso dos Dados</h2>
                    <p>Os dados coletados podem ser utilizados para:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Realizar matrículas em cursos</li>
                        <li>Intermediar comunicação com instituições de ensino parceiras</li>
                        <li>Prestar suporte ao aluno</li>
                        <li>Enviar informações sobre cursos e oportunidades educacionais</li>
                        <li>Melhorar a experiência do usuário no site</li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <h2 class="text-2xl font-bold text-navy border-b-2 border-orange pb-2 inline-block">4.
                        Compartilhamento de Dados</h2>
                    <p>Os dados pessoais poderão ser compartilhados com:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Instituições de ensino parceiras responsáveis pelos cursos</li>
                        <li>Plataformas de pagamento</li>
                        <li>Ferramentas tecnológicas utilizadas para gestão educacional</li>
                    </ul>
                    <p class="font-semibold italic">Sempre respeitando a legislação vigente.</p>
                </div>

                <div class="space-y-4">
                    <h2 class="text-2xl font-bold text-navy border-b-2 border-orange pb-2 inline-block">5. Armazenamento
                        e Segurança</h2>
                    <p>A Aula Direta adota medidas técnicas e administrativas para proteger os dados pessoais contra
                        acesso não autorizado, perda ou uso indevido.</p>
                </div>

                <div class="space-y-4">
                    <h2 class="text-2xl font-bold text-navy border-b-2 border-orange pb-2 inline-block">6. Direitos do
                        Usuário</h2>
                    <p>De acordo com a Lei Geral de Proteção de Dados (LGPD), o usuário tem direito a:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Acessar seus dados pessoais</li>
                        <li>Solicitar correção de informações</li>
                        <li>Solicitar exclusão de dados</li>
                        <li>Revogar consentimento de uso de dados</li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <h2 class="text-2xl font-bold text-navy border-b-2 border-orange pb-2 inline-block">7. Uso de
                        Cookies</h2>
                    <p>O site pode utilizar cookies para melhorar a experiência de navegação e personalizar conteúdos. O
                        usuário pode desativar cookies nas configurações de seu navegador.</p>
                </div>

                <div class="space-y-4">
                    <h2 class="text-2xl font-bold text-navy border-b-2 border-orange pb-2 inline-block">8. Atualizações
                        desta Política</h2>
                    <p>Esta Política de Privacidade pode ser atualizada periodicamente para atender alterações legais ou
                        melhorias nos serviços.</p>
                </div>

                <div class="space-y-6 pt-10">
                    <h2 class="text-2xl font-bold text-navy border-b-2 border-orange pb-2 inline-block">9. Contato</h2>
                    <p>Em caso de dúvidas sobre esta política ou sobre o uso de dados pessoais, o usuário poderá entrar
                        em contato pelos canais oficiais da Aula Direta.</p>

                    <div class="bg-gray-50 p-8 rounded-3xl border border-gray-100 text-center">
                        <h3 class="text-2xl font-bold text-navy mb-2">Aula Direta</h3>
                        <p class="text-orange font-bold uppercase tracking-wider">Transparência e segurança para sua
                            educação.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php render_footer(); ?>