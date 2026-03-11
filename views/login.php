<?php
$page_title = "Entrar";
render_header();

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email']) && isset($_POST['senha'])) {
    require_once 'models/User.php';
    $userModel = new User($db);

    $result = $userModel->login($_POST['email'], $_POST['senha']);
    if (is_array($result)) {
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['user_nome'] = $result['nome'];
        $_SESSION['user_nivel'] = $result['nivel'];

        header('Location: /index.php?url=admin');
        exit();
    } elseif (is_string($result)) {
        $error = $result;
    } else {
        $error = "Credenciais inválidas.";
    }
}
?>

<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-3xl shadow-2xl border border-gray-100">
        <div>
            <div class="mx-auto h-16 w-16 bg-navy rounded-2xl flex items-center justify-center mb-6">
                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
            </div>
            <h2 class="text-center text-3xl font-extrabold text-navy">Acesse sua conta</h2>
            <p class="mt-2 text-center text-sm text-gray-500">
                Portal Aula Direta
            </p>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-50 text-red-700 p-4 rounded-xl text-sm border border-red-100 italic">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form class="mt-8 space-y-6" action="/login" method="POST">
            <div class="rounded-md shadow-sm -space-y-px">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail / Login</label>
                    <input id="email" name="email" type="text" required
                        class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-orange focus:border-orange focus:z-10 sm:text-sm"
                        placeholder="Seu e-mail">
                </div>
                <div>
                    <label for="senha" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                    <input id="senha" name="senha" type="password" required
                        class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-orange focus:border-orange focus:z-10 sm:text-sm"
                        placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox"
                        class="h-4 w-4 text-orange focus:ring-orange border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                        Lembrar-me
                    </label>
                </div>

                <div class="text-sm">
                    <a href="#" class="font-medium text-orange hover:text-navy">
                        Esqueceu sua senha?
                    </a>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-navy hover-bg-navy focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy transition shadow-lg">
                    Entrar no Portal
                </button>
            </div>
        </form>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-500">Ainda não tem conta? <a href="/register"
                    class="font-bold text-orange underline">Cadastre-se</a></p>
        </div>
    </div>
</div>

<?php render_footer(); ?>