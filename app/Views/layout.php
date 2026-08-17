<?php if (!headers_sent()) { header('Content-Type: text/html; charset=utf-8'); } ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . ' - Congo Explorer Hub' : 'Congo Explorer Hub'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'primary': {
                            50: '#f0f5f2', 100: '#d4e5db', 200: '#a8ccb7', 300: '#74ad8c',
                            400: '#4a8f6b', 500: '#2d5a4c', 600: '#234a3d', 700: '#1a3a30',
                            800: '#122b23', 900: '#0a1c17',
                        },
                        'gold': {
                            50: '#fef9f0', 100: '#fdf0d5', 200: '#fae0a8', 300: '#f5cb6e',
                            400: '#f0b940', 500: '#d4a843', 600: '#b88a2e', 700: '#8f6b23',
                            800: '#6b4f1a', 900: '#473311',
                        },
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                        'serif': ['Playfair Display', 'Georgia', 'serif'],
                        'display': ['Space Grotesk', 'Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <script>
        (function() {
            try {
                if (localStorage.getItem('theme') === 'dark') {
                    document.documentElement.classList.add('dark');
                }
            } catch (error) {}
        })();
    </script>
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed: 80px;
            --navbar-height: 64px;
        }

        * { scroll-behavior: smooth; }

        [hidden] {
            display: none !important;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: #f5f5f5;
        }

        [data-lucide] {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: currentColor;
            vertical-align: middle;
            width: 1.25rem;
            height: 1.25rem;
            line-height: 1;
        }

        [data-lucide] svg,
        svg[data-lucide] {
            width: 100%;
            height: 100%;
            stroke: currentColor;
            color: currentColor;
            display: block;
            flex-shrink: 0;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
        .animate-slide-in { animation: slideInLeft 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-slide-up { animation: slideInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-scale-in { animation: scaleIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

        .sidebar {
            width: var(--sidebar-width);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 40;
        }
        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }
        .sidebar.collapsed .sidebar-text {
            display: none;
        }
        .sidebar.collapsed .sidebar-icon {
            margin: 0 auto;
        }
        .sidebar.collapsed .menu-item {
            justify-content: center;
            padding: 12px;
        }
        .sidebar.collapsed .logo-text {
            display: none;
        }

        .menu-item {
            transition: all 0.2s ease;
            position: relative;
        }
        .menu-item:hover {
            background: rgba(212, 168, 67, 0.08);
        }
        .menu-item.active {
            background: rgba(212, 168, 67, 0.12);
            color: #d4a843;
        }
        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 24px;
            background: #d4a843;
            border-radius: 0 4px 4px 0;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            min-height: calc(100vh - var(--navbar-height));
            padding-top: var(--navbar-height);
        }
        .main-content.expanded {
            margin-left: var(--sidebar-collapsed);
        }

        .navbar {
            height: var(--navbar-height);
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 30;
        }
        .navbar.expanded {
            margin-left: var(--sidebar-collapsed);
        }

        .form-input {
            transition: all 0.3s ease;
        }
        .form-input:focus {
            border-color: rgba(212, 168, 67, 0.4);
            box-shadow: 0 0 0 3px rgba(212, 168, 67, 0.06);
        }

        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 35;
            backdrop-filter: blur(4px);
        }
        .sidebar-overlay.active {
            display: block;
        }

        .dark body {
            background-color: #07110e;
            color: #dbe7e1;
        }

        .dark .bg-\[\#f8f9fb\],
        .dark .main-content {
            background-color: #07110e !important;
        }

        .dark .bg-white,
        .dark .sidebar,
        .dark .navbar {
            background-color: #0f1f1a !important;
        }

        .dark .bg-gray-50 {
            background-color: #132821 !important;
        }

        .dark .border-gray-50,
        .dark .border-gray-100,
        .dark .border-gray-200 {
            border-color: #214237 !important;
        }

        .dark .shadow-sm,
        .dark .shadow-2xl {
            box-shadow: 0 18px 48px rgba(0, 0, 0, 0.32) !important;
        }

        .dark .text-primary-900,
        .dark .text-gray-900,
        .dark .text-gray-800,
        .dark .text-gray-700 {
            color: #f2f7f4 !important;
        }

        .dark .text-gray-600,
        .dark .text-gray-500 {
            color: #a8b8b1 !important;
        }

        .dark .text-gray-400 {
            color: #789088 !important;
        }

        .dark .text-primary-700,
        .dark .text-primary-800 {
            color: #91d6b4 !important;
        }

        .dark .text-gold-600,
        .dark .text-gold-700,
        .dark .text-gold-800 {
            color: #f4c85f !important;
        }

        .dark .bg-primary-50,
        .dark .bg-gold-50,
        .dark .bg-emerald-50,
        .dark .hover\:bg-primary-50:hover,
        .dark .hover\:bg-gold-50:hover,
        .dark .hover\:bg-gray-50:hover,
        .dark .hover\:bg-red-50:hover {
            background-color: #19382f !important;
        }

        .dark input,
        .dark select,
        .dark textarea {
            background-color: #0b1713 !important;
            border-color: #2a4d41 !important;
            color: #f2f7f4 !important;
        }

        .dark input::placeholder,
        .dark textarea::placeholder {
            color: #789088 !important;
        }

        .dark tr:hover {
            background-color: rgba(25, 56, 47, 0.62) !important;
        }

        .dark thead {
            background-color: #132821 !important;
        }

        .dark .divide-gray-100 > :not([hidden]) ~ :not([hidden]) {
            border-color: #214237 !important;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                z-index: 40;
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0 !important;
            }
            .navbar {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body class="text-gray-800 font-sans overflow-x-hidden antialiased">

<?php
$user = $_SESSION['user'] ?? null;
$role = $user['role'] ?? '';
$fullName = trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?: 'Utilisateur';
$profilePhotoUrl = !empty($user['photo_profil']) ? BASE_URL . ltrim($user['photo_profil'], '/') : null;

$menuItems = [
    ['label' => 'Tableau de bord', 'icon' => 'layout-dashboard', 'url' => 'dashboard', 'roles' => ['Admin', 'Journaliste', 'Community Manager']],
    [
        'label' => 'Publications',
        'icon' => 'newspaper',
        'url' => 'contenu',
        'roles' => ['Admin', 'Journaliste', 'Community Manager'],
        'segments' => ['contenu', 'media', 'categorie'],
        'children' => [
            ['label' => 'Publications', 'icon' => 'file-text', 'url' => 'contenu'],
            ['label' => 'Medias', 'icon' => 'image', 'url' => 'media'],
            ['label' => 'Categories', 'icon' => 'folder', 'url' => 'categorie'],
        ],
    ],
    ['label' => 'Événements', 'icon' => 'calendar', 'url' => 'evenement', 'roles' => ['Admin', 'Journaliste', 'Community Manager']],
    [
        'label' => 'Clients',
        'icon' => 'briefcase',
        'url' => 'client',
        'roles' => ['Admin', 'Journaliste', 'Community Manager'],
        'segments' => ['client', 'projet', 'livrable'],
        'children' => [
            ['label' => 'Clients', 'icon' => 'briefcase', 'url' => 'client'],
            ['label' => 'Projets', 'icon' => 'target', 'url' => 'projet'],
            ['label' => 'Livrables', 'icon' => 'check-square', 'url' => 'livrable'],
        ],
    ],
    ['label' => 'Utilisateurs', 'icon' => 'users', 'url' => 'utilisateur', 'roles' => ['Admin']],
];

$currentPath = trim($_GET['url'] ?? '', '/');
$currentSegment = explode('/', $currentPath)[0] ?? '';
?>

    <div id="sidebar-overlay" class="sidebar-overlay" onclick="closeSidebar()"></div>

    <aside id="sidebar" class="sidebar fixed top-0 left-0 bottom-0 bg-white border-r border-gray-100 flex flex-col shadow-sm">
        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-50 h-[64px]">
            <div class="w-10 h-10 rounded-xl bg-primary-900 flex items-center justify-center flex-shrink-0">
                <img src="<?php echo BASE_URL; ?>img/hub2.png" alt="Logo" class="w-7 h-7 object-contain brightness-125">
            </div>
            <div>
                <div class="text-base font-bold text-primary-900 font-display">CongoExplorer</div>
                <div class="text-xs text-gray-500">Administration</div>
            </div>
        </div>

        <nav class="flex-1 py-4 px-2 space-y-1 overflow-y-auto">
            <p class="sidebar-text text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-3">Menu</p>
            <?php foreach ($menuItems as $item): ?>
                <?php if (in_array($role, $item['roles'], true)): ?>
                    <?php $isActive = in_array($currentSegment, $item['segments'] ?? [$item['url']], true); ?>
                    <a href="<?php echo BASE_URL . $item['url']; ?>" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium <?php echo $isActive ? 'text-gold-600 active' : 'text-gray-600 hover:text-gray-900'; ?>">
                        <i data-lucide="<?php echo $item['icon']; ?>" class="sidebar-icon w-5 h-5 flex-shrink-0"></i>
                        <span class="sidebar-text"><?php echo htmlspecialchars($item['label'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
                    </a>
                    <?php if (!empty($item['children']) && $isActive): ?>
                        <div class="sidebar-text ml-6 mt-1 space-y-1 border-l border-gray-100 pl-3">
                            <?php foreach ($item['children'] as $child): ?>
                                <a href="<?php echo BASE_URL . $child['url']; ?>" class="flex items-center gap-2 rounded-xl px-3 py-2 text-xs font-semibold transition <?php echo $currentSegment === $child['url'] ? 'bg-primary-50 text-primary-900' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800'; ?>">
                                    <i data-lucide="<?php echo $child['icon']; ?>" class="w-4 h-4 flex-shrink-0"></i>
                                    <?php echo htmlspecialchars($child['label'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>

        <div class="border-t border-gray-100 p-4">
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-gray-50">
                <?php if ($profilePhotoUrl): ?>
                    <img src="<?php echo htmlspecialchars($profilePhotoUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" alt="Photo de profil" class="h-11 w-11 rounded-2xl object-cover">
                <?php else: ?>
                    <div class="w-11 h-11 rounded-2xl bg-primary-50 flex items-center justify-center text-primary-700 font-bold uppercase"><?php echo htmlspecialchars(substr($user['prenom'] ?? 'U', 0, 1) . substr($user['nom'] ?? '', 0, 1), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div>
                <?php endif; ?>
                <div class="sidebar-text min-w-0">
                    <div class="text-sm font-semibold text-gray-800 truncate"><?php echo htmlspecialchars($fullName, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div>
                    <div class="text-xs text-gray-500 truncate"><?php echo htmlspecialchars($role ?: 'Visiteur', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div>
                </div>
            </div>
            <a href="<?php echo BASE_URL; ?>login/logout" class="mt-4 block text-sm font-medium text-red-600 hover:text-red-800 px-3 py-2 rounded-xl hover:bg-red-50 transition-colors">
                <i data-lucide="log-out" class="w-4 h-4 inline-block mr-2"></i>Déconnexion
            </a>
        </div>
    </aside>

    <nav id="navbar" class="navbar fixed top-0 right-0 left-0 bg-white border-b border-gray-100 flex items-center justify-between px-4 lg:px-6 z-30 shadow-sm">
        <div class="flex items-center gap-3">
            <button onclick="toggleSidebar()" class="lg:hidden p-2 text-gray-500 hover:text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>
            <button onclick="toggleSidebarDesktop()" class="hidden lg:block p-2 text-gray-400 hover:text-gray-600 rounded-xl hover:bg-gray-50 transition-colors">
                <i data-lucide="panel-left" class="w-5 h-5" id="collapse-icon"></i>
            </button>
            <div>
                <h1 class="text-lg font-bold text-primary-900 font-display"><?php echo isset($title) ? htmlspecialchars($title, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : 'Administration'; ?></h1>
                <p class="text-sm text-gray-500">Bienvenue<?php echo $role ? ' ' . htmlspecialchars($role, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : ''; ?></p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="hidden sm:flex items-center relative">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                <input type="text" placeholder="Rechercher..." class="pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gold-500/20 focus:border-gold-500/40 w-48 lg:w-64 transition-all">
            </div>
            <button class="relative p-2 text-gray-400 hover:text-gray-600 rounded-xl hover:bg-gray-50 transition-colors">
                <i data-lucide="bell" class="w-5 h-5"></i>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <button class="p-2 text-gray-400 hover:text-gray-600 rounded-xl hover:bg-gray-50 transition-colors">
                <i data-lucide="mail" class="w-5 h-5"></i>
            </button>
            <button type="button" onclick="toggleTheme()" class="p-2 text-gray-400 hover:text-gray-600 rounded-xl hover:bg-gray-50 transition-colors" title="Changer le theme" aria-label="Changer le theme">
                <i data-lucide="moon" class="w-5 h-5" id="theme-icon"></i>
            </button>
            <div class="flex items-center gap-2 pl-2 border-l border-gray-200 ml-1">
                <span class="hidden sm:inline text-sm text-gray-600"><?php echo htmlspecialchars($fullName, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
                <?php if ($profilePhotoUrl): ?>
                    <img src="<?php echo htmlspecialchars($profilePhotoUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" alt="Photo de profil" class="h-9 w-9 rounded-full object-cover">
                <?php else: ?>
                    <div class="w-9 h-9 rounded-full bg-primary-50 text-primary-700 flex items-center justify-center font-semibold uppercase"><?php echo htmlspecialchars(substr($user['prenom'] ?? 'U', 0, 1) . substr($user['nom'] ?? '', 0, 1), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main id="main-content" class="main-content bg-[#f8f9fb] min-h-screen">
        <div class="p-4 lg:p-8">
            <?php echo isset($content) ? $content : ''; ?>
        </div>
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const navbar = document.getElementById('navbar');
        const mainContent = document.getElementById('main-content');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const root = document.documentElement;
        const iconPaths = {
            'layout-dashboard': '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
            newspaper: '<path d="M4 19a2 2 0 0 0 2 2h14"/><path d="M6 17V3H4a2 2 0 0 0-2 2v14"/><path d="M8 5h10v12H8z"/><path d="M10 9h6"/><path d="M10 13h6"/>',
            calendar: '<path d="M8 2v4"/><path d="M16 2v4"/><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M3 10h18"/>',
            briefcase: '<path d="M10 6V5a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v1"/><rect x="3" y="6" width="18" height="14" rx="2"/><path d="M3 12h18"/>',
            users: '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
            'log-out': '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
            menu: '<path d="M4 6h16"/><path d="M4 12h16"/><path d="M4 18h16"/>',
            'panel-left': '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M9 4v16"/>',
            'chevrons-right': '<path d="M7 6l6 6-6 6"/><path d="M13 6l6 6-6 6"/>',
            search: '<circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>',
            bell: '<path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>',
            mail: '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
            moon: '<path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/>',
            sun: '<circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="M4.93 4.93l1.41 1.41"/><path d="M17.66 17.66l1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="M4.93 19.07l1.41-1.41"/><path d="M17.66 6.34l1.41-1.41"/>',
            'user-plus': '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 8v6"/><path d="M22 11h-6"/>',
            'clock-3': '<circle cx="12" cy="12" r="10"/><path d="M12 6v6h4"/>',
            eye: '<path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/>',
            pencil: '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>',
            'trash-2': '<path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/>',
            x: '<path d="M18 6L6 18"/><path d="M6 6l12 12"/>',
            'triangle-alert': '<path d="M10.3 3.9L1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/>',
            'circle-alert': '<circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/>',
            'circle-check': '<circle cx="12" cy="12" r="10"/><path d="M9 12l2 2 4-4"/>',
            'shield-check': '<path d="M20 13c0 5-3.5 7.5-8 9-4.5-1.5-8-4-8-9V5l8-3 8 3v8z"/><path d="M9 12l2 2 4-4"/>',
            'messages-square': '<path d="M21 15a2 2 0 0 1-2 2H8l-5 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M8 9h8"/><path d="M8 13h5"/>',
            user: '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
            'user-x': '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M17 8l5 5"/><path d="M22 8l-5 5"/>',
            'arrow-left': '<path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/>',
            plus: '<path d="M12 5v14"/><path d="M5 12h14"/>',
            'file-text': '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/>',
            tag: '<path d="M20.6 13.1l-7.5 7.5a2 2 0 0 1-2.8 0L3 13.3V3h10.3l7.3 7.3a2 2 0 0 1 0 2.8z"/><circle cx="7.5" cy="7.5" r=".5"/>',
            archive: '<rect x="3" y="3" width="18" height="4" rx="1"/><path d="M5 7v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7"/><path d="M10 12h4"/>',
            'file-x': '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M10 12l4 4"/><path d="M14 12l-4 4"/>',
            image: '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/>',
            'image-plus': '<path d="M16 5h6"/><path d="M19 2v6"/><rect x="3" y="3" width="14" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M17 16l-4-4-8 8"/>',
            folder: '<path d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>',
            'calendar-x': '<path d="M8 2v4"/><path d="M16 2v4"/><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M3 10h18"/><path d="M10 14l4 4"/><path d="M14 14l-4 4"/>',
            target: '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
            'check-square': '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 12l2 2 4-4"/>'
        };

        function fallbackIcon(name) {
            const path = iconPaths[name] || '<circle cx="12" cy="12" r="9"/>';
            return `<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">${path}</svg>`;
        }

        function renderIcons() {
            document.querySelectorAll('i[data-lucide]').forEach((icon) => {
                icon.innerHTML = fallbackIcon(icon.dataset.lucide);
            });
        }

        function applyTheme(theme) {
            const isDark = theme === 'dark';
            root.classList.toggle('dark', isDark);
            const themeIcon = document.getElementById('theme-icon');
            if (themeIcon) {
                themeIcon.dataset.lucide = isDark ? 'sun' : 'moon';
                themeIcon.innerHTML = fallbackIcon(themeIcon.dataset.lucide);
            }
            localStorage.setItem('theme', theme);
            renderIcons();
        }

        applyTheme(localStorage.getItem('theme') || 'light');

        function toggleTheme() {
            applyTheme(root.classList.contains('dark') ? 'light' : 'dark');
        }

        function toggleSidebar() {
            sidebar.classList.toggle('mobile-open');
            sidebarOverlay.classList.toggle('active');
        }

        function closeSidebar() {
            sidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.remove('active');
        }

        function toggleSidebarDesktop() {
            sidebar.classList.toggle('collapsed');
            navbar.classList.toggle('expanded');
            mainContent.classList.toggle('expanded');
            const icon = document.getElementById('collapse-icon');
            if (sidebar.classList.contains('collapsed')) {
                icon.dataset.lucide = 'chevrons-right';
            } else {
                icon.dataset.lucide = 'panel-left';
            }
            renderIcons();
        }

        document.addEventListener('click', function(event) {
            if (!sidebar.contains(event.target) && !event.target.closest('button[onclick="toggleSidebar()"]')) {
                closeSidebar();
            }
        });

        renderIcons();
    </script>
</body>
</html>
