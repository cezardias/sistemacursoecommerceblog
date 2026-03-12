<?php
$page_title = "Dashboard Admin";
render_header();

// Fetch metrics (simulated for now)
$query_users = "SELECT COUNT(*) as total FROM usuarios";
$stmt_users = $db->query($query_users);
$total_users = $stmt_users->fetch(PDO::FETCH_ASSOC)['total'];

$query_vendas = "SELECT COUNT(*) as total, SUM(total) as revenue FROM pedidos WHERE status = 'pago'";
$stmt_vendas = $db->query($query_vendas);
$vendas_data = $stmt_vendas->fetch(PDO::FETCH_ASSOC);
$total_vendas = $vendas_data['total'] ?? 0;
$total_revenue = $vendas_data['revenue'] ?? 0;

$query_cursos_list = "SELECT * FROM cursos LIMIT 5";
$stmt_cursos = $db->query($query_cursos_list);
$recent_cursos = $stmt_cursos->fetchAll(PDO::FETCH_ASSOC);

// Blog Metrics
$query_posts = "SELECT COUNT(*) as total FROM blog_posts";
$total_posts = $db->query($query_posts)->fetch(PDO::FETCH_ASSOC)['total'];

$query_pendente = "SELECT COUNT(*) as total FROM comentarios WHERE status = 'pendente'";
$pendente_comments = $db->query($query_pendente)->fetch(PDO::FETCH_ASSOC)['total'];
?>

<div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-6 py-10">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-bold text-navy">Olá,
                    <?php echo $_SESSION['user_nome']; ?>!
                </h1>
                <p class="text-gray-500">Bem-vindo ao painel administrativo da Aula Direta.</p>
            </div>
            <div class="flex space-x-4">
                <a href="/index.php?url=admin&view=blog"
                    class="bg-navy text-white px-6 py-2 rounded-xl font-bold hover:bg-orange transition shadow-lg">Gerenciar
                    Blog</a>
                <a href="/index.php?url=admin&view=comments"
                    class="bg-white text-navy px-6 py-2 rounded-xl border border-gray-200 font-bold hover:bg-gray-50 transition relative">
                    Comentários
                    <?php if ($pendente_comments > 0): ?>
                        <span
                            class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] w-5 h-5 flex items-center justify-center rounded-full"><?php echo $pendente_comments; ?></span>
                    <?php endif; ?>
                </a>
            </div>
        </div>

        <!-- Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-400 font-bold text-sm uppercase tracking-wider">Total de Alunos</span>
                    <div class="bg-blue-100 p-2 rounded-lg text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                                stroke-width="2"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-4xl font-extrabold text-navy">
                    <?php echo $total_users; ?>
                </h3>
                <div class="mt-4 flex items-center text-green-500 text-sm">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z">
                        </path>
                    </svg>
                    <span>12.5% vs mês anterior</span>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-400 font-bold text-sm uppercase tracking-wider">Vendas Concluídas</span>
                    <div class="bg-green-100 p-2 rounded-lg text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="2"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-4xl font-extrabold text-navy">
                    <?php echo $total_vendas; ?>
                </h3>
                <p class="mt-4 text-gray-500 text-sm italic">Faturamento: R$
                    <?php echo number_format($total_revenue, 2, ',', '.'); ?>
                </p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-400 font-bold text-sm uppercase tracking-wider">Engajamento Blog</span>
                    <div class="bg-orange/10 p-2 rounded-lg text-orange">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"
                                stroke-width="2"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-4xl font-extrabold text-navy"><?php echo $total_posts; ?></h3>
                <p class="mt-4 text-gray-500 text-sm"><?php echo $pendente_comments; ?> novos comentários para moderar
                </p>
            </div>
        </div>

        <!-- Recent Courses Table -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-navy">Gerenciar Cursos</h2>
                <a href="/index.php?url=admin&view=courses" class="text-sm font-bold text-orange hover:underline">Ver
                    Tabela Completa</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-400 text-xs uppercase font-bold">
                        <tr>
                            <th class="px-8 py-4">Curso</th>
                            <th class="px-8 py-4">Categoria</th>
                            <th class="px-8 py-4">Preço (Vista)</th>
                            <th class="px-8 py-4">Status</th>
                            <th class="px-8 py-4 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($recent_cursos as $curso): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-8 py-6 font-bold text-navy">
                                    <?php echo $curso['titulo']; ?>
                                </td>
                                <td class="px-8 py-6 text-gray-500"><span
                                        class="bg-gray-100 px-3 py-1 rounded-full text-xs">
                                        <?php echo $curso['categoria']; ?>
                                    </span></td>
                                <td class="px-8 py-6 text-navy font-medium">R$
                                    <?php echo number_format($curso['preco_vista'], 2, ',', '.'); ?>
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="w-2 h-2 rounded-full <?php echo ($curso['status'] ?? 'ativo') == 'ativo' ? 'bg-green-500' : 'bg-red-500'; ?>">
                                        </div>
                                        <span
                                            class="text-sm font-bold <?php echo ($curso['status'] ?? 'ativo') == 'ativo' ? 'text-green-600' : 'text-red-600'; ?>">
                                            <?php echo ucfirst($curso['status'] ?? 'Ativo'); ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex justify-center space-x-4">
                                        <a href="/index.php?url=admin&view=course_form&id=<?php echo $curso['id']; ?>"
                                            class="text-gray-400 hover:text-navy transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                                    stroke-width="2"></path>
                                            </svg>
                                        </a>
                                        <a href="/index.php?url=admin&view=courses&delete=<?php echo $curso['id']; ?>"
                                            onclick="return confirm('Tem certeza?')"
                                            class="text-gray-400 hover:text-red-500 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                    stroke-width="2"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php render_footer(); ?>