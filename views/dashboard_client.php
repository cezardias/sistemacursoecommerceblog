<?php
$page_title = "Meus Cursos";
render_header();

// Fetch purchased courses
$query = "SELECT c.* FROM cursos c 
          JOIN pedido_itens pi ON c.id = pi.course_id 
          JOIN pedidos p ON pi.pedido_id = p.id 
          WHERE p.usuario_id = ? AND p.status = 'pago'";
$stmt = $db->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$my_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="bg-gray-100 min-h-screen py-12">
    <div class="container mx-auto px-6">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-navy">Meus <span class="text-orange">Cursos</span></h1>
            <p class="text-gray-500">Continue sua jornada de aprendizado onde você parou.</p>
        </div>

        <?php if (empty($my_courses)): ?>
            <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-gray-100 italic text-gray-400">
                Você ainda não possui inscrições ativas. <a href="/home#cursos"
                    class="text-orange underline not-italic font-bold">Ver cursos disponíveis.</a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($my_courses as $curso): ?>
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden group">
                        <div
                            class="bg-navy h-40 flex items-center justify-center text-white text-5xl group-hover:bg-orange transition duration-500">
                            🎓
                        </div>
                        <div class="p-6">
                            <span class="text-xs font-bold uppercase tracking-wider text-orange mb-2 block">
                                <?php echo $curso['categoria']; ?>
                            </span>
                            <h3 class="text-xl font-bold text-navy mb-4">
                                <?php echo $curso['titulo']; ?>
                            </h3>
                            <div class="w-full bg-gray-100 rounded-full h-2 mb-6">
                                <div class="bg-orange h-2 rounded-full" style="width: 15%"></div>
                            </div>
                            <button
                                class="w-full bg-navy text-white py-3 rounded-xl font-bold hover:bg-orange transition shadow-md">Assistir
                                Aula</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php render_footer(); ?>