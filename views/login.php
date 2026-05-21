<!DOCTYPE html>
<html lang="fr" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - PeerSync</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Configuration de la palette de couleurs personnalisée pour PeerSync
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0f7ff',
                            100: '#e0effe',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans antialiased">

<div class="sm:mx-auto w-full sm:max-w-md">
    <div class="flex justify-center items-center space-x-2">
        <div class="bg-brand-600 text-white p-2 rounded-lg shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </div>
        <span class="text-2xl font-extrabold tracking-tight text-brand-900">Peer<span class="text-brand-600">Sync</span></span>
    </div>
    <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-slate-900">Connexion à votre espace</h2>
    <p class="mt-2 text-center text-sm text-slate-600">
        Plateforme d'entraide et de tutorat entre étudiants
    </p>
</div>

<div class="mt-8 sm:mx-auto w-full sm:max-w-md">
    <div class="bg-white py-8 px-4 shadow-xl border border-slate-100 sm:rounded-xl sm:px-10">

        <?php if (isset($error) && !empty($error)): ?>
            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 flex items-start space-x-3">
                <svg class="h-5 w-5 text-red-500 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                </svg>
                <span class="text-sm font-medium text-red-800"><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <form class="space-y-6" action="index.php?route=login" method="POST">

            <div>
                <label for="email" class="block text-sm font-semibold leading-6 text-slate-900">Adresse email</label>
                <div class="mt-2">
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="block w-full rounded-lg border-0 py-2 px-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6 transition"
                           placeholder="nom.prenom@etudiant.com">
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-semibold leading-6 text-slate-900">Mot de passe</label>
                </div>
                <div class="mt-2">
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="block w-full rounded-lg border-0 py-2 px-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6 transition"
                           placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox"
                           class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-600">
                    <label for="remember-me" class="ml-3 block text-sm text-slate-600 select-none">Se souvenir de moi</label>
                </div>
            </div>

            <div>
                <button type="submit"
                        class="flex w-full justify-center rounded-lg bg-brand-600 px-3 py-2.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-brand-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600 transition duration-150 ease-in-out">
                    Se connecter
                </button>
            </div>
        </form>

        <div class="mt-6 border-t border-slate-100 pt-6 text-center">
            <p class="text-xs text-slate-500">
                Besoin d'un compte ? Contactez l'administration de l'école.
            </p>
        </div>

    </div>
</div>

</body>
</html>