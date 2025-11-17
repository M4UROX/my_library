<?php include 'partials/header.view.php'; ?>

<main class="flex-1">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-red-50 to-white rounded-2xl shadow-sm p-8 mb-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    Bienvenido a <span class="text-primary">My Library</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                    Gestiona tu colección de libros personal de manera fácil y profesional. 
                    Añade, edita y organiza tus libros favoritos.
                </p>
                
                <?php if ($_SESSION['user']): ?>
                    <div class="space-x-4">
                        <a href="/books" class="bg-primary text-white px-8 py-3 rounded-lg hover:bg-red-700 font-semibold text-lg inline-block transition-colors">
                            Ver Mi Librería
                        </a>
                    </div>
                <?php else: ?>
                    <div class="space-x-4">
                        <a href="/register" class="bg-primary text-white px-8 py-3 rounded-lg hover:bg-red-700 font-semibold text-lg inline-block transition-colors">
                            Comenzar Ahora
                        </a>
                        <a href="/login" class="border border-primary text-primary px-8 py-3 rounded-lg hover:bg-red-50 font-semibold text-lg inline-block transition-colors">
                            Iniciar Sesión
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mensaje de éxito para eliminación de cuenta -->
        <?php if (isset($_GET['success']) && $_GET['success'] === 'account_deleted'): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                Tu cuenta ha sido eliminada correctamente. ¡Gracias por usar My Library!
            </div>
        <?php endif; ?>

        <!-- Todos los Libros Añadidos -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                <?php if ($_SESSION['user']): ?>
                    Tus Libros Añadidos
                <?php else: ?>
                    Inicia Sesión para guardar tus libros en la librería
                <?php endif; ?>
            </h2>
            
            <?php if (empty($books)): ?>
                <div class="text-center py-12">
                    <div class="text-gray-400 text-6xl mb-4">📚</div>
                    <p class="text-gray-500 text-lg">
                        <?php if ($_SESSION['user']): ?>
                            No hay libros en tu biblioteca todavía.
                        <?php else: ?>
                            ¡Regístrate y comienza a construir tu colección personal!
                        <?php endif; ?>
                    </p>
                    <?php if ($_SESSION['user']): ?>
                        <a href="/add-book" class="inline-block mt-4 text-primary hover:text-red-700 font-medium">
                            ¡Sé el primero en añadir un libro!
                        </a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <!-- Diseño de tarjetas en lugar de tabla para una apariencia más visual y diferenciada -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($books as $book): ?>
                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow bg-gradient-to-br from-white to-gray-50">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2"><?= htmlspecialchars($book['title']) ?></h3>
                            <p class="text-gray-600 mb-2"><strong>Autor:</strong> <?= htmlspecialchars($book['author']) ?></p>
                            <p class="text-gray-600 mb-4"><strong>Publicado:</strong> <?= htmlspecialchars($book['publish_date']) ?></p>
                            <a href="/view-book/<?= $book['id'] ?>" class="text-primary hover:text-red-700 font-medium text-sm">
                                Ver Detalles →
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'partials/footer.view.php'; ?>