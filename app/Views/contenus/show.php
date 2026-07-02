<?php
$statusMeta = [
    'Brouillon' => ['badge' => 'bg-gray-100 text-gray-700 border-gray-200', 'icon' => 'file-text'],
    'Publie' => ['badge' => 'bg-emerald-50 text-emerald-800 border-emerald-100', 'icon' => 'circle-check'],
    'Archive' => ['badge' => 'bg-gold-50 text-gold-800 border-gold-100', 'icon' => 'archive'],
];
$commentaires = $commentaires ?? [];
?>

<div class="space-y-6">
    <nav class="flex flex-wrap items-center gap-2 text-sm">
        <a href="<?php echo BASE_URL; ?>contenu" class="inline-flex items-center gap-2 rounded-2xl bg-primary-900 px-4 py-2 font-semibold text-white shadow-sm">
            <i data-lucide="newspaper" class="w-4 h-4"></i>
            Publications
        </a>
        <a href="<?php echo BASE_URL; ?>media" class="inline-flex items-center gap-2 rounded-2xl border border-gray-100 bg-white px-4 py-2 font-semibold text-gray-600 shadow-sm hover:text-primary-900 transition">
            <i data-lucide="image" class="w-4 h-4"></i>
            Medias
        </a>
        <a href="<?php echo BASE_URL; ?>categorie" class="inline-flex items-center gap-2 rounded-2xl border border-gray-100 bg-white px-4 py-2 font-semibold text-gray-600 shadow-sm hover:text-primary-900 transition">
            <i data-lucide="folder" class="w-4 h-4"></i>
            Categories
        </a>
    </nav>

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Publication</p>
            <h2 class="text-2xl font-bold text-primary-900 font-display"><?php echo htmlspecialchars($title ?? 'Publication', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></h2>
        </div>
        <a href="<?php echo BASE_URL; ?>contenu" class="inline-flex w-fit items-center justify-center gap-2 rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-primary-900 shadow-sm hover:bg-primary-50 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Retour aux publications
        </a>
    </div>

    <?php if (!empty($contenu)): ?>
        <?php
        $status = $contenu['statut'] ?? 'Brouillon';
        $meta = $statusMeta[$status] ?? ['badge' => 'bg-gray-50 text-gray-700 border-gray-100', 'icon' => 'file-text'];
        $author = trim(($contenu['auteur_prenom'] ?? '') . ' ' . ($contenu['auteur_nom'] ?? '')) ?: 'Auteur inconnu';
        $publishedAt = !empty($contenu['date_publication']) ? date('d/m/Y a H:i', strtotime((string)$contenu['date_publication'])) : 'Non publie';
        $createdAt = !empty($contenu['created_at']) ? date('d/m/Y a H:i', strtotime((string)$contenu['created_at'])) : '-';
        $body = trim((string)($contenu['corps_text'] ?? ''));
        ?>

        <section class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
            <div class="border-b border-gray-100 p-6 lg:p-8">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                    <div class="max-w-3xl">
                        <div class="mb-5 flex flex-wrap items-center gap-3">
                            <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-semibold <?php echo htmlspecialchars($meta['badge'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                                <i data-lucide="<?php echo htmlspecialchars($meta['icon'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" class="w-4 h-4"></i>
                                <?php echo htmlspecialchars($status, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-primary-50 px-3 py-1 text-xs font-semibold text-primary-800">
                                <i data-lucide="tag" class="w-4 h-4"></i>
                                <?php echo htmlspecialchars($contenu['categorie_nom'] ?? 'Sans categorie', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                            </span>
                        </div>
                        <h1 class="text-3xl font-bold leading-tight text-primary-900 font-display lg:text-4xl"><?php echo htmlspecialchars($contenu['titre'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></h1>
                        <p class="mt-4 text-sm text-gray-500">Par <strong class="text-primary-900"><?php echo htmlspecialchars($author, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></strong></p>
                    </div>
                    <div class="flex h-20 w-20 flex-shrink-0 items-center justify-center rounded-[1.75rem] bg-primary-50 text-primary-800">
                        <i data-lucide="file-text" class="w-9 h-9"></i>
                    </div>
                </div>
            </div>

            <div class="grid gap-0 md:grid-cols-3">
                <article class="border-b border-gray-100 p-6 md:border-b-0 md:border-r">
                    <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Vues</p>
                    <p class="text-3xl font-bold text-primary-900"><?php echo htmlspecialchars((string)($contenu['vues'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                </article>
                <article class="border-b border-gray-100 p-6 md:border-b-0 md:border-r">
                    <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Publication</p>
                    <p class="text-lg font-bold text-primary-900"><?php echo htmlspecialchars($publishedAt, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                </article>
                <article class="p-6">
                    <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Creation</p>
                    <p class="text-lg font-bold text-primary-900"><?php echo htmlspecialchars($createdAt, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                </article>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-4">
            <article class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm"><p class="text-xs uppercase tracking-[0.18em] text-gray-400">Likes</p><p class="mt-2 text-2xl font-bold text-primary-900"><?php echo htmlspecialchars((string)($contenu['likes_count'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p></article>
            <article class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm"><p class="text-xs uppercase tracking-[0.18em] text-gray-400">Commentaires</p><p class="mt-2 text-2xl font-bold text-primary-900"><?php echo htmlspecialchars((string)($contenu['commentaires_count'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p></article>
            <article class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm"><p class="text-xs uppercase tracking-[0.18em] text-gray-400">Partages</p><p class="mt-2 text-2xl font-bold text-primary-900"><?php echo htmlspecialchars((string)($contenu['partages_count'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p></article>
            <article class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm"><p class="text-xs uppercase tracking-[0.18em] text-gray-400">Favoris</p><p class="mt-2 text-2xl font-bold text-primary-900"><?php echo htmlspecialchars((string)($contenu['favoris_count'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p></article>
        </section>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
            <article class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm lg:p-8">
                <h3 class="mb-5 text-lg font-semibold text-primary-900">Corps du contenu</h3>
                <?php if ($body !== ''): ?>
                    <div class="prose max-w-none text-sm leading-7 text-gray-600">
                        <?php echo nl2br(htmlspecialchars($body, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')); ?>
                    </div>
                <?php else: ?>
                    <p class="text-sm text-gray-500">Aucun corps de contenu renseigne.</p>
                <?php endif; ?>
            </article>

            <aside class="space-y-6">
                <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-lg font-semibold text-primary-900">Details</h3>
                    <dl class="space-y-4 text-sm">
                        <div>
                            <dt class="text-xs uppercase tracking-[0.18em] text-gray-400">ID</dt>
                            <dd class="mt-1 font-semibold text-primary-900">#<?php echo htmlspecialchars((string)($contenu['id'] ?? '-'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></dd>
                        </div>
                        <div>
                            <dt class="text-xs uppercase tracking-[0.18em] text-gray-400">Categorie</dt>
                            <dd class="mt-1 font-semibold text-primary-900"><?php echo htmlspecialchars($contenu['categorie_nom'] ?? 'Sans categorie', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></dd>
                        </div>
                        <div>
                            <dt class="text-xs uppercase tracking-[0.18em] text-gray-400">Auteur</dt>
                            <dd class="mt-1 font-semibold text-primary-900"><?php echo htmlspecialchars($author, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></dd>
                        </div>
                    </dl>
                </section>
            </aside>
        </div>

        <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
            <h3 class="mb-5 text-lg font-semibold text-primary-900">Commentaires</h3>
            <?php if (!empty($commentaires)): ?>
                <div class="space-y-3">
                    <?php foreach ($commentaires as $commentaire): ?>
                        <div class="rounded-2xl border border-gray-100 p-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm leading-6 text-gray-600"><?php echo htmlspecialchars($commentaire['commentaire'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                                    <p class="mt-2 text-xs text-gray-400"><?php echo htmlspecialchars(($commentaire['ip_address'] ?? '-') . ' · ' . ($commentaire['date_creation'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                                </div>
                                <form method="POST" action="<?php echo BASE_URL; ?>contenu/deleteComment" onsubmit="return confirm('Supprimer ce commentaire ?')">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars((string)($commentaire['id'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                                    <button class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-red-50 hover:text-red-600"><i data-lucide="trash-2" class="h-4 w-4"></i></button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-sm text-gray-500">Aucun commentaire pour cette publication.</p>
            <?php endif; ?>
        </section>
    <?php else: ?>
        <section class="bg-white rounded-3xl border border-gray-100 p-10 text-center shadow-sm">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-3xl bg-red-50 text-red-600">
                <i data-lucide="file-x" class="w-7 h-7"></i>
            </div>
            <h3 class="text-xl font-bold text-primary-900 font-display">Publication introuvable</h3>
            <p class="mt-2 text-sm text-gray-500">Le contenu demande n'existe pas ou a ete supprime.</p>
            <a href="<?php echo BASE_URL; ?>contenu" class="mt-6 inline-flex items-center justify-center gap-2 rounded-2xl bg-primary-900 px-4 py-3 text-sm font-semibold text-white hover:bg-primary-800 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Retour aux publications
            </a>
        </section>
    <?php endif; ?>
</div>

<script>
    if (typeof renderIcons === 'function') renderIcons();
</script>
