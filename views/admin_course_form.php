<?php
// views/admin_course_form.php
require_once 'models/Course.php';
$courseModel = new Course($db);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$course = null;

if ($id) {
    $course = $courseModel->getById($id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $preco_vista = $_POST['preco_vista'];
    $parcelas = $_POST['parcelas'];
    $categoria = $_POST['categoria'];
    $status = $_POST['status'] ?? 'ativo';
    $imagem = $_POST['imagem_url'] ?? null;

    // Handle File Upload
    if (isset($_FILES['imagem_file']) && $_FILES['imagem_file']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $filename = $_FILES['imagem_file']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $target_dir = "uploads/cursos/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $new_name = uniqid() . "." . $ext;
            $target_file = $target_dir . $new_name;

            if (move_uploaded_file($_FILES['imagem_file']['tmp_name'], $target_file)) {
                $imagem = "https://auladireta.com.br/" . $target_file;
            }
        }
    }

    if ($id) {
        $success = $courseModel->update($id, $titulo, $descricao, $preco_vista, $preco_parcelado, $parcelas, $categoria, $imagem, $status);
    } else {
        $success = $courseModel->create($titulo, $descricao, $preco_vista, $preco_parcelado, $parcelas, $categoria, $imagem, $status);
    }

    if ($success) {
        $_SESSION['msg'] = "Curso salvo com sucesso!";
        session_write_close();
        header('Location: ' . $base_url . 'admin&view=courses');
        exit();
    } else {
        $error = "Erro ao salvar curso.";
    }
}
?>

<div class="bg-gray-100 min-h-screen py-10">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="mb-10">
            <a href="/index.php?url=admin&view=courses" class="text-navy hover:text-orange flex items-center font-bold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                Voltar para lista
            </a>
            <h1 class="text-3xl font-bold text-navy mt-4">
                <?php echo $id ? 'Editar Curso' : 'Novo Curso'; ?>
            </h1>
        </div>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-3xl shadow-xl p-10 border border-gray-100">
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-navy mb-2">Título do Curso</label>
                        <input type="text" name="titulo" required
                            value="<?php echo $course ? $course['titulo'] : ''; ?>"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-orange">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-navy mb-2">Categoria</label>
                        <select name="categoria" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-orange appearance-none">
                            <option value="Pós-Graduação" <?php echo ($course && $course['categoria'] == 'Pós-Graduação') ? 'selected' : ''; ?>>Pós-Graduação</option>
                            <option value="Técnico / COFECI" <?php echo ($course && $course['categoria'] == 'Técnico / COFECI') ? 'selected' : ''; ?>>Técnico / COFECI
                            </option>
                            <option value="Profissionalizante" <?php echo ($course && $course['categoria'] == 'Profissionalizante') ? 'selected' : ''; ?>>Profissionalizante
                            </option>
                            <option value="Educação Básica" <?php echo ($course && $course['categoria'] == 'Educação Básica') ? 'selected' : ''; ?>>Educação Básica
                            </option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-navy mb-2">Descrição Curta</label>
                    <textarea name="descricao" required rows="3"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-orange"><?php echo $course ? $course['descricao'] : ''; ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-navy mb-2">Preço à Vista (R$)</label>
                        <input type="number" step="0.01" name="preco_vista" required
                            value="<?php echo $course ? $course['preco_vista'] : ''; ?>"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-orange">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-navy mb-2">Preço Parcelado (Total)</label>
                        <input type="number" step="0.01" name="preco_parcelado" required
                            value="<?php echo $course ? $course['preco_parcelado'] : ''; ?>"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-orange">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-navy mb-2">Nº de Parcelas</label>
                        <input type="number" name="parcelas" required
                            value="<?php echo $course ? $course['parcelas'] : '10'; ?>"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-orange">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-navy mb-2">Status do Curso</label>
                        <select name="status" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-orange appearance-none">
                            <option value="ativo" <?php echo ($course && $course['status'] == 'ativo') ? 'selected' : ''; ?>>Ativo (Visível no site)</option>
                            <option value="inativo" <?php echo ($course && $course['status'] == 'inativo') ? 'selected' : ''; ?>>Inativo (Oculto)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-navy mb-2">Imagem do Curso</label>
                        <div class="flex flex-col space-y-4 text-xs text-gray-400">
                            Dica: Imagens de 800x600 ficam ideais.
                        </div>
                    </div>
                </div>

                <div class="flex flex-col space-y-4">
                    <?php if ($course && $course['imagem']): ?>
                        <div class="relative group w-48 h-32">
                            <img src="<?php echo $course['imagem']; ?>"
                                class="w-full h-full object-cover rounded-xl shadow-md">
                            <div
                                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center rounded-xl">
                                <span class="text-white text-xs font-bold">Imagem Atual</span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex-1">
                            <label class="block text-xs text-gray-400 mb-1">Fazer Novo Upload</label>
                            <input type="file" name="imagem_file"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange file:text-white hover:file:bg-navy transition">
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs text-gray-400 mb-1">Ou alterar URL manual</label>
                            <input type="text" name="imagem_url" value="<?php echo $course ? $course['imagem'] : ''; ?>"
                                placeholder="https://..."
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-6">
                    <button type="submit"
                        class="bg-navy text-white px-10 py-4 rounded-xl font-bold hover:bg-orange transition shadow-xl">
                        <?php echo $id ? 'Salvar Alterações' : 'Criar Curso'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>