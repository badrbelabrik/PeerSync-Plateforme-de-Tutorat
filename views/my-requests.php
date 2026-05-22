<?php
// 1. On démarre la session si ce n'est pas fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Si l'utilisateur n'est même pas connecté en session -> Login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php?route=login');
    exit();
}

// 3. S'il est connecté en session, mais que $currentUser n'existe pas -> Routeur
if (!isset($currentUser)) {
    header('Location: ../index.php?route=dashboard');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Demandes - PeerSync</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50: '#f0f7ff', 100: '#e0effe', 600: '#2563eb', 700: '#1d4ed8', 900: '#1e3a8a' }
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full font-sans antialiased text-slate-900">

<div class="flex h-screen overflow-hidden">

    <aside class="hidden md:flex md:w-64 md:flex-col bg-brand-900 text-white">
        <div class="flex flex-col flex-1 min-h-0">
            <div class="flex items-center h-16 px-6 bg-brand-950 space-x-2">
                <div class="bg-brand-600 p-1.5 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <span class="text-xl font-bold tracking-tight">Peer<span class="text-brand-600">Sync</span></span>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <a href="index.php?route=dashboard" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg text-brand-100 hover:bg-brand-800 hover:text-white transition">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Tableau de bord
                </a>
                <a href="index.php?route=my-requests" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg bg-brand-600 text-white transition">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Mes Demandes
                </a>
            </nav>

            <div class="flex p-4 bg-brand-950 border-t border-brand-800">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-full bg-brand-600 flex items-center justify-center font-bold text-white uppercase">
                        <?= substr($_SESSION['user_firstname'] ?? 'E', 0, 1) ?>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white"><?= htmlspecialchars($_SESSION['user_firstname'] ?? 'Étudiant') ?></p>
                        <a href="index.php?route=logout" class="text-xs text-brand-300 hover:text-white transition underline">Se déconnecter</a>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <div class="flex flex-col flex-1 overflow-hidden">

        <header class="flex items-center justify-between h-16 px-6 bg-white border-b border-slate-200 md:hidden">
            <span class="text-lg font-bold text-brand-900">PeerSync</span>
            <a href="index.php?route=logout" class="text-sm font-medium text-red-600">Quitter</a>
        </header>

        <main class="flex-1 overflow-y-auto p-6 lg:p-8">

            <div class="md:flex md:items-center md:justify-between mb-8">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold leading-7 text-slate-900 sm:text-3xl sm:truncate">
                        Mes Sessions d'Entraide 📑
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Suivez l'état d'avancement de vos demandes créées ou acceptées.
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <button id="openModalBtn" class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 focus:outline-none transition">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Créer un ticket d'aide
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5 sm:grid-cols-2 lg:grid-cols-3 mb-8">
                <div class="bg-white overflow-hidden shadow-sm border border-slate-200 rounded-xl p-5 flex items-center space-x-4">
                    <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 truncate">Votre solde de points</p>
                        <p class="text-2xl font-bold text-slate-900"><?= $currentUser->getPoints() . " pts" ?></p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm border border-slate-200 rounded-xl p-5 flex items-center space-x-4">
                    <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 truncate">Votre solde de points</p>
                        <p class="text-2xl font-bold text-slate-900"><?= $currentUser->getPoints() . " pts" ?></p>
                    </div>
                </div>
            </div>


            <div class="bg-white shadow-sm border border-slate-200 rounded-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
                    <h3 class="text-base font-semibold leading-6 text-slate-900">Suivi de vos demandes</h3>
                    <span class="inline-flex items-center rounded-md bg-brand-50 px-2 py-1 text-xs font-medium text-brand-700 ring-1 ring-inset ring-brand-700/10">Historique complet</span>
                </div>

                <ul class="divide-y divide-slate-200">
                    <?php if (empty($myRequests)): ?>
                        <li class="p-6 text-center text-sm text-slate-500">
                            Vous n'avez aucune demande d'aide active ou assignée pour le moment.
                        </li>
                    <?php else: ?>
                        <?php foreach ($myRequests as $request): ?>
                            <li class="p-6 hover:bg-slate-50 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-start space-x-3">
                                        <?php
                                        $statusColor = 'bg-yellow-500';
                                        if (($request['status'] ?? '') === 'assigned') $statusColor = 'bg-blue-500 animate-pulse';
                                        if (($request['status'] ?? '') === 'resolved') $statusColor = 'bg-green-500';
                                        ?>
                                        <div class="mt-1 flex-shrink-0 w-2.5 h-2.5 rounded-full <?= $statusColor ?>"></div>

                                        <div>
                                            <h4 class="text-sm font-semibold text-brand-900">
                                                <?= htmlspecialchars($request['title'] ?? 'Demande d\'aide') ?>
                                            </h4>
                                            <p class="text-sm text-slate-600 mt-1 max-w-2xl">
                                                <?= htmlspecialchars($request['description'] ?? '') ?>
                                            </p>
                                            <div class="mt-2 flex items-center space-x-4 text-xs text-slate-500">
                                                <span>Auteur : <?= htmlspecialchars(($request['firstname'] ?? '') . ' ' . ($request['lastname'] ?? '')) ?></span>
                                                <?php if (!empty($request['tutor_firstname'])): ?>
                                                    <span class="text-brand-600 font-medium">• Tuteur : <?= htmlspecialchars($request['tutor_firstname'] . ' ' . $request['tutor_lastname']) ?></span>
                                                <?php endif; ?>
                                                <span>• Créé le : <?= date('d/m/Y à H:i', strtotime($request['created_at'])) ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <?php if (($request['status'] ?? '') === 'assigned'): ?>
                                            <a href="index.php?route=resolve-ticket&id=<?= $request['id'] ?>"
                                               class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-semibold rounded-md text-white bg-green-600 hover:bg-green-700 shadow-sm transition">
                                                Marquer comme résolu
                                            </a>
                                        <?php else: ?>
                                            <span class="inline-flex items-center rounded-md px-2.5 py-1 text-xs font-medium capitalize
                                                <?= ($request['status'] ?? '') === 'resolved' ? 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20' : 'bg-yellow-50 text-yellow-800 ring-1 ring-inset ring-yellow-600/20' ?>">
                                                <?= htmlspecialchars($request['status'] ?? 'pending') ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>

        </main>
    </div>
</div>

<div id="helpModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div id="modalOverlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200">
            <div class="bg-slate-50/50 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900" id="modal-title">Créer une demande d'aide</h3>
                <button id="closeModalBtn" class="text-slate-400 hover:text-slate-500 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form action="index.php?route=create-ticket" method="POST" class="px-6 py-4 space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Quel est votre problème ? (Titre court)</label>
                    <input type="text" name="title" id="title" required placeholder="Ex: Erreur Fetch PDO dans mon Repository"
                           class="w-full rounded-lg border-slate-300 shadow-sm border p-2.5 text-sm focus:border-brand-600 focus:ring focus:ring-brand-600/20 focus:outline-none">
                </div>
                <div>
                    <label for="skill" class="block text-sm font-medium text-slate-700 mb-1">Matière / Technologie</label>
                    <select name="skill" id="skill" class="w-full rounded-lg border-slate-300 shadow-sm border p-2.5 text-sm focus:border-brand-600 focus:ring focus:ring-brand-600/20 focus:outline-none bg-white">
                        <?php if (isset($skills) && is_array($skills)): ?>
                            <?php foreach($skills as $skill): ?>
                                <option value="<?= htmlspecialchars($skill['name']) ?>"><?= htmlspecialchars($skill['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Détaillez votre demande</label>
                    <textarea name="description" id="description" rows="4" required placeholder="Expliquez ce que vous essayez de faire et l'erreur obtenue..."
                              class="w-full rounded-lg border-slate-300 shadow-sm border p-2.5 text-sm focus:border-brand-600 focus:ring focus:ring-brand-600/20 focus:outline-none"></textarea>
                </div>
                <div class="pt-4 border-t border-slate-200 flex justify-end space-x-3">
                    <button type="button" id="cancelModalBtn" class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-lg text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-sm transition">
                        Publier la demande
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('helpModal');
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelModalBtn');
    const overlay = document.getElementById('modalOverlay');

    openBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    });

    const closeModal = () => {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    };

    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', closeModal);
</script>
</body>
</html>