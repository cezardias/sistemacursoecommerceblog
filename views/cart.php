<?php
$page_title = "Seu Carrinho";
render_header();

include_once 'controllers/CartController.php';
$cart = new CartController();
$cart_items = $_SESSION['cart'] ?? [];
$total = $cart->getTotal();
?>

<div class="bg-gray-50 min-h-[70vh] py-16">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl font-bold text-navy mb-10">Carrinho de <span class="text-orange">Matrícula</span></h1>

        <?php if (empty($cart_items)): ?>
            <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-gray-100">
                <div class="text-6xl mb-6">🛒</div>
                <h2 class="text-2xl font-bold text-navy mb-4">Seu carrinho está vazio</h2>
                <p class="text-gray-500 mb-8">Parece que você ainda não escolheu seu próximo passo profissional.</p>
                <a href="/home#cursos"
                    class="bg-navy text-white px-8 py-4 rounded-full font-bold hover-bg-navy transition inline-block shadow-lg">Descobrir
                    Cursos</a>
            </div>
        <?php else: ?>
            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Items List -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-gray-400 text-xs uppercase font-bold">
                                <tr>
                                    <th class="px-8 py-4">Curso</th>
                                    <th class="px-8 py-4 text-right">Preço</th>
                                    <th class="px-8 py-4 text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach ($cart_items as $item): ?>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-8 py-6">
                                            <span class="font-bold text-navy text-lg">
                                                <?php echo $item['title']; ?>
                                            </span>
                                            <p class="text-gray-400 text-sm">Acesso vitalício ao conteúdo</p>
                                        </td>
                                        <td class="px-8 py-6 text-right font-bold text-navy">
                                            R$
                                            <?php echo number_format($item['price'], 2, ',', '.'); ?>
                                        </td>
                                        <td class="px-8 py-6 text-center">
                                            <a href="/remove-cart?id=<?php echo $item['id']; ?>"
                                                class="text-gray-300 hover:text-red-500 transition">
                                                <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                        stroke-width="2"></path>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Summary Card -->
                <div class="lg:w-1/3">
                    <div class="bg-navy text-white rounded-3xl p-8 shadow-2xl sticky top-24">
                        <h3 class="text-xl font-bold mb-8 border-b border-white/10 pb-4">Resumo da Ordem</h3>
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-gray-400">Subtotal</span>
                            <span class="font-medium">R$
                                <?php echo number_format($total, 2, ',', '.'); ?>
                            </span>
                        </div>
                        <div class="flex justify-between items-center mb-10 text-xl font-bold">
                            <span>Total</span>
                            <span class="text-orange">R$
                                <?php echo number_format($total, 2, ',', '.'); ?>
                            </span>
                        </div>

                        <a href="/checkout"
                            class="w-full bg-orange text-white py-4 rounded-xl font-bold hover:bg-white hover:text-navy transition shadow-lg text-center block mb-6">
                            Finalizar Matrícula
                        </a>

                        <p class="text-xs text-center text-gray-400">
                            Ao prosseguir, você concorda com nossos termos de uso e política de privacidade.
                        </p>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="mt-6 bg-red-500/20 text-red-200 p-4 rounded-xl text-xs text-center italic">
                                <?php echo $_SESSION['error'];
                                unset($_SESSION['error']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php render_footer(); ?>