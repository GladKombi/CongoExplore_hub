<?php
$user = $_SESSION['user'] ?? ['prenom' => '', 'nom' => '', 'role' => 'Visiteur'];
$role = $user['role'] ?? 'Visiteur';
$fullName = trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?: 'Utilisateur';
$initials = strtoupper(substr($user['prenom'] ?? 'U', 0, 1) . substr($user['nom'] ?? '', 0, 1));
$stats = $stats ?? [];
$recentContents = $recentContents ?? [];
$recentEvents = $recentEvents ?? [];
$publishedRatio = (($stats['contenus'] ?? 0) > 0) ? min(100, 62) : 0;

$cards = [
    ['label' => 'Publications', 'value' => $stats['contenus'] ?? 0, 'icon' => 'newspaper', 'tone' => 'bg-primary-900 text-white', 'url' => BASE_URL . 'contenu'],
    ['label' => 'Medias', 'value' => $stats['medias'] ?? 0, 'icon' => 'image', 'tone' => 'bg-gold-500 text-primary-900', 'url' => BASE_URL . 'media'],
    ['label' => 'Evenements', 'value' => $stats['evenements'] ?? 0, 'icon' => 'calendar', 'tone' => 'bg-primary-50 text-primary-900', 'url' => BASE_URL . 'evenement'],
    ['label' => 'Clients', 'value' => $stats['clients'] ?? 0, 'icon' => 'briefcase', 'tone' => 'bg-white text-primary-900', 'url' => BASE_URL . 'client'],
];

$moduleCards = [
    ['title' => 'Contenu media', 'desc' => 'Publications, categories, commentaires et medias.', 'icon' => 'newspaper', 'href' => BASE_URL . 'contenu', 'meta' => ($stats['commentaires'] ?? 0) . ' commentaires'],
    ['title' => 'Evenements', 'desc' => 'Planning, lieux et couverture media liee.', 'icon' => 'calendar', 'href' => BASE_URL . 'evenement', 'meta' => ($stats['evenements'] ?? 0) . ' actifs'],
    ['title' => 'Marketing', 'desc' => 'Clients, projets et livrables operationnels.', 'icon' => 'target', 'href' => BASE_URL . 'client', 'meta' => ($stats['projets'] ?? 0) . ' projets'],
    ['title' => 'Equipe', 'desc' => 'Roles, acces et collaborateurs internes.', 'icon' => 'users', 'href' => BASE_URL . 'utilisateur', 'meta' => ($stats['utilisateurs'] ?? 0) . ' comptes'],
];

$statusClasses = [
    'Publie' => 'bg-emerald-50 text-emerald-700',
    'Brouillon' => 'bg-gray-100 text-gray-600',
    'Archive' => 'bg-gold-50 text-gold-700',
];
?>

<div class="space-y-6">
    <section class="overflow-hidden rounded-[2rem] border border-primary-900/10 bg-primary-900 text-white shadow-sm">
        <div class="grid gap-6 p-6 lg:grid-cols-[minmax(0,1fr)_340px] lg:p-8">
            <div class="flex flex-col justify-between gap-8">
                <div>
                    <p class="mb-3 inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-gold-100">
                        <i data-lucide="shield-check" class="h-4 w-4"></i>
                        <?php echo htmlspecialchars($role, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                    </p>
                    <h2 class="font-display text-3xl font-bold leading-tight lg:text-5xl">
                        Bonjour, <?php echo htmlspecialchars($fullName, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                    </h2>
                    <p class="mt-4 max-w-2xl text-sm leading-6 text-white/65">
                        Vue centrale de Congo Explorer Hub : contenus, evenements, clients et performance sociale.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="<?php echo BASE_URL; ?>contenu" class="inline-flex items-center gap-2 rounded-2xl bg-gold-500 px-4 py-3 text-sm font-bold text-primary-900 transition hover:bg-gold-400">
                        <i data-lucide="plus" class="h-4 w-4"></i>
                        Nouvelle publication
                    </a>
                    <a href="<?php echo BASE_URL; ?>evenement" class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/15">
                        <i data-lucide="calendar" class="h-4 w-4"></i>
                        Planifier
                    </a>
                    <a href="<?php echo BASE_URL; ?>client" class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/15">
                        <i data-lucide="briefcase" class="h-4 w-4"></i>
                        Clients
                    </a>
                </div>
            </div>

            <aside class="rounded-[1.75rem] bg-white/10 p-5 backdrop-blur">
                <div class="flex items-center gap-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-gold-500 text-xl font-black text-primary-900">
                        <?php echo htmlspecialchars($initials, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                    </div>
                    <div>
                        <p class="text-sm text-white/60">Session active</p>
                        <p class="font-semibold"><?php echo htmlspecialchars($fullName, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                    </div>
                </div>
                <div class="mt-6 grid grid-cols-3 gap-2 text-center">
                    <div class="rounded-2xl bg-white/10 p-3">
                        <p class="text-lg font-bold"><?php echo htmlspecialchars((string)($stats['likes'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                        <p class="text-[11px] text-white/55">Likes</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 p-3">
                        <p class="text-lg font-bold"><?php echo htmlspecialchars((string)($stats['partages'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                        <p class="text-[11px] text-white/55">Partages</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 p-3">
                        <p class="text-lg font-bold"><?php echo htmlspecialchars((string)($stats['categories'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                        <p class="text-[11px] text-white/55">Categories</p>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <?php foreach ($cards as $card): ?>
            <a href="<?php echo htmlspecialchars($card['url'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" class="group rounded-[1.75rem] border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400"><?php echo htmlspecialchars($card['label'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                        <p class="mt-3 text-4xl font-black text-primary-900"><?php echo htmlspecialchars((string)$card['value'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                    </div>
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl <?php echo htmlspecialchars($card['tone'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                        <i data-lucide="<?php echo htmlspecialchars($card['icon'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" class="h-5 w-5"></i>
                    </span>
                </div>
                <div class="mt-5 flex items-center gap-2 text-xs font-semibold text-gray-400 group-hover:text-gold-600">
                    Ouvrir le module
                    <i data-lucide="arrow-left" class="h-3.5 w-3.5 rotate-180"></i>
                </div>
            </a>
        <?php endforeach; ?>
    </section>

    <section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
        <div class="rounded-[2rem] border border-gray-100 bg-white p-6 shadow-sm">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">Modules</p>
                    <h3 class="mt-1 font-display text-2xl font-bold text-primary-900">Pilotage rapide</h3>
                </div>
                <span class="rounded-full bg-primary-50 px-3 py-1 text-xs font-semibold text-primary-800">Operationnel</span>
            </div>

            <div class="grid gap-3 md:grid-cols-2">
                <?php foreach ($moduleCards as $module): ?>
                    <a href="<?php echo htmlspecialchars($module['href'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" class="rounded-3xl border border-gray-100 p-4 transition hover:border-gold-200 hover:bg-gold-50/50">
                        <div class="flex items-start gap-3">
                            <span class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-2xl bg-primary-50 text-primary-800">
                                <i data-lucide="<?php echo htmlspecialchars($module['icon'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" class="h-5 w-5"></i>
                            </span>
                            <div>
                                <h4 class="font-bold text-primary-900"><?php echo htmlspecialchars($module['title'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></h4>
                                <p class="mt-1 text-sm leading-5 text-gray-500"><?php echo htmlspecialchars($module['desc'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                                <p class="mt-3 text-xs font-semibold text-gold-700"><?php echo htmlspecialchars($module['meta'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <aside class="rounded-[2rem] border border-gray-100 bg-white p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">Progression</p>
            <h3 class="mt-1 font-display text-2xl font-bold text-primary-900">Production</h3>
            <div class="mt-6">
                <div class="mb-2 flex items-center justify-between text-sm">
                    <span class="font-semibold text-primary-900">Contenus actifs</span>
                    <span class="text-gray-500"><?php echo htmlspecialchars((string)($stats['contenus'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
                </div>
                <div class="h-3 overflow-hidden rounded-full bg-gray-100">
                    <div class="h-full rounded-full bg-gold-500" style="width: <?php echo htmlspecialchars((string)$publishedRatio, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>%"></div>
                </div>
            </div>
            <div class="mt-6 grid grid-cols-2 gap-3">
                <div class="rounded-3xl bg-primary-50 p-4">
                    <p class="text-2xl font-black text-primary-900"><?php echo htmlspecialchars((string)($stats['livrables'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                    <p class="text-xs text-gray-500">Livrables</p>
                </div>
                <div class="rounded-3xl bg-gold-50 p-4">
                    <p class="text-2xl font-black text-primary-900"><?php echo htmlspecialchars((string)($stats['projets'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                    <p class="text-xs text-gray-500">Projets</p>
                </div>
            </div>
        </aside>
    </section>

    <section class="grid gap-6 xl:grid-cols-2">
        <div class="rounded-[2rem] border border-gray-100 bg-white p-6 shadow-sm">
            <div class="mb-5 flex items-center justify-between">
                <h3 class="font-display text-xl font-bold text-primary-900">Dernieres publications</h3>
                <a href="<?php echo BASE_URL; ?>contenu" class="text-sm font-semibold text-gold-700 hover:text-gold-600">Voir tout</a>
            </div>
            <?php if (!empty($recentContents)): ?>
                <div class="space-y-3">
                    <?php foreach ($recentContents as $content): ?>
                        <?php $status = $content['statut'] ?? 'Brouillon'; ?>
                        <a href="<?php echo BASE_URL; ?>contenu/show/<?php echo htmlspecialchars((string)$content['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" class="flex items-center justify-between gap-4 rounded-3xl border border-gray-100 p-4 transition hover:border-gold-200 hover:bg-gold-50/40">
                            <div class="min-w-0">
                                <p class="truncate font-semibold text-primary-900"><?php echo htmlspecialchars($content['titre'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                                <p class="mt-1 text-xs text-gray-500"><?php echo htmlspecialchars($content['categorie_nom'] ?? 'Sans categorie', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                            </div>
                            <span class="flex-shrink-0 rounded-full px-3 py-1 text-xs font-semibold <?php echo htmlspecialchars($statusClasses[$status] ?? 'bg-gray-100 text-gray-600', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($status, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="rounded-3xl bg-gray-50 p-5 text-sm text-gray-500">Aucune publication pour le moment.</p>
            <?php endif; ?>
        </div>

        <div class="rounded-[2rem] border border-gray-100 bg-white p-6 shadow-sm">
            <div class="mb-5 flex items-center justify-between">
                <h3 class="font-display text-xl font-bold text-primary-900">Evenements recents</h3>
                <a href="<?php echo BASE_URL; ?>evenement" class="text-sm font-semibold text-gold-700 hover:text-gold-600">Voir tout</a>
            </div>
            <?php if (!empty($recentEvents)): ?>
                <div class="space-y-3">
                    <?php foreach ($recentEvents as $event): ?>
                        <a href="<?php echo BASE_URL; ?>evenement/show/<?php echo htmlspecialchars((string)$event['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" class="flex items-center gap-4 rounded-3xl border border-gray-100 p-4 transition hover:border-gold-200 hover:bg-gold-50/40">
                            <span class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-primary-50 text-primary-800">
                                <i data-lucide="calendar" class="h-5 w-5"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="truncate font-semibold text-primary-900"><?php echo htmlspecialchars($event['titre'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                                <p class="mt-1 text-xs text-gray-500"><?php echo htmlspecialchars(($event['lieu'] ?? '-') . ' - ' . ($event['date_debut'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="rounded-3xl bg-gray-50 p-5 text-sm text-gray-500">Aucun evenement pour le moment.</p>
            <?php endif; ?>
        </div>
    </section>
</div>
