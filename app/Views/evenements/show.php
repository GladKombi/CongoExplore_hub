<?php
$medias = $medias ?? [];
?>

<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Evenement</p>
            <h2 class="font-display text-2xl font-bold text-primary-900"><?php echo htmlspecialchars($title ?? 'Evenement', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></h2>
        </div>
        <a href="<?php echo BASE_URL; ?>evenement" class="inline-flex w-fit items-center justify-center gap-2 rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-primary-900 shadow-sm hover:bg-primary-50 transition">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Retour aux evenements
        </a>
    </div>

    <?php if (!empty($evenement)): ?>
        <?php
        $start = !empty($evenement['date_debut']) ? date('d/m/Y H:i', strtotime((string)$evenement['date_debut'])) : '-';
        $end = !empty($evenement['date_fin']) ? date('d/m/Y H:i', strtotime((string)$evenement['date_fin'])) : '-';
        ?>
        <section class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
            <div class="border-b border-gray-100 p-6 lg:p-8">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="mb-5 inline-flex rounded-full border border-primary-100 bg-primary-50 px-3 py-1 text-xs font-semibold text-primary-800">
                            <?php echo htmlspecialchars($evenement['type_evenement'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                        </span>
                        <h1 class="font-display text-3xl font-bold leading-tight text-primary-900 lg:text-4xl"><?php echo htmlspecialchars($evenement['titre'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></h1>
                        <p class="mt-4 text-sm text-gray-500"><?php echo htmlspecialchars($evenement['client_nom'] ?? 'Evenement interne', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                    </div>
                    <div class="flex h-20 w-20 flex-shrink-0 items-center justify-center rounded-[1.75rem] bg-primary-50 text-primary-800">
                        <i data-lucide="calendar" class="h-9 w-9"></i>
                    </div>
                </div>
            </div>
            <div class="grid gap-0 md:grid-cols-3">
                <article class="border-b border-gray-100 p-6 md:border-b-0 md:border-r">
                    <p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Debut</p>
                    <p class="text-lg font-bold text-primary-900"><?php echo htmlspecialchars($start, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                </article>
                <article class="border-b border-gray-100 p-6 md:border-b-0 md:border-r">
                    <p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Fin</p>
                    <p class="text-lg font-bold text-primary-900"><?php echo htmlspecialchars($end, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                </article>
                <article class="p-6">
                    <p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Lieu</p>
                    <p class="text-lg font-bold text-primary-900"><?php echo htmlspecialchars($evenement['lieu'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                </article>
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_340px]">
            <article class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm lg:p-8">
                <h3 class="mb-5 text-lg font-semibold text-primary-900">Description</h3>
                <p class="whitespace-pre-line text-sm leading-7 text-gray-600"><?php echo htmlspecialchars($evenement['description'] ?? 'Aucune description.', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
            </article>
            <aside class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-semibold text-primary-900">Client</h3>
                <p class="font-semibold text-primary-900"><?php echo htmlspecialchars($evenement['client_nom'] ?? 'Interne', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                <?php if (!empty($evenement['client_email'])): ?><p class="mt-2 text-sm text-gray-500"><?php echo htmlspecialchars($evenement['client_email'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p><?php endif; ?>
                <?php if (!empty($evenement['client_telephone'])): ?><p class="mt-1 text-sm text-gray-500"><?php echo htmlspecialchars($evenement['client_telephone'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p><?php endif; ?>
            </aside>
        </div>

        <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
            <h3 class="mb-5 text-lg font-semibold text-primary-900">Medias</h3>
            <?php if (!empty($medias)): ?>
                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    <?php foreach ($medias as $media): ?>
                        <?php $mediaUrl = BASE_URL . ltrim((string)($media['url_fichier'] ?? ''), '/'); ?>
                        <a href="<?php echo htmlspecialchars($mediaUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" target="_blank" class="group overflow-hidden rounded-3xl border border-gray-100 bg-gray-50">
                            <img src="<?php echo htmlspecialchars($mediaUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" alt="Media evenement" class="h-44 w-full object-cover transition group-hover:scale-105">
                            <div class="p-4 text-sm font-semibold text-primary-900"><?php echo htmlspecialchars($media['type_media'] ?? 'Media', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-sm text-gray-500">Aucun media rattache a cet evenement.</p>
            <?php endif; ?>
        </section>
    <?php else: ?>
        <section class="rounded-3xl border border-gray-100 bg-white p-10 text-center shadow-sm">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-3xl bg-red-50 text-red-600">
                <i data-lucide="calendar-x" class="h-7 w-7"></i>
            </div>
            <h3 class="font-display text-xl font-bold text-primary-900">Evenement introuvable</h3>
            <p class="mt-2 text-sm text-gray-500">L’evenement demande n’existe pas ou a ete supprime.</p>
        </section>
    <?php endif; ?>
</div>

<script>
    if (typeof renderIcons === 'function') renderIcons();
</script>
