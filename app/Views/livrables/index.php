<?php
$livrables = $livrables ?? [];
$projets = $projets ?? [];
$statuses = ['A faire', 'En cours', 'Valide', 'Bloque'];
?>

<div class="space-y-6" id="deliverables-page">
    <style>
        #deliverable-modal[hidden] {
            display: none !important;
        }
    </style>
    <?php if (!empty($_SESSION['toast'])): ?><?php $toast = $_SESSION['toast']; unset($_SESSION['toast']); ?><div class="fixed right-6 top-20 z-50 flex items-center gap-3 rounded-2xl px-5 py-4 text-sm font-semibold shadow-2xl <?php echo ($toast['type'] ?? '') === 'error' ? 'bg-red-600 text-white' : 'bg-primary-900 text-white'; ?>"><i data-lucide="<?php echo ($toast['type'] ?? '') === 'error' ? 'circle-alert' : 'circle-check'; ?>" class="w-5 h-5"></i><span><?php echo htmlspecialchars($toast['message'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span></div><?php endif; ?>

    <nav class="flex flex-wrap items-center gap-2 text-sm">
        <a href="<?php echo BASE_URL; ?>client" class="inline-flex items-center gap-2 rounded-2xl border border-gray-100 bg-white px-4 py-2 font-semibold text-gray-600 shadow-sm hover:text-primary-900 transition"><i data-lucide="briefcase" class="w-4 h-4"></i>Clients</a>
        <a href="<?php echo BASE_URL; ?>projet" class="inline-flex items-center gap-2 rounded-2xl border border-gray-100 bg-white px-4 py-2 font-semibold text-gray-600 shadow-sm hover:text-primary-900 transition"><i data-lucide="target" class="w-4 h-4"></i>Projets</a>
        <span class="inline-flex items-center gap-2 rounded-2xl bg-primary-900 px-4 py-2 font-semibold text-white shadow-sm"><i data-lucide="check-square" class="w-4 h-4"></i>Livrables</span>
    </nav>

    <div class="grid gap-6 lg:grid-cols-4">
        <section class="lg:col-span-3 rounded-3xl border border-gray-100 bg-white p-6 shadow-sm"><div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between"><div><p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Marketing</p><h2 class="font-display text-2xl font-bold text-primary-900">Livrables</h2><p class="mt-2 max-w-xl text-sm text-gray-500">Suit les livrables associes aux projets marketing.</p></div><button type="button" onclick="openDeliverableModal()" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-primary-900 px-4 py-3 text-sm font-semibold text-white hover:bg-primary-800 transition"><i data-lucide="plus" class="w-4 h-4"></i>Nouveau livrable</button></div></section>
        <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm"><p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Total</p><p class="text-3xl font-bold text-primary-900"><?php echo count($livrables); ?></p></section>
    </div>

    <section class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[860px] text-left">
                <thead class="bg-gray-50 text-xs uppercase tracking-[0.18em] text-gray-400"><tr><th class="px-5 py-4">Livrable</th><th class="px-5 py-4">Projet</th><th class="px-5 py-4">Client</th><th class="px-5 py-4">Echeance</th><th class="px-5 py-4">Statut</th><th class="px-5 py-4 text-right">Actions</th></tr></thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <?php if (!empty($livrables)): ?><?php foreach ($livrables as $livrable): ?>
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-5 py-4"><div class="font-semibold text-primary-900"><?php echo htmlspecialchars($livrable['titre'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div><div class="max-w-[320px] truncate text-xs text-gray-400"><?php echo htmlspecialchars($livrable['description'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div></td>
                            <td class="px-5 py-4 text-gray-600"><?php echo htmlspecialchars($livrable['projet_nom'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                            <td class="px-5 py-4 text-gray-600"><?php echo htmlspecialchars($livrable['client_nom'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                            <td class="px-5 py-4 text-gray-600"><?php echo htmlspecialchars($livrable['date_echeance'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                            <td class="px-5 py-4"><span class="rounded-full border border-primary-100 bg-primary-50 px-3 py-1 text-xs font-semibold text-primary-800"><?php echo htmlspecialchars($livrable['statut'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span></td>
                            <td class="px-5 py-4"><div class="flex justify-end gap-2"><button type="button" onclick='openDeliverableModal(<?php echo json_encode($livrable, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>)' class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-gold-50 hover:text-gold-700"><i data-lucide="pencil" class="h-4 w-4"></i></button><form method="POST" action="<?php echo BASE_URL; ?>livrable/delete" onsubmit="return confirm('Supprimer ce livrable ?')"><input type="hidden" name="id" value="<?php echo htmlspecialchars((string)$livrable['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"><button class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-red-50 hover:text-red-600"><i data-lucide="trash-2" class="h-4 w-4"></i></button></form></div></td>
                        </tr>
                    <?php endforeach; ?><?php else: ?><tr><td colspan="6" class="px-5 py-12 text-center text-sm text-gray-500">Aucun livrable.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <div id="deliverable-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-primary-950/40 px-4 backdrop-blur-sm" hidden>
        <div class="w-full max-w-xl rounded-3xl bg-white p-6 shadow-2xl">
            <div class="mb-6 flex items-start justify-between"><div><p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Livrable</p><h3 id="deliverable-modal-title" class="font-display text-xl font-bold text-primary-900">Nouveau livrable</h3></div><button type="button" onclick="closeDeliverableModal()" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl text-gray-400 hover:bg-gray-50"><i data-lucide="x" class="h-5 w-5"></i></button></div>
            <form id="deliverable-form" method="POST" action="<?php echo BASE_URL; ?>livrable/create" class="space-y-4">
                <input type="hidden" id="deliverable-id" name="id">
                <label class="block"><span class="text-sm font-semibold text-gray-700">Titre</span><input id="deliverable-title" name="titre" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required></label>
                <label class="block"><span class="text-sm font-semibold text-gray-700">Projet</span><select id="deliverable-project" name="projet_id" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required><option value="">Choisir</option><?php foreach ($projets as $projet): ?><option value="<?php echo htmlspecialchars((string)$projet['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"><?php echo htmlspecialchars($projet['nom'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></option><?php endforeach; ?></select></label>
                <div class="grid gap-4 sm:grid-cols-2"><label class="block"><span class="text-sm font-semibold text-gray-700">Echeance</span><input id="deliverable-date" name="date_echeance" type="date" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required></label><label class="block"><span class="text-sm font-semibold text-gray-700">Statut</span><select id="deliverable-status" name="statut" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required><?php foreach ($statuses as $status): ?><option value="<?php echo htmlspecialchars($status, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"><?php echo htmlspecialchars($status, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></option><?php endforeach; ?></select></label></div>
                <label class="block"><span class="text-sm font-semibold text-gray-700">Description</span><textarea id="deliverable-description" name="description" rows="3" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none"></textarea></label>
                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end"><button type="button" onclick="closeDeliverableModal()" class="rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50">Annuler</button><button class="rounded-2xl bg-primary-900 px-4 py-3 text-sm font-semibold text-white hover:bg-primary-800">Enregistrer</button></div>
            </form>
        </div>
    </div>
</div>

<script>
function openDeliverableModal(deliverable = null) { const form = document.getElementById('deliverable-form'); const modal = document.getElementById('deliverable-modal'); form.reset(); form.action = deliverable ? '<?php echo BASE_URL; ?>livrable/update' : '<?php echo BASE_URL; ?>livrable/create'; document.getElementById('deliverable-id').value = deliverable?.id || ''; document.getElementById('deliverable-title').value = deliverable?.titre || ''; document.getElementById('deliverable-project').value = deliverable?.projet_id || ''; document.getElementById('deliverable-date').value = deliverable?.date_echeance || ''; document.getElementById('deliverable-status').value = deliverable?.statut || 'A faire'; document.getElementById('deliverable-description').value = deliverable?.description || ''; document.getElementById('deliverable-modal-title').textContent = deliverable ? 'Modifier le livrable' : 'Nouveau livrable'; modal.hidden = false; modal.style.display = 'flex'; document.body.classList.add('overflow-hidden'); if (typeof renderIcons === 'function') renderIcons(); }
function closeDeliverableModal() { const modal = document.getElementById('deliverable-modal'); modal.hidden = true; modal.style.display = 'none'; document.body.classList.remove('overflow-hidden'); }
closeDeliverableModal();
document.getElementById('deliverable-modal').addEventListener('click', (event) => { if (event.target.id === 'deliverable-modal') closeDeliverableModal(); });
if (typeof renderIcons === 'function') renderIcons();
</script>
