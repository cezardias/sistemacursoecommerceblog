<?php
// views/admin_courses.php
require_once 'models/Course.php';
$courseModel = new Course($db);

// Handle Delete
if (isset($_GET['delete'])) {
    if ($courseModel->delete($_GET['delete'])) {
        $_SESSION['msg'] = "Curso excluído com sucesso!";
    } else {
        $_SESSION['error'] = "Erro ao excluir curso.";
    }
    session_write_close();
    header('Location: ' . $base_url . 'admin&view=courses');
    exit();
}

if (isset($_GET['toggle_status'])) {
    if ($courseModel->toggleStatus($_GET['toggle_status'])) {
        $_SESSION['msg'] = "Status do curso alterado!";
    }
    session_write_close();
    header('Location: ' . $base_url . 'admin&view=courses');
    exit();
}

$courses = $courseModel->getAll();
?>

<div class="bg-gray-100 min-h-screen py-10">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-bold text-navy">Gerenciar Cursos</h1>
                <p class="text-gray-500">Adicione, edite ou remova cursos do portal.</p>
            </div>
            <a href="/index.php?url=admin&view=course_form"
                class="bg-orange text-white px-6 py-3 rounded-xl font-bold hover:bg-navy transition shadow-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                Novo Curso
            </a>
        </div>

        <?php if (isset($_SESSION['msg'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                <?php echo $_SESSION['msg'];
                unset($_SESSION['msg']); ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-400 text-xs uppercase font-bold">
                        <tr>
                            <th class="px-8 py-4">Imagem</th>
                            <th class="px-8 py-4">Curso</th>
                            <th class="px-8 py-4">Categoria</th>
                            <th class="px-8 py-4">Preço (Vista)</th>
                            <th class="px-8 py-4">Status</th>
                            <th class="px-8 py-4 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($courses as $c): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-8 py-6">
                                    <?php if ($c['imagem']): ?>
                                        <img src="<?php echo $c['imagem']; ?>"
                                            class="w-16 h-12 object-cover rounded-lg shadow-sm">
                                    <?php else: ?>
                                        <div
                                            class="w-16 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-xs">
                                            Sem foto</div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-8 py-6 font-bold text-navy">
                                    <?php echo $c['titulo']; ?>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="bg-gray-100 px-3 py-1 rounded-full text-xs text-gray-600">
                                        <?php echo $c['categoria']; ?>
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-navy font-medium">
                                    R$
                                    <?php echo number_format($c['preco_vista'], 2, ',', '.'); ?>
                                </td>
                                <td class="px-8 py-6">
                                    <a href="/index.php?url=admin&view=courses&toggle_status=<?php echo $c['id']; ?>"
                                        class="flex items-center space-x-2">
                                        <div
                                            class="w-3 h-3 rounded-full <?php echo $c['status'] == 'ativo' ? 'bg-green-500' : 'bg-red-500'; ?>">
                                        </div>
                                        <span
                                            class="text-sm font-bold <?php echo $c['status'] == 'ativo' ? 'text-green-700' : 'text-red-700'; ?>">
                                            <?php echo ucfirst($c['status']); ?>
                                        </span>
                                    </a>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex justify-center space-x-4">
                                        <a href="/index.php?url=admin&view=course_form&id=<?php echo $c['id']; ?>"
                                            class="text-gray-400 hover:text-navy transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                                    stroke-width="2"></path>
                                            </svg>
                                        </a>
                                        <a href="/index.php?url=admin&view=courses&delete=<?php echo $c['id']; ?>"
                                            onclick="return confirm('Tem certeza que deseja excluir este curso?')"
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