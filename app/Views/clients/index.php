<?php
$clients = $clients ?? [];
$projets = $projets ?? [];
?>

<div class="space-y-6" id="clients-page">
    <style>
        #client-modal[hidden] {
            display: none !important;
        }
    </style>
    <?php if (!empty($_SESSION['toast'])): ?>
        <?php $toast = $_SESSION['toast']; unset($_SESSION['toast']); ?>
        <div class="fixed right-6 top-20 z-50 flex items-center gap-3 rounded-2xl px-5 py-4 text-sm font-semibold shadow-2xl <?php echo ($toast['type'] ?? '') === 'error' ? 'bg-red-600 text-white' : 'bg-primary-900 text-white'; ?>">
            <i data-lucide="<?php echo ($toast['type'] ?? '') === 'error' ? 'circle-alert' : 'circle-check'; ?>" class="w-5 h-5"></i>
            <span><?php echo htmlspecialchars($toast['message'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
        </div>
    <?php endif; ?>

    <nav class="flex flex-wrap items-center gap-2 text-sm">
        <span class="inline-flex items-center gap-2 rounded-2xl bg-primary-900 px-4 py-2 font-semibold text-white shadow-sm"><i data-lucide="briefcase" class="w-4 h-4"></i>Clients</span>
        <a href="<?php echo BASE_URL; ?>projet" class="inline-flex items-center gap-2 rounded-2xl border border-gray-100 bg-white px-4 py-2 font-semibold text-gray-600 shadow-sm hover:text-primary-900 transition"><i data-lucide="target" class="w-4 h-4"></i>Projets</a>
        <a href="<?php echo BASE_URL; ?>livrable" class="inline-flex items-center gap-2 rounded-2xl border border-gray-100 bg-white px-4 py-2 font-semibold text-gray-600 shadow-sm hover:text-primary-900 transition"><i data-lucide="check-square" class="w-4 h-4"></i>Livrables</a>
    </nav>

    <div class="grid gap-6 lg:grid-cols-4">
        <section class="lg:col-span-2 rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Marketing</p>
                    <h2 class="font-display text-2xl font-bold text-primary-900">Clients</h2>
                    <p class="mt-2 max-w-xl text-sm text-gray-500">Gere les comptes clients lies aux campagnes et evenements.</p>
                </div>
                <button type="button" onclick="openClientModal()" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-primary-900 px-4 py-3 text-sm font-semibold text-white hover:bg-primary-800 transition"><i data-lucide="plus" class="w-4 h-4"></i>Nouveau client</button>
            </div>
        </section>
        <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm"><p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Clients</p><p class="text-3xl font-bold text-primary-900"><?php echo count($clients); ?></p></section>
        <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm"><p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Projets</p><p class="text-3xl font-bold text-primary-900"><?php echo count($projets); ?></p></section>
    </div>

    <section class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[860px] text-left">
                <thead class="bg-gray-50 text-xs uppercase tracking-[0.18em] text-gray-400">
                    <tr><th class="px-5 py-4">Entreprise</th><th class="px-5 py-4">Secteur</th><th class="px-5 py-4">Contact</th><th class="px-5 py-4">Projets</th><th class="px-5 py-4 text-right">Actions</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <?php if (!empty($clients)): ?>
                        <?php foreach ($clients as $client): ?>
                            <?php $countProjects = count(array_filter($projets, static fn($p) => (int)($p['client_id'] ?? 0) === (int)($client['id'] ?? 0))); ?>
                            <tr class="hover:bg-gray-50/80 transition">
                                <td class="px-5 py-4"><div class="font-semibold text-primary-900"><?php echo htmlspecialchars($client['nom_entreprise'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div><div class="text-xs text-gray-400">ID #<?php echo htmlspecialchars((string)($client['id'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div></td>
                                <td class="px-5 py-4 text-gray-600"><?php echo htmlspecialchars($client['secteur_activite'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                                <td class="px-5 py-4 text-gray-600"><?php echo htmlspecialchars($client['email_contact'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?><br><span class="text-xs text-gray-400"><?php echo htmlspecialchars($client['telephone'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span></td>
                                <td class="px-5 py-4 font-semibold text-primary-900"><?php echo $countProjects; ?></td>
                                <td class="px-5 py-4"><div class="flex justify-end gap-2"><a href="<?php echo BASE_URL; ?>client/show/<?php echo urlencode((string)$client['id']); ?>" class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-primary-50 hover:text-primary-800"><i data-lucide="eye" class="h-4 w-4"></i></a><button type="button" onclick='openClientModal(<?php echo json_encode($client, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>)' class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-gold-50 hover:text-gold-700"><i data-lucide="pencil" class="h-4 w-4"></i></button><form method="POST" action="<?php echo BASE_URL; ?>client/delete" onsubmit="return confirm('Supprimer ce client ?')"><input type="hidden" name="id" value="<?php echo htmlspecialchars((string)$client['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"><button class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-red-50 hover:text-red-600"><i data-lucide="trash-2" class="h-4 w-4"></i></button></form></div></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="px-5 py-12 text-center text-sm text-gray-500">Aucun client.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <div id="client-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-primary-950/40 px-4 backdrop-blur-sm" hidden>
        <div class="w-full max-w-xl rounded-3xl bg-white p-6 shadow-2xl">
            <div class="mb-6 flex items-start justify-between"><div><p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Client</p><h3 id="client-modal-title" class="font-display text-xl font-bold text-primary-900">Nouveau client</h3></div><button type="button" onclick="closeClientModal()" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl text-gray-400 hover:bg-gray-50"><i data-lucide="x" class="h-5 w-5"></i></button></div>
            <form id="client-form" method="POST" action="<?php echo BASE_URL; ?>client/create" class="space-y-4">
                <input type="hidden" id="client-id" name="id">
                <label class="block"><span class="text-sm font-semibold text-gray-700">Entreprise</span><input id="client-name" name="nom_entreprise" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required></label>
                <div class="grid gap-4 sm:grid-cols-2"><label class="block"><span class="text-sm font-semibold text-gray-700">Secteur</span><input id="client-sector" name="secteur_activite" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none"></label><label class="block"><span class="text-sm font-semibold text-gray-700">Telephone</span><input id="client-phone" name="telephone" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none"></label></div>
                <label class="block"><span class="text-sm font-semibold text-gray-700">Email</span><input id="client-email" name="email_contact" type="email" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required></label>
                <label class="block"><span class="text-sm font-semibold text-gray-700">Adresse</span><textarea id="client-address" name="adresse" rows="3" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none"></textarea></label>
                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end"><button type="button" onclick="closeClientModal()" class="rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50">Annuler</button><button class="rounded-2xl bg-primary-900 px-4 py-3 text-sm font-semibold text-white hover:bg-primary-800">Enregistrer</button></div>
            </form>
        </div>
    </div>
</div>

<script>
    function openClientModal(client = null) {
        const form = document.getElementById('client-form');
        const modal = document.getElementById('client-modal');
        form.reset();
        form.action = client ? '<?php echo BASE_URL; ?>client/update' : '<?php echo BASE_URL; ?>client/create';
        document.getElementById('client-id').value = client?.id || '';
        document.getElementById('client-name').value = client?.nom_entreprise || '';
        document.getElementById('client-sector').value = client?.secteur_activite || '';
        document.getElementById('client-email').value = client?.email_contact || '';
        document.getElementById('client-phone').value = client?.telephone || '';
        document.getElementById('client-address').value = client?.adresse || '';
        document.getElementById('client-modal-title').textContent = client ? 'Modifier le client' : 'Nouveau client';
        modal.hidden = false;
        modal.style.display = 'flex';
        document.body.classList.add('overflow-hidden');
        if (typeof renderIcons === 'function') renderIcons();
    }
    function closeClientModal() {
        const modal = document.getElementById('client-modal');
        modal.hidden = true;
        modal.style.display = 'none';
        document.body.classList.remove('overflow-hidden');
    }
    closeClientModal();
    document.getElementById('client-modal').addEventListener('click', (event) => { if (event.target.id === 'client-modal') closeClientModal(); });
    if (typeof renderIcons === 'function') renderIcons();
</script>
