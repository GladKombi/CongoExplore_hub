<?php
$projets = $projets ?? [];
$clients = $clients ?? [];
$livrables = $livrables ?? [];
$types = ['Digital', 'Physique', 'Influence', 'Street Marketing', '360'];
$statuses = ['En attente', 'En cours', 'Termine', 'Annule'];
?>

<div class="space-y-6" id="projects-page">
    <style>
        #project-modal[hidden] {
            display: none !important;
        }
    </style>
    <?php if (!empty($_SESSION['toast'])): ?><?php $toast = $_SESSION['toast']; unset($_SESSION['toast']); ?><div class="fixed right-6 top-20 z-50 flex items-center gap-3 rounded-2xl px-5 py-4 text-sm font-semibold shadow-2xl <?php echo ($toast['type'] ?? '') === 'error' ? 'bg-red-600 text-white' : 'bg-primary-900 text-white'; ?>"><i data-lucide="<?php echo ($toast['type'] ?? '') === 'error' ? 'circle-alert' : 'circle-check'; ?>" class="w-5 h-5"></i><span><?php echo htmlspecialchars($toast['message'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span></div><?php endif; ?>

    <nav class="flex flex-wrap items-center gap-2 text-sm">
        <a href="<?php echo BASE_URL; ?>client" class="inline-flex items-center gap-2 rounded-2xl border border-gray-100 bg-white px-4 py-2 font-semibold text-gray-600 shadow-sm hover:text-primary-900 transition"><i data-lucide="briefcase" class="w-4 h-4"></i>Clients</a>
        <span class="inline-flex items-center gap-2 rounded-2xl bg-primary-900 px-4 py-2 font-semibold text-white shadow-sm"><i data-lucide="target" class="w-4 h-4"></i>Projets</span>
        <a href="<?php echo BASE_URL; ?>livrable" class="inline-flex items-center gap-2 rounded-2xl border border-gray-100 bg-white px-4 py-2 font-semibold text-gray-600 shadow-sm hover:text-primary-900 transition"><i data-lucide="check-square" class="w-4 h-4"></i>Livrables</a>
    </nav>

    <div class="grid gap-6 lg:grid-cols-4">
        <section class="lg:col-span-2 rounded-3xl border border-gray-100 bg-white p-6 shadow-sm"><div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between"><div><p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Marketing</p><h2 class="font-display text-2xl font-bold text-primary-900">Projets marketing</h2><p class="mt-2 max-w-xl text-sm text-gray-500">Pilote les campagnes, budgets, statuts et livrables.</p></div><button type="button" onclick="openProjectModal()" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-primary-900 px-4 py-3 text-sm font-semibold text-white hover:bg-primary-800 transition"><i data-lucide="plus" class="w-4 h-4"></i>Nouveau projet</button></div></section>
        <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm"><p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Projets</p><p class="text-3xl font-bold text-primary-900"><?php echo count($projets); ?></p></section>
        <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm"><p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Livrables</p><p class="text-3xl font-bold text-primary-900"><?php echo count($livrables); ?></p></section>
    </div>

    <section class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[980px] text-left">
                <thead class="bg-gray-50 text-xs uppercase tracking-[0.18em] text-gray-400"><tr><th class="px-5 py-4">Projet</th><th class="px-5 py-4">Client</th><th class="px-5 py-4">Type</th><th class="px-5 py-4">Budget</th><th class="px-5 py-4">Statut</th><th class="px-5 py-4">Livrables</th><th class="px-5 py-4 text-right">Actions</th></tr></thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <?php if (!empty($projets)): ?><?php foreach ($projets as $projet): ?><?php $countDeliverables = count(array_filter($livrables, static fn($l) => (int)($l['projet_id'] ?? 0) === (int)($projet['id'] ?? 0))); ?>
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-5 py-4"><div class="font-semibold text-primary-900"><?php echo htmlspecialchars($projet['nom'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div><div class="text-xs text-gray-400"><?php echo htmlspecialchars(($projet['date_debut'] ?? '-') . ' -> ' . ($projet['date_fin'] ?? '-'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div></td>
                            <td class="px-5 py-4 text-gray-600"><?php echo htmlspecialchars($projet['client_nom'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                            <td class="px-5 py-4 text-gray-600"><?php echo htmlspecialchars($projet['type_campagne'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                            <td class="px-5 py-4 font-semibold text-primary-900"><?php echo htmlspecialchars(number_format((float)($projet['budget'] ?? 0), 2, ',', ' '), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                            <td class="px-5 py-4"><span class="rounded-full border border-primary-100 bg-primary-50 px-3 py-1 text-xs font-semibold text-primary-800"><?php echo htmlspecialchars($projet['statut'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span></td>
                            <td class="px-5 py-4 font-semibold text-primary-900"><?php echo $countDeliverables; ?></td>
                            <td class="px-5 py-4"><div class="flex justify-end gap-2"><a href="<?php echo BASE_URL; ?>projet/show/<?php echo urlencode((string)$projet['id']); ?>" class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-primary-50 hover:text-primary-800"><i data-lucide="eye" class="h-4 w-4"></i></a><button type="button" onclick='openProjectModal(<?php echo json_encode($projet, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>)' class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-gold-50 hover:text-gold-700"><i data-lucide="pencil" class="h-4 w-4"></i></button><form method="POST" action="<?php echo BASE_URL; ?>projet/delete" onsubmit="return confirm('Supprimer ce projet ?')"><input type="hidden" name="id" value="<?php echo htmlspecialchars((string)$projet['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"><button class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-red-50 hover:text-red-600"><i data-lucide="trash-2" class="h-4 w-4"></i></button></form></div></td>
                        </tr>
                    <?php endforeach; ?><?php else: ?><tr><td colspan="7" class="px-5 py-12 text-center text-sm text-gray-500">Aucun projet.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <div id="project-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-primary-950/40 px-4 backdrop-blur-sm" hidden>
        <div class="max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-3xl bg-white p-6 shadow-2xl">
            <div class="mb-6 flex items-start justify-between"><div><p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Projet</p><h3 id="project-modal-title" class="font-display text-xl font-bold text-primary-900">Nouveau projet</h3></div><button type="button" onclick="closeProjectModal()" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl text-gray-400 hover:bg-gray-50"><i data-lucide="x" class="h-5 w-5"></i></button></div>
            <form id="project-form" method="POST" action="<?php echo BASE_URL; ?>projet/create" class="space-y-4">
                <input type="hidden" id="project-id" name="id">
                <label class="block"><span class="text-sm font-semibold text-gray-700">Nom</span><input id="project-name" name="nom" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required></label>
                <div class="grid gap-4 sm:grid-cols-2"><label class="block"><span class="text-sm font-semibold text-gray-700">Client</span><select id="project-client" name="client_id" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required><option value="">Choisir</option><?php foreach ($clients as $client): ?><option value="<?php echo htmlspecialchars((string)$client['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"><?php echo htmlspecialchars($client['nom_entreprise'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></option><?php endforeach; ?></select></label><label class="block"><span class="text-sm font-semibold text-gray-700">Type</span><select id="project-type" name="type_campagne" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required><?php foreach ($types as $type): ?><option value="<?php echo htmlspecialchars($type, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"><?php echo htmlspecialchars($type, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></option><?php endforeach; ?></select></label></div>
                <div class="grid gap-4 sm:grid-cols-3"><label class="block"><span class="text-sm font-semibold text-gray-700">Budget</span><input id="project-budget" name="budget" type="number" step="0.01" min="0" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none"></label><label class="block"><span class="text-sm font-semibold text-gray-700">Debut</span><input id="project-start" name="date_debut" type="date" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none"></label><label class="block"><span class="text-sm font-semibold text-gray-700">Fin</span><input id="project-end" name="date_fin" type="date" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none"></label></div>
                <label class="block"><span class="text-sm font-semibold text-gray-700">Statut</span><select id="project-status" name="statut" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required><?php foreach ($statuses as $status): ?><option value="<?php echo htmlspecialchars($status, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"><?php echo htmlspecialchars($status, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></option><?php endforeach; ?></select></label>
                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end"><button type="button" onclick="closeProjectModal()" class="rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50">Annuler</button><button class="rounded-2xl bg-primary-900 px-4 py-3 text-sm font-semibold text-white hover:bg-primary-800">Enregistrer</button></div>
            </form>
        </div>
    </div>
</div>

<script>
function openProjectModal(project = null) { const form = document.getElementById('project-form'); const modal = document.getElementById('project-modal'); form.reset(); form.action = project ? '<?php echo BASE_URL; ?>projet/update' : '<?php echo BASE_URL; ?>projet/create'; document.getElementById('project-id').value = project?.id || ''; document.getElementById('project-name').value = project?.nom || ''; document.getElementById('project-client').value = project?.client_id || ''; document.getElementById('project-type').value = project?.type_campagne || 'Digital'; document.getElementById('project-budget').value = project?.budget || ''; document.getElementById('project-start').value = project?.date_debut || ''; document.getElementById('project-end').value = project?.date_fin || ''; document.getElementById('project-status').value = project?.statut || 'En attente'; document.getElementById('project-modal-title').textContent = project ? 'Modifier le projet' : 'Nouveau projet'; modal.hidden = false; modal.style.display = 'flex'; document.body.classList.add('overflow-hidden'); if (typeof renderIcons === 'function') renderIcons(); }
function closeProjectModal() { const modal = document.getElementById('project-modal'); modal.hidden = true; modal.style.display = 'none'; document.body.classList.remove('overflow-hidden'); }
closeProjectModal();
document.getElementById('project-modal').addEventListener('click', (event) => { if (event.target.id === 'project-modal') closeProjectModal(); });
if (typeof renderIcons === 'function') renderIcons();
</script>
