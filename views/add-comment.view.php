<?php include 'partials/header.view.php'; ?>

<main class="flex-1 bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Añadir Comentario para: <?= htmlspecialchars($book['title']) ?> de <?= htmlspecialchars($book['author']) ?></h1>

            <form method="POST" action="/save-comment" class="space-y-6">
                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                <input type="hidden" name="book_id" value="<?= $book['id'] ?>">

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Comentario</label>
                    <textarea id="description" name="description" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                              rows="4" placeholder="Escribe tu comentario aquí..."></textarea>
                </div>

                <div class="flex space-x-4 pt-4">
                    <button type="submit"
                            class="flex-1 bg-primary text-white py-3 px-6 rounded-lg hover:bg-red-700 font-semibold transition-colors">
                        Guardar Comentario
                    </button>
                    <a href="/view-book/<?= $book['id'] ?>"
                       class="flex-1 bg-gray-200 text-gray-800 py-3 px-6 rounded-lg hover:bg-gray-300 font-semibold text-center transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include 'partials/footer.view.php'; ?>