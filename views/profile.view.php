<?php include 'partials/header.view.php'; ?>

<main class="flex-1 bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <div class="text-center mb-8">
                <!-- Avatar con iniciales -->
                <div class="w-24 h-24 bg-primary text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                    <?= strtoupper(substr($_SESSION['user']['email'], 0, 1) . substr(explode('@', $_SESSION['user']['email'])[0], 1, 1)) ?>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Mi Perfil</h1>
                <p class="text-gray-600">Gestiona tu información personal</p>
            </div>

            <!-- Mensajes de éxito y error -->
            <?php if (isset($error) && !empty($error)): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if (isset($success) && !empty($success)): ?>
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                
                <!-- Información Actual -->
                <div>
                    <label for="current_email" class="block text-sm font-medium text-gray-700 mb-2">Email Actual</label>
                    <input type="email" id="current_email" 
                           value="<?= htmlspecialchars($user['email']) ?>"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed"
                           disabled readonly>
                </div>

                <!-- Cambiar Correo Electrónico -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Cambiar Correo Electrónico</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="new_email" class="block text-sm font-medium text-gray-700 mb-2">Nuevo Correo Electrónico</label>
                            <input type="email" id="new_email" name="new_email"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                   placeholder="Ingresa tu nuevo correo electrónico"
                                   value="<?= htmlspecialchars($_POST['new_email'] ?? '') ?>">
                        </div>

                        <div>
                            <label for="confirm_email" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Nuevo Correo Electrónico</label>
                            <input type="email" id="confirm_email" name="confirm_email"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                   placeholder="Confirma tu nuevo correo electrónico"
                                   value="<?= htmlspecialchars($_POST['confirm_email'] ?? '') ?>">
                        </div>

                        <div>
                            <label for="email_password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña Actual</label>
                            <input type="password" id="email_password" name="email_password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                   placeholder="Ingresa tu contraseña para confirmar">
                        </div>
                    </div>
                </div>

                <!-- Cambiar Contraseña -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Cambiar Contraseña</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña Actual</label>
                            <input type="password" id="current_password" name="current_password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                   placeholder="Ingresa tu contraseña actual">
                        </div>

                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña</label>
                            <input type="password" id="new_password" name="new_password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                   placeholder="Mínimo 6 caracteres">
                        </div>

                        <div>
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Nueva Contraseña</label>
                            <input type="password" id="confirm_password" name="confirm_password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                   placeholder="Repite tu nueva contraseña">
                        </div>
                    </div>
                </div>

                <div class="flex space-x-4 pt-4">
                    <button type="submit"
                            class="flex-1 bg-primary text-white py-3 px-6 rounded-lg hover:bg-red-700 font-semibold transition-colors">
                        Actualizar Perfil
                    </button>
                    <a href="/books"
                       class="flex-1 bg-gray-200 text-gray-800 py-3 px-6 rounded-lg hover:bg-gray-300 font-semibold text-center transition-colors">
                        Volver a Librería
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include 'partials/footer.view.php'; ?>