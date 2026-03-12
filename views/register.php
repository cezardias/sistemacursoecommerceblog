<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha'])) {
    require_once 'models/User.php';
    $userModel = new User($db);

    if ($userModel->register($_POST['nome'], $_POST['email'], $_POST['senha'])) {
        $success = "Conta criada com sucesso! Você já pode entrar.";
    } else {
        $error = "Erro ao criar conta. O e-mail já pode estar em uso.";
    }
}

$page_title = "Criar Conta";
render_header();
?>

<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-3xl shadow-2xl border border-gray-100">
        <div>
            <div class="mx-auto h-16 w-16 bg-orange rounded-2xl flex items-center justify-center mb-6">
                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
            <h2 class="text-center text-3xl font-extrabold text-navy">Crie sua conta</h2>
            <p class="mt-2 text-center text-sm text-gray-500">Junte-se à comunidade Aula Direta</p>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-50 text-red-700 p-4 rounded-xl text-sm border border-red-100 italic">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-green-50 text-green-700 p-4 rounded-xl text-sm border border-green-100 italic">
                <?php echo $success; ?>
                <a href="/index.php?url=login" class="block mt-2 font-bold underline">Clique aqui para entrar</a>
            </div>
        <?php else: ?>
            <form class="mt-8 space-y-6" action="/index.php?url=register" method="POST">
                <div class="space-y-4">
                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo</label>
                        <input id="nome" name="nome" type="text" required
                            class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-orange focus:border-orange sm:text-sm"
                            placeholder="Ex: João Silva">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                        <input id="email" name="email" type="email" required
                            class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-orange focus:border-orange sm:text-sm"
                            placeholder="seu@email.com">
                    </div>
                    <div>
                        <label for="senha" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                        <input id="senha" name="senha" type="password" required
                            class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-orange focus:border-orange sm:text-sm"
                            placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-4 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-navy hover-bg-navy focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy transition shadow-lg">
                        Criar minha conta
                    </button>
                </div>
            </form>
        <?php endif; ?>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-500">Já possui conta? <a href="/index.php?url=login"
                    class="font-bold text-orange underline">Entrar</a></p>
        </div>
    </div>
</div>

<?php render_footer(); ?>