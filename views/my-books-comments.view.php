<?php include 'partials/header.view.php'; ?>

<main class="flex-1 bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Mis Libros y Comentarios</h1>

            <!-- Sección de Libros -->
            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Mis Libros</h2>
                <?php if (empty($books)): ?>
                    <p class="text-gray-500">Aún no has añadido ningún libro. <a href="/add-book" class="text-primary hover:text-red-700">¡Añade tu primer libro!</a></p>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($books as $book): ?>
                            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2"><?= htmlspecialchars($book['title']) ?></h3>
                                <p class="text-gray-600 mb-2">Autor: <?= htmlspecialchars($book['author']) ?></p>
                                <p class="text-gray-600 mb-4">Publicado: <?= htmlspecialchars($book['publish_date']) ?></p>
                                <div class="flex space-x-2">
                                    <a href="/view-book/<?= $book['id'] ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Ver Detalles</a>
                                    <a href="/edit-book/<?= $book['id'] ?>" class="text-green-600 hover:text-green-800 text-sm font-medium">Editar</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sección de Comentarios -->
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Mis Comentarios</h2>
                <?php if (empty($comments)): ?>
                    <p class="text-gray-500">Aún no has hecho ningún comentario. <a href="/books" class="text-primary hover:text-red-700">¡Explora libros y comenta!</a></p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($comments as $comment): ?>
                            <div class="border border-gray-200 rounded-lg p-6">
                                <p class="text-gray-800 mb-2"><strong>Libro:</strong> <?= htmlspecialchars($comment['book_title']) ?></p>
                                <p class="text-gray-800 mb-2"><?= htmlspecialchars($comment['description']) ?></p>
                                <p class="text-sm text-gray-500">Comentado el <?= date('d/m/Y', strtotime($comment['created_at'])) ?></p>
                                <div class="mt-2">
                                    <a href="/view-book/<?= $comment['book_id'] ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Ver en el Libro</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mt-8 text-center">
                <a href="/profile" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 font-semibold inline-block">
                    Volver al Perfil
                </a>
            </div>
        </div>
    </div>
</main>

<?php include 'partials/footer.view.php'; ?>