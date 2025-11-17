<?php include 'partials/header.view.php'; ?>

<main class="flex-1">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Mi Librería</h1>
                
                <?php if ($_SESSION['user']): ?>
                    <a href="/add-book" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-red-700 font-semibold flex items-center">
                        <span class="mr-2">+</span> Añadir Libro
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mensajes de éxito/error -->
            <?php if (isset($_GET['success'])): ?>
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <?php
                    $messages = [
                        'add' => 'Libro añadido correctamente.',
                        'edit' => 'Libro actualizado correctamente.',
                        'delete' => 'Libro eliminado correctamente.',
                        'comment' => 'Comentario añadido correctamente.'
                    ];
                    echo $messages[$_GET['success']] ?? 'Operación completada correctamente.';
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <?php
                    $messages = [
                        'add' => 'Error al añadir el libro.',
                        'edit' => 'Error al actualizar el libro.',
                        'delete' => 'Error al eliminar el libro.',
                        'invalid' => 'Datos inválidos.',
                        'comment' => 'Error al añadir el comentario.',
                        'notfound' => 'Libro no encontrado o no tienes permisos.',
                        'duplicate' => 'Este libro ya existe en tu colección.'
                    ];
                    echo $messages[$_GET['error']] ?? 'Ha ocurrido un error.';
                    ?>
                </div>
            <?php endif; ?>

            <?php if (empty($books)): ?>
                <div class="text-center py-12 bg-white rounded-2xl shadow-sm">
                    <div class="text-gray-400 text-6xl mb-4">📚</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay libros en la biblioteca</h3>
                    <p class="text-gray-500 mb-6 max-w-2xl mx-auto">
                        Comienza añadiendo tu primer libro a la colección.
                    </p>
                    <?php if ($_SESSION['user']): ?>
                        <a href="/add-book" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-red-700 font-semibold inline-block">
                            Añadir Primer Libro
                        </a>
                    <?php else: ?>
                        <p class="text-gray-500">
                            <a href="/login" class="text-red-600 hover:text-red-800 font-medium">Inicia sesión para añadir libros.</a>
                        </p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Autor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>  <!-- Cambiado: "Año" por "Fecha" para mayor claridad -->
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comentarios</th>
                                    <?php if ($_SESSION['user']): ?>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    <?php endif; ?>
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
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                <!-- Iconos en lugar de texto para "Ver Comentarios" y "Añadir Comentario" -->
                                                <a href="/view-book/<?= $book['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-2" title="Ver Comentarios">
                                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                    </svg>
                                                </a>
                                                <?php if ($_SESSION['user']): ?>
                                                    <a href="/add-comment/<?= $book['id'] ?>" class="text-green-600 hover:text-green-900" title="Añadir Comentario">
                                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <?php if ($_SESSION['user'] && $book['user_id'] == $_SESSION['user']['id']): ?>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="/edit-book/<?= $book['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-4">Editar</a>
                                                <form action="/delete-book/<?= $book['id'] ?>" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este libro?')">
                                                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                                </form>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'partials/footer.view.php'; ?>