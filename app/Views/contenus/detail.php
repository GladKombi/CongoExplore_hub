<?php
$contenu = $contenu ?? null;
$commentaires = $commentaires ?? [];
$categories = $categories ?? [];
$medias = $medias ?? [];
$title = $title ?? 'Publication';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?> - Congo Explorer Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {900: '#172b27', 800: '#213d37', 700: '#2c5149', 50: '#edf5f2'},
                        gold: {500: '#d5a021', 100: '#fbf0ce', 50: '#fff8e8'}
                    },
                    fontFamily: {
                        display: ['Georgia', 'serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#f7f4ee] text-primary-900">
    <header class="sticky top-0 z-40 border-b border-white/70 bg-primary-900/95 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="<?php echo BASE_URL; ?>" class="flex items-center gap-3 text-white">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gold-500 font-bold text-primary-900">CE</span>
                <span class="font-semibold">Congo Explorer Hub</span>
            </a>
            <a href="<?php echo BASE_URL; ?>#feed" class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/15">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Fil d'actualite
            </a>
        </div>
    </header>

    <main class="mx-auto grid max-w-6xl gap-6 px-4 py-8 sm:px-6 lg:grid-cols-[320px_minmax(0,1fr)] lg:px-8 lg:py-12">
        <?php if (!empty($contenu)): ?>
            <?php
            $author = trim(($contenu['auteur_prenom'] ?? '') . ' ' . ($contenu['auteur_nom'] ?? '')) ?: 'Congo Explorer Hub';
            $image = !empty($contenu['media_url']) ? BASE_URL . ltrim((string)$contenu['media_url'], '/') : 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?w=1200&h=800&fit=crop';
            $mediaSlides = [];
            foreach ($medias as $media) {
                if (!empty($media['url_fichier'])) {
                    $mediaSlides[] = [
                        'url' => BASE_URL . ltrim((string)$media['url_fichier'], '/'),
                        'type' => $media['type_media'] ?? 'Media',
                    ];
                }
            }
            if (empty($mediaSlides)) {
                $mediaSlides[] = ['url' => $image, 'type' => 'Image'];
            }
            $publishedAt = !empty($contenu['date_publication']) ? date('d/m/Y H:i', strtotime((string)$contenu['date_publication'])) : date('d/m/Y H:i', strtotime((string)($contenu['created_at'] ?? 'now')));
            $body = trim((string)($contenu['corps_text'] ?? ''));
            ?>
            <article class="overflow-hidden rounded-[2rem] bg-white shadow-sm lg:col-start-2 lg:row-start-1">
                <div class="relative overflow-hidden bg-primary-900" id="media-carousel">
                    <div class="flex transition-transform duration-500 ease-out" id="media-carousel-track">
                        <?php foreach ($mediaSlides as $index => $slide): ?>
                            <div class="relative h-72 w-full flex-shrink-0 sm:h-96">
                                <img src="<?php echo htmlspecialchars($slide['url'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" alt="" class="h-full w-full object-cover">
                                <div class="absolute left-4 top-4 rounded-full bg-black/45 px-3 py-1 text-xs font-semibold text-white backdrop-blur">
                                    <?php echo htmlspecialchars($slide['type'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (count($mediaSlides) > 1): ?>
                        <button type="button" class="media-carousel-prev absolute left-3 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-primary-900 shadow-lg transition hover:bg-white">
                            <i data-lucide="chevron-left" class="h-5 w-5"></i>
                        </button>
                        <button type="button" class="media-carousel-next absolute right-3 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-primary-900 shadow-lg transition hover:bg-white">
                            <i data-lucide="chevron-right" class="h-5 w-5"></i>
                        </button>
                        <div class="absolute bottom-4 left-1/2 flex -translate-x-1/2 gap-2">
                            <?php foreach ($mediaSlides as $index => $slide): ?>
                                <button type="button" class="media-carousel-dot h-2.5 w-2.5 rounded-full bg-white/50 transition data-[active=true]:w-6 data-[active=true]:bg-gold-500" data-slide="<?php echo htmlspecialchars((string)$index, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" data-active="<?php echo $index === 0 ? 'true' : 'false'; ?>"></button>
                            <?php endforeach; ?>
                        </div>
                        <div class="absolute bottom-4 right-4 rounded-full bg-black/45 px-3 py-1 text-xs font-semibold text-white backdrop-blur">
                            <span id="media-carousel-current">1</span>/<?php echo htmlspecialchars((string)count($mediaSlides), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="p-5 sm:p-8 lg:p-10">
                    <div class="mb-5 flex flex-wrap items-center gap-3 text-sm text-gray-500">
                        <span class="inline-flex items-center gap-2 rounded-full bg-gold-50 px-3 py-1 font-semibold text-gold-700">
                            <i data-lucide="tag" class="h-4 w-4"></i>
                            <?php echo htmlspecialchars($contenu['categorie_nom'] ?? 'Publication', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                        </span>
                        <span><?php echo htmlspecialchars($publishedAt, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
                    </div>
                    <h1 class="font-display text-3xl font-bold leading-tight text-primary-900 sm:text-5xl">
                        <?php echo htmlspecialchars($contenu['titre'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                    </h1>
                    <p class="mt-4 text-sm text-gray-500">Par <strong class="text-primary-900"><?php echo htmlspecialchars($author, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></strong></p>

                    <div class="mt-6 grid grid-cols-4 gap-2 rounded-3xl bg-primary-50 p-3 text-center">
                        <div><div class="text-lg font-bold"><?php echo htmlspecialchars((string)($contenu['likes_count'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div><div class="text-xs text-gray-500">Likes</div></div>
                        <div><div class="text-lg font-bold"><?php echo htmlspecialchars((string)($contenu['commentaires_count'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div><div class="text-xs text-gray-500">Commentaires</div></div>
                        <div><div class="text-lg font-bold"><?php echo htmlspecialchars((string)($contenu['partages_count'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div><div class="text-xs text-gray-500">Partages</div></div>
                        <div><div class="text-lg font-bold"><?php echo htmlspecialchars((string)($contenu['favoris_count'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div><div class="text-xs text-gray-500">Favoris</div></div>
                    </div>

                    <div class="mt-8 text-base leading-8 text-gray-700">
                        <?php echo $body !== '' ? nl2br(htmlspecialchars($body, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')) : 'Aucun contenu renseigne.'; ?>
                    </div>
                </div>
            </article>

            <section class="rounded-[2rem] bg-white p-5 shadow-sm sm:p-8 lg:col-start-2 lg:row-start-2">
                <h2 class="mb-5 font-display text-2xl font-bold">Commentaires</h2>
                <form method="POST" action="<?php echo BASE_URL; ?>contenu/comment" class="mb-6 rounded-3xl border border-gray-100 bg-gray-50 p-4">
                    <input type="hidden" name="contenu_id" value="<?php echo htmlspecialchars((string)$contenu['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                    <textarea name="commentaire" rows="3" required placeholder="Votre commentaire..." class="w-full resize-none bg-transparent text-sm outline-none placeholder:text-gray-400"></textarea>
                    <div class="mt-3 flex justify-end">
                        <button class="inline-flex items-center gap-2 rounded-full bg-primary-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-primary-800">
                            <i data-lucide="send" class="h-4 w-4"></i>
                            Publier
                        </button>
                    </div>
                </form>

                <?php if (!empty($commentaires)): ?>
                    <div class="space-y-3">
                        <?php foreach ($commentaires as $commentaire): ?>
                            <div class="rounded-3xl border border-gray-100 p-4">
                                <p class="text-sm leading-6 text-gray-700"><?php echo htmlspecialchars($commentaire['commentaire'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                                <p class="mt-2 text-xs text-gray-400"><?php echo htmlspecialchars($commentaire['date_creation'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-sm text-gray-500">Aucun commentaire pour cette publication.</p>
                <?php endif; ?>
            </section>

            <aside class="space-y-5 lg:col-start-1 lg:row-start-1 lg:row-span-2">
                <section class="rounded-[2rem] bg-white p-6 shadow-sm">
                    <h2 class="mb-4 flex items-center gap-2 font-bold">
                        <i data-lucide="folder" class="h-5 w-5 text-gold-500"></i>
                        Categories
                    </h2>
                    <?php if (!empty($categories)): ?>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($categories as $categorie): ?>
                                <span class="rounded-full bg-primary-50 px-3 py-1.5 text-xs font-semibold text-primary-800">
                                    <?php echo htmlspecialchars($categorie['nom'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-sm text-gray-500">Aucune categorie disponible.</p>
                    <?php endif; ?>
                </section>

                <section class="rounded-[2rem] bg-white p-6 shadow-sm">
                    <h2 class="mb-4 flex items-center gap-2 font-bold">
                        <i data-lucide="share-2" class="h-5 w-5 text-gold-500"></i>
                        Partager
                    </h2>
                    <div class="grid gap-2">
                        <button type="button" data-share-platform="Facebook" class="share-button inline-flex items-center justify-between rounded-2xl bg-primary-50 px-4 py-3 text-sm font-semibold text-primary-900 transition hover:bg-gold-50">
                            <span class="inline-flex items-center gap-2"><i data-lucide="share-2" class="h-4 w-4"></i> Facebook</span>
                            <i data-lucide="external-link" class="h-4 w-4 text-gray-400"></i>
                        </button>
                        <button type="button" data-share-platform="Twitter" class="share-button inline-flex items-center justify-between rounded-2xl bg-primary-50 px-4 py-3 text-sm font-semibold text-primary-900 transition hover:bg-gold-50">
                            <span class="inline-flex items-center gap-2"><i data-lucide="send" class="h-4 w-4"></i> X / Twitter</span>
                            <i data-lucide="external-link" class="h-4 w-4 text-gray-400"></i>
                        </button>
                        <button type="button" data-share-platform="LinkedIn" class="share-button inline-flex items-center justify-between rounded-2xl bg-primary-50 px-4 py-3 text-sm font-semibold text-primary-900 transition hover:bg-gold-50">
                            <span class="inline-flex items-center gap-2"><i data-lucide="briefcase-business" class="h-4 w-4"></i> LinkedIn</span>
                            <i data-lucide="external-link" class="h-4 w-4 text-gray-400"></i>
                        </button>
                        <button type="button" data-share-platform="WhatsApp" class="share-button inline-flex items-center justify-between rounded-2xl bg-primary-50 px-4 py-3 text-sm font-semibold text-primary-900 transition hover:bg-gold-50">
                            <span class="inline-flex items-center gap-2"><i data-lucide="message-circle" class="h-4 w-4"></i> WhatsApp</span>
                            <i data-lucide="external-link" class="h-4 w-4 text-gray-400"></i>
                        </button>
                        <button type="button" data-share-platform="Email" class="share-button inline-flex items-center justify-between rounded-2xl bg-primary-50 px-4 py-3 text-sm font-semibold text-primary-900 transition hover:bg-gold-50">
                            <span class="inline-flex items-center gap-2"><i data-lucide="mail" class="h-4 w-4"></i> Email</span>
                            <i data-lucide="external-link" class="h-4 w-4 text-gray-400"></i>
                        </button>
                    </div>
                </section>
            </aside>
        <?php else: ?>
            <section class="rounded-[2rem] bg-white p-10 text-center shadow-sm lg:col-span-2">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                    <i data-lucide="file-x" class="h-7 w-7"></i>
                </div>
                <h1 class="font-display text-2xl font-bold">Publication introuvable</h1>
                <p class="mt-2 text-sm text-gray-500">Cette publication n'existe pas ou a ete supprimee.</p>
            </section>
        <?php endif; ?>
    </main>

    <script>
        const shareEndpoint = '<?php echo BASE_URL; ?>contenu/share';
        const contentId = '<?php echo !empty($contenu['id']) ? htmlspecialchars((string)$contenu['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : ''; ?>';
        const shareTitle = <?php echo json_encode($contenu['titre'] ?? 'Publication Congo Explorer Hub', JSON_UNESCAPED_UNICODE); ?>;

        const mediaTrack = document.getElementById('media-carousel-track');
        const mediaDots = Array.from(document.querySelectorAll('.media-carousel-dot'));
        const mediaCurrent = document.getElementById('media-carousel-current');
        let mediaIndex = 0;
        let mediaTouchStartX = 0;

        function updateMediaCarousel(index) {
            if (!mediaTrack) return;

            const total = mediaTrack.children.length;
            mediaIndex = (index + total) % total;
            mediaTrack.style.transform = `translateX(-${mediaIndex * 100}%)`;
            mediaDots.forEach((dot, dotIndex) => dot.dataset.active = dotIndex === mediaIndex ? 'true' : 'false');

            if (mediaCurrent) {
                mediaCurrent.textContent = String(mediaIndex + 1);
            }
        }

        document.querySelector('.media-carousel-prev')?.addEventListener('click', () => updateMediaCarousel(mediaIndex - 1));
        document.querySelector('.media-carousel-next')?.addEventListener('click', () => updateMediaCarousel(mediaIndex + 1));
        mediaDots.forEach((dot) => {
            dot.addEventListener('click', () => updateMediaCarousel(Number(dot.dataset.slide || 0)));
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'ArrowLeft') updateMediaCarousel(mediaIndex - 1);
            if (event.key === 'ArrowRight') updateMediaCarousel(mediaIndex + 1);
        });

        mediaTrack?.addEventListener('touchstart', (event) => {
            mediaTouchStartX = event.changedTouches[0].screenX;
        }, {passive: true});

        mediaTrack?.addEventListener('touchend', (event) => {
            const diff = mediaTouchStartX - event.changedTouches[0].screenX;
            if (Math.abs(diff) > 45) {
                updateMediaCarousel(diff > 0 ? mediaIndex + 1 : mediaIndex - 1);
            }
        }, {passive: true});

        function shareUrl(platform) {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(shareTitle);

            const urls = {
                Facebook: `https://www.facebook.com/sharer/sharer.php?u=${url}`,
                Twitter: `https://twitter.com/intent/tweet?url=${url}&text=${title}`,
                LinkedIn: `https://www.linkedin.com/sharing/share-offsite/?url=${url}`,
                WhatsApp: `https://wa.me/?text=${title}%20${url}`,
                Email: `mailto:?subject=${title}&body=${url}`
            };

            return urls[platform] || window.location.href;
        }

        function registerShare(platform) {
            if (!contentId) return;

            const data = new FormData();
            data.append('contenu_id', contentId);
            data.append('plateforme', platform);

            fetch(shareEndpoint, {
                method: 'POST',
                body: data,
                credentials: 'same-origin',
                headers: {'X-Requested-With': 'XMLHttpRequest'}
            }).catch(() => {});
        }

        document.querySelectorAll('.share-button').forEach((button) => {
            button.addEventListener('click', () => {
                const platform = button.dataset.sharePlatform;
                const url = shareUrl(platform);

                registerShare(platform);

                if (platform === 'Email') {
                    window.location.href = url;
                    return;
                }

                window.open(url, '_blank', 'noopener,noreferrer,width=720,height=620');
            });
        });

        lucide.createIcons();
    </script>
</body>
</html>
