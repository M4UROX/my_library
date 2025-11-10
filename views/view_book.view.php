<?php include 'partials/header.view.php'; ?>

<main class="flex-1 bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Detalles del Libro</h1>

            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-4"><?= htmlspecialchars($book['title']) ?></h2>
                <p class="text-gray-600 mb-2"><strong>Autor:</strong> <?= htmlspecialchars($book['author']) ?></p>
                <p class="text-gray-600 mb-2"><strong>Año:</strong> <?= htmlspecialchars($book['publish_date']) ?></p>
            </div>

            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Comentarios</h3>
                    <?php if ($_SESSION['user']): ?>
                        <a href="/add-comment/<?= $book['id'] ?>" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-red-700 font-semibold">
                            Añadir Comentario
                        </a>
                    <?php endif; ?>
                </div>

                <?php if (isset($_GET['success']) && $_GET['success'] === 'comment'): ?>
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                        Comentario añadido correctamente.
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['success']) && $_GET['success'] === 'comment_deleted'): ?>
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                        Comentario eliminado correctamente.
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error']) && $_GET['error'] === 'delete_failed'): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                        Error al eliminar el comentario.
                    </div>
                <?php endif; ?>

                <?php if (empty($comments)): ?>
                    <p class="text-gray-500">No hay comentarios para este libro.</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($comments as $comment): ?>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <p class="text-gray-800 mb-2"><?= htmlspecialchars($comment['description']) ?></p>
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-500">
                                        <span>Por: <?= htmlspecialchars($comment['email']) ?></span>
                                        <?php if ($comment['created_at']): ?>
                                            <span class="mx-2">•</span>
                                            <span><?= date('Y-m-d', strtotime($comment['created_at'])) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if ($_SESSION['user'] && $_SESSION['user']['id'] === $comment['user_id']): ?>
    <div class="flex items-center space-x-2">
        <form method="GET" action="/delete-comment/<?= $comment['id'] ?>" class="inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este comentario?');">
            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                Eliminar
            </button>
        </form>
    </div>
<?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <a href="/books" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 font-semibold inline-block">
                Volver a Librería
            </a>
        </div>
    </div>
</main>

<?php include 'partials/footer.view.php'; ?>