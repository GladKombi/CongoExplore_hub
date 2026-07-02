<?php
$medias = $medias ?? [];
$contenus = $contenus ?? [];
$types = ['Photo', 'Video', 'Interview', 'Reportage'];
$mediaCounts = [];

foreach ($medias as $media) {
    $contentId = (int)($media['contenu_id'] ?? 0);
    $mediaCounts[$contentId] = ($mediaCounts[$contentId] ?? 0) + 1;
}
?>

<div class="space-y-6">
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
        <span class="inline-flex items-center gap-2 rounded-2xl bg-primary-900 px-4 py-2 font-semibold text-white shadow-sm">
            <i data-lucide="image" class="w-4 h-4"></i>
            Medias
        </span>
        <a href="<?php echo BASE_URL; ?>categorie" class="inline-flex items-center gap-2 rounded-2xl border border-gray-100 bg-white px-4 py-2 font-semibold text-gray-600 shadow-sm hover:text-primary-900 transition">
            <i data-lucide="folder" class="w-4 h-4"></i>
            Categories
        </a>
    </nav>

    <div class="grid gap-6 lg:grid-cols-4">
        <section class="lg:col-span-2 rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Media</p>
            <h2 class="font-display text-2xl font-bold text-primary-900">Bibliotheque media</h2>
            <p class="mt-2 text-sm text-gray-500">Suivi des fichiers rattaches aux publications.</p>
        </section>
        <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Total</p>
            <p class="text-3xl font-bold text-primary-900"><?php echo htmlspecialchars((string)count($medias), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
        </section>
        <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Limite</p>
            <p class="text-3xl font-bold text-primary-900">3</p>
            <p class="mt-2 text-sm text-gray-500">medias par contenu</p>
        </section>
    </div>

    <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
        <div class="mb-5 flex items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-primary-900">Ajouter un media</h3>
                <p class="mt-1 text-sm text-gray-500">Chaque contenu peut recevoir 3 medias maximum.</p>
            </div>
            <i data-lucide="image-plus" class="h-6 w-6 text-gold-600"></i>
        </div>
        <form method="POST" action="<?php echo BASE_URL; ?>media/create" enctype="multipart/form-data" class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_180px_minmax(0,1fr)_220px_auto] xl:items-end">
            <label class="block">
                <span class="text-sm font-semibold text-gray-700">Publication</span>
                <select name="contenu_id" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required>
                    <option value="">Choisir un contenu</option>
                    <?php foreach ($contenus as $contenu): ?>
                        <?php
                        $contentId = (int)($contenu['id'] ?? 0);
                        $count = $mediaCounts[$contentId] ?? 0;
                        ?>
                        <option value="<?php echo htmlspecialchars((string)$contentId, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" <?php echo $count >= 3 ? 'disabled' : ''; ?>>
                            <?php echo htmlspecialchars(($contenu['titre'] ?? '-') . ' (' . $count . '/3)', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="block">
                <span class="text-sm font-semibold text-gray-700">Type</span>
                <select name="type_media" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required>
                    <?php foreach ($types as $type): ?>
                        <option value="<?php echo htmlspecialchars($type, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"><?php echo htmlspecialchars($type, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="block">
                <span class="text-sm font-semibold text-gray-700">Image</span>
                <input id="media-file-input" name="fichier_media" type="file" accept="image/jpeg,image/png,image/webp,image/gif" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-2.5 text-sm outline-none file:mr-3 file:rounded-xl file:border-0 file:bg-primary-900 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white" required>
            </label>
            <div class="rounded-2xl border border-dashed border-gray-200 bg-gray-50 p-3">
                <div id="media-preview-empty" class="flex h-24 items-center justify-center text-center text-xs font-semibold text-gray-400">
                    Apercu image
                </div>
                <img id="media-preview" src="" alt="Apercu du media" class="hidden h-24 w-full rounded-xl object-cover">
            </div>
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-primary-900 px-4 py-3 text-sm font-semibold text-white hover:bg-primary-800 transition">
                <i data-lucide="plus" class="h-4 w-4"></i>
                Ajouter
            </button>
        </form>
    </section>

    <section class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[840px] text-left">
                <thead class="bg-gray-50 text-xs uppercase tracking-[0.18em] text-gray-400">
                    <tr>
                        <th class="px-5 py-4 font-semibold">Media</th>
                        <th class="px-5 py-4 font-semibold">Type</th>
                        <th class="px-5 py-4 font-semibold">Publication</th>
                        <th class="px-5 py-4 font-semibold">Creation</th>
                        <th class="px-5 py-4 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <?php if (!empty($medias)): ?>
                        <?php foreach ($medias as $media): ?>
                            <?php
                            $mediaUrl = (string)($media['url_fichier'] ?? '');
                            $mediaHref = preg_match('/^https?:\/\//i', $mediaUrl) ? $mediaUrl : BASE_URL . ltrim($mediaUrl, '/');
                            ?>
                            <tr class="hover:bg-gray-50/80 transition">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <a href="<?php echo htmlspecialchars($mediaHref, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" target="_blank" class="block h-12 w-12 overflow-hidden rounded-2xl bg-primary-50">
                                            <img src="<?php echo htmlspecialchars($mediaHref, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" alt="Media" class="h-full w-full object-cover">
                                        </a>
                                        <a href="<?php echo htmlspecialchars($mediaHref, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" class="max-w-[340px] truncate font-semibold text-primary-900 hover:text-gold-700" target="_blank">
                                            <?php echo htmlspecialchars($media['url_fichier'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                                        </a>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-gray-600"><?php echo htmlspecialchars($media['type_media'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                                <td class="px-5 py-4 text-gray-600"><?php echo htmlspecialchars($media['contenu_titre'] ?? 'Publication inconnue', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                                <td class="px-5 py-4 text-gray-500"><?php echo !empty($media['date_creation']) ? htmlspecialchars(date('d/m/Y', strtotime((string)$media['date_creation'])), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : '-'; ?></td>
                                <td class="px-5 py-4">
                                    <form method="POST" action="<?php echo BASE_URL; ?>media/delete" class="flex justify-end" onsubmit="return confirm('Supprimer ce media ?')">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars((string)($media['id'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                                        <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-red-50 hover:text-red-600 transition">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-sm text-gray-500">Aucun media.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<script>
    const mediaFileInput = document.getElementById('media-file-input');
    const mediaPreview = document.getElementById('media-preview');
    const mediaPreviewEmpty = document.getElementById('media-preview-empty');

    if (mediaFileInput) {
        mediaFileInput.addEventListener('change', () => {
            const file = mediaFileInput.files && mediaFileInput.files[0];

            if (!file) {
                mediaPreview.src = '';
                mediaPreview.classList.add('hidden');
                mediaPreviewEmpty.classList.remove('hidden');
                return;
            }

            mediaPreview.src = URL.createObjectURL(file);
            mediaPreview.classList.remove('hidden');
            mediaPreviewEmpty.classList.add('hidden');
        });
    }

    if (typeof renderIcons === 'function') renderIcons();
</script>
