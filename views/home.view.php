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

        <!-- Todos los Libros Añadidos -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Todos los Libros Añadidos</h2>
            
            <?php if (empty($books)): ?>
                <div class="text-center py-12">
                    <div class="text-gray-400 text-6xl mb-4">📚</div>
                    <p class="text-gray-500 text-lg">No hay libros en la biblioteca todavía.</p>
                    <?php if ($_SESSION['user']): ?>
                        <a href="/add-book" class="inline-block mt-4 text-primary hover:text-red-700 font-medium">
                            ¡Sé el primero en añadir un libro!
                        </a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Autor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($books as $book): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($book['title']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?= htmlspecialchars($book['author']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?= htmlspecialchars($book['publish_date']) ?></div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'partials/footer.view.php'; ?>