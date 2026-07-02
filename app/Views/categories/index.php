<?php
$categories = $categories ?? [];
?>

<div class="space-y-6" id="categories-page">
    <?php if (!empty($_SESSION['toast'])): ?>
        <?php $toast = $_SESSION['toast']; unset($_SESSION['toast']); ?>
        <div class="fixed right-6 top-20 z-50 flex items-center gap-3 rounded-2xl px-5 py-4 text-sm font-semibold shadow-2xl <?php echo ($toast['type'] ?? '') === 'error' ? 'bg-red-600 text-white' : 'bg-primary-900 text-white'; ?>">
            <i data-lucide="<?php echo ($toast['type'] ?? '') === 'error' ? 'circle-alert' : 'circle-check'; ?>" class="w-5 h-5"></i>
            <span><?php echo htmlspecialchars($toast['message'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
        </div>
    <?php endif; ?>

    <nav class="flex flex-wrap items-center gap-2 text-sm">
        <a href="<?php echo BASE_URL; ?>contenu" class="inline-flex items-center gap-2 rounded-2xl border border-gray-100 bg-white px-4 py-2 font-semibold text-gray-600 shadow-sm hover:text-primary-900 transition">
            <i data-lucide="newspaper" class="w-4 h-4"></i>
            Publications
        </a>
        <a href="<?php echo BASE_URL; ?>media" class="inline-flex items-center gap-2 rounded-2xl border border-gray-100 bg-white px-4 py-2 font-semibold text-gray-600 shadow-sm hover:text-primary-900 transition">
            <i data-lucide="image" class="w-4 h-4"></i>
            Medias
        </a>
        <span class="inline-flex items-center gap-2 rounded-2xl bg-primary-900 px-4 py-2 font-semibold text-white shadow-sm">
            <i data-lucide="folder" class="w-4 h-4"></i>
            Categories
        </span>
    </nav>

    <div class="grid gap-6 lg:grid-cols-4">
        <section class="lg:col-span-3 rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Media</p>
            <h2 class="font-display text-2xl font-bold text-primary-900">Categories</h2>
            <p class="mt-2 text-sm text-gray-500">Organise les publications par themes editoriaux.</p>
        </section>
        <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Total</p>
            <p class="text-3xl font-bold text-primary-900"><?php echo htmlspecialchars((string)count($categories), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
        </section>
    </div>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
        <section class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
            <div class="border-b border-gray-100 p-5">
                <h3 class="text-lg font-semibold text-primary-900">Liste des categories</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[620px] text-left">
                    <thead class="bg-gray-50 text-xs uppercase tracking-[0.18em] text-gray-400">
                        <tr>
                            <th class="px-5 py-4 font-semibold">Categorie</th>
                            <th class="px-5 py-4 font-semibold">Creation</th>
                            <th class="px-5 py-4 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <tr class="hover:bg-gray-50/80 transition">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-primary-50 text-primary-700">
                                                <i data-lucide="folder" class="w-5 h-5"></i>
                                            </span>
                                            <span class="font-semibold text-primary-900"><?php echo htmlspecialchars($category['nom'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-gray-500"><?php echo !empty($category['date_creation']) ? htmlspecialchars(date('d/m/Y', strtotime((string)$category['date_creation'])), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : '-'; ?></td>
                                    <td class="px-5 py-4">
                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick='editCategory(<?php echo json_encode($category, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>)' class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-gold-50 hover:text-gold-700 transition">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>
                                            <form method="POST" action="<?php echo BASE_URL; ?>categorie/delete" onsubmit="return confirm('Supprimer cette categorie ?')">
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars((string)($category['id'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                                                <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-red-50 hover:text-red-600 transition">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="px-5 py-12 text-center text-sm text-gray-500">Aucune categorie.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
            <h3 id="category-form-title" class="mb-4 text-lg font-semibold text-primary-900">Ajouter une categorie</h3>
            <form id="category-form" method="POST" action="<?php echo BASE_URL; ?>categorie/create" class="space-y-4">
                <input type="hidden" id="category-id" name="id">
                <label class="block">
                    <span class="text-sm font-semibold text-gray-700">Nom</span>
                    <input id="category-name" name="nom" type="text" minlength="2" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required>
                </label>
                <div class="flex gap-3">
                    <button type="button" onclick="resetCategoryForm()" class="rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">Annuler</button>
                    <button type="submit" class="rounded-2xl bg-primary-900 px-4 py-3 text-sm font-semibold text-white hover:bg-primary-800 transition">Enregistrer</button>
                </div>
            </form>
        </aside>
    </div>
</div>

<script>
    function editCategory(category) {
        document.getElementById('category-form').action = '<?php echo BASE_URL; ?>categorie/update';
        document.getElementById('category-id').value = category.id || '';
        document.getElementById('category-name').value = category.nom || '';
        document.getElementById('category-form-title').textContent = 'Modifier la categorie';
    }

    function resetCategoryForm() {
        document.getElementById('category-form').action = '<?php echo BASE_URL; ?>categorie/create';
        document.getElementById('category-id').value = '';
        document.getElementById('category-name').value = '';
        document.getElementById('category-form-title').textContent = 'Ajouter une categorie';
    }

    if (typeof renderIcons === 'function') renderIcons();
</script>
