<?php $projets = $projets ?? []; ?>

<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div><p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Client</p><h2 class="font-display text-2xl font-bold text-primary-900"><?php echo htmlspecialchars($title ?? 'Client', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></h2></div>
        <a href="<?php echo BASE_URL; ?>client" class="inline-flex w-fit items-center justify-center gap-2 rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-primary-900 shadow-sm hover:bg-primary-50 transition"><i data-lucide="arrow-left" class="h-4 w-4"></i>Retour aux clients</a>
    </div>
    <?php if (!empty($client)): ?>
        <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm lg:p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                <div><span class="mb-4 inline-flex rounded-full bg-primary-50 px-3 py-1 text-xs font-semibold text-primary-800"><?php echo htmlspecialchars($client['secteur_activite'] ?? 'Client', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span><h1 class="font-display text-3xl font-bold text-primary-900"><?php echo htmlspecialchars($client['nom_entreprise'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></h1><p class="mt-3 text-sm text-gray-500"><?php echo htmlspecialchars($client['email_contact'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?> · <?php echo htmlspecialchars($client['telephone'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p></div>
                <div class="flex h-20 w-20 items-center justify-center rounded-[1.75rem] bg-primary-50 text-primary-800"><i data-lucide="briefcase" class="h-9 w-9"></i></div>
            </div>
            <div class="mt-8 grid gap-4 md:grid-cols-2"><div class="rounded-2xl bg-gray-50 p-4"><p class="text-xs uppercase tracking-[0.18em] text-gray-400">Adresse</p><p class="mt-2 text-sm font-semibold text-primary-900"><?php echo htmlspecialchars($client['adresse'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p></div><div class="rounded-2xl bg-gray-50 p-4"><p class="text-xs uppercase tracking-[0.18em] text-gray-400">Projets</p><p class="mt-2 text-2xl font-bold text-primary-900"><?php echo count($projets); ?></p></div></div>
        </section>
        <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm"><h3 class="mb-4 text-lg font-semibold text-primary-900">Projets lies</h3><?php if (!empty($projets)): ?><div class="grid gap-4 md:grid-cols-2"><?php foreach ($projets as $projet): ?><a href="<?php echo BASE_URL; ?>projet/show/<?php echo urlencode((string)$projet['id']); ?>" class="rounded-2xl border border-gray-100 p-4 hover:bg-gray-50"><p class="font-semibold text-primary-900"><?php echo htmlspecialchars($projet['nom'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p><p class="mt-1 text-sm text-gray-500"><?php echo htmlspecialchars($projet['statut'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p></a><?php endforeach; ?></div><?php else: ?><p class="text-sm text-gray-500">Aucun projet pour ce client.</p><?php endif; ?></section>
    <?php else: ?>
        <section class="rounded-3xl border border-gray-100 bg-white p-10 text-center shadow-sm"><h3 class="font-display text-xl font-bold text-primary-900">Client introuvable</h3></section>
    <?php endif; ?>
</div>
<script>if (typeof renderIcons === 'function') renderIcons();</script>
