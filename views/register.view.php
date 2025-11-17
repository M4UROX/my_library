<?php include 'partials/header.view.php'; ?>

<main class="flex-1 bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Crear Cuenta
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Inicia sesión para acceder a tu colección personal de libros.  <!-- Texto más atractivo y consistente -->
            </p>
        </div>

        <?php if (isset($error) && !empty($error)): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($success) && !empty($success)): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                <?= htmlspecialchars($success) ?>
            </div>
            <!-- Redirección automática a /login después de registro exitoso para mejorar UX -->
            <script>
                setTimeout(function() {
                    window.location.href = '/login';
                }, 3000);  // 3000 ms = 3 segundos para leer el mensaje
            </script>
        <?php endif; ?>

        <form class="mt-8 space-y-6 bg-white p-8 rounded-2xl shadow-sm" method="POST" action="/register">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input id="email" name="email" type="email" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                       placeholder="tu@email.com">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
                <input id="password" name="password" type="password" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                       placeholder="Mínimo 6 caracteres">
            </div>

            <div>
                <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña</label>
                <input id="confirm_password" name="confirm_password" type="password" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                       placeholder="Repite tu contraseña">
            </div>

            <div class="flex flex-col space-y-4">
                <button type="submit"
                        class="w-full bg-primary text-white py-3 px-4 rounded-lg hover:bg-red-700 font-semibold transition-colors">
                    Registrarse
                </button>
                
                <a href="/login" 
                   class="w-full border border-primary text-primary text-center py-3 px-4 rounded-lg hover:bg-red-50 font-semibold transition-colors">
                    Iniciar Sesión
                </a>
            </div>
        </form>
    </div>
</main>

<?php include 'partials/footer.view.php'; ?>
