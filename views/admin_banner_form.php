<?php
// views/admin_banner_form.php
if (!isset($_SESSION['user_id']) || $_SESSION['user_nivel'] != 'admin') {
    header('Location: /login');
    exit();
}

require_once 'models/Banner.php';
$bannerModel = new Banner($db);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$banner = null;

if ($id) {
    $banner = $bannerModel->getById($id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bannerModel->id = $id;
    $bannerModel->titulo = $_POST['titulo'];
    $bannerModel->link = $_POST['link'];
    $bannerModel->ordem = $_POST['ordem'];
    $bannerModel->status = $_POST['status'];

    // Handle Image Upload
    $imagem_path = isset($_POST['current_image']) ? $_POST['current_image'] : '';

    if (isset($_FILES['imagem_file']) && $_FILES['imagem_file']['error'] == 0) {
        $target_dir = "uploads/banners/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $file_extension = strtolower(pathinfo($_FILES['imagem_file']['name'], PATHINFO_EXTENSION));
        $new_filename = uniqid('banner_') . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;

        $allowed_types = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (in_array($file_extension, $allowed_types)) {
            if (move_uploaded_file($_FILES['imagem_file']['tmp_name'], $target_file)) {
                $imagem_path = '/' . $target_file;
            }
        }
    }

    $bannerModel->imagem = $imagem_path;

    if ($id) {
        $bannerModel->update();
    } else {
        $bannerModel->create();
    }
    header('Location: /index.php?url=admin&view=banners');
    exit();
}

$page_title = $id ? "Editar Banner" : "Novo Banner";
render_header();
?>

<div class="flex min-h-screen bg-gray-50">
    <main class="flex-1 p-8 max-w-4xl mx-auto">
        <a href="/admin?view=banners" class="text-navy hover:text-orange flex items-center mb-8 font-bold">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            Voltar
        </a>

        <h1 class="text-3xl font-bold text-navy mb-10">
            <?php echo $page_title; ?>
        </h1>

        <form method="POST" enctype="multipart/form-data"
            class="bg-white p-10 rounded-3xl shadow-xl border border-gray-100 space-y-8">
            <input type="hidden" name="current_image" value="<?php echo $banner ? $banner['imagem'] : ''; ?>">

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Título
                    (Opcional)</label>
                <input type="text" name="titulo" value="<?php echo $banner ? $banner['titulo'] : ''; ?>"
                    class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-navy focus:outline-none focus:ring-2 focus:ring-orange"
                    placeholder="Ex: Promoção de Verão">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Link
                        (Opcional)</label>
                    <input type="text" name="link" value="<?php echo $banner ? $banner['link'] : ''; ?>"
                        class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-navy focus:outline-none focus:ring-2 focus:ring-orange"
                        placeholder="/index.php?url=cursos">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Ordem de
                        Exibição</label>
                    <input type="number" name="ordem" value="<?php echo $banner ? $banner['ordem'] : 0; ?>"
                        class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-navy focus:outline-none focus:ring-2 focus:ring-orange">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Status</label>
                    <select name="status"
                        class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-navy focus:outline-none focus:ring-2 focus:ring-orange">
                        <option value="ativo" <?php echo ($banner && $banner['status'] == 'ativo') ? 'selected' : ''; ?>
                            >Ativo</option>
                        <option value="inativo" <?php echo ($banner && $banner['status'] == 'inativo') ? 'selected' : ''; ?>>Inativo</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Imagem do
                        Banner</label>
                    <div class="relative group">
                        <input type="file" name="imagem_file" accept="image/*"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" id="file_input" <?php echo $id ? '' : 'required'; ?>>
                        <div
                            class="w-full bg-gray-50 border border-dashed border-gray-300 rounded-2xl p-4 text-center group-hover:border-orange transition flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-orange" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <span class="text-sm text-gray-500 group-hover:text-navy font-medium" id="file_name">
                                <?php echo $banner ? 'Trocar imagem...' : 'Escolher arquivo...'; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($banner && $banner['imagem']): ?>
                <div class="mt-4">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Imagem Atual</label>
                    <img src="<?php echo $banner['imagem']; ?>"
                        class="w-full max-h-48 object-cover rounded-2xl border border-gray-100 shadow-sm">
                </div>
            <?php endif; ?>

            <script>
                document.getElementById('file_input').onchange = function () {
                    document.getElementById('file_name').innerHTML = this.files[0].name;
                    document.getElementById('file_name').classList.add('text-navy');
                };
            </script>

            <button type="submit"
                class="w-full bg-navy text-white py-5 rounded-2xl font-bold text-lg hover:bg-orange transition shadow-xl mt-4 italic">Salvar
                Banner</button>
        </form>
    </main>
</div>

<?php render_footer(); ?>