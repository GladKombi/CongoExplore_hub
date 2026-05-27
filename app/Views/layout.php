<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) . ' - Congo Explorer Hub' : 'Congo Explorer Hub'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
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
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed: 80px;
            --navbar-height: 64px;
        }

        * { scroll-behavior: smooth; }

        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: #f5f5f5;
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

$menuItems = [
    ['label' => 'Tableau de bord', 'icon' => 'layout-dashboard', 'url' => 'dashboard', 'roles' => ['Admin', 'Journaliste', 'Community Manager']],
    ['label' => 'Publications', 'icon' => 'newspaper', 'url' => 'contenu', 'roles' => ['Admin', 'Journaliste', 'Community Manager']],
    ['label' => 'Événements', 'icon' => 'calendar', 'url' => 'evenement', 'roles' => ['Admin', 'Journaliste', 'Community Manager']],
    ['label' => 'Clients', 'icon' => 'briefcase', 'url' => 'client', 'roles' => ['Admin', 'Journaliste', 'Community Manager']],
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
                    <a href="<?php echo BASE_URL . $item['url']; ?>" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium <?php echo $currentSegment === $item['url'] ? 'text-gold-600 active' : 'text-gray-600 hover:text-gray-900'; ?>">
                        <i data-lucide="<?php echo $item['icon']; ?>" class="sidebar-icon w-5 h-5 flex-shrink-0"></i>
                        <span class="sidebar-text"><?php echo htmlspecialchars($item['label']); ?></span>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>

        <div class="border-t border-gray-100 p-4">
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-gray-50">
                <div class="w-11 h-11 rounded-2xl bg-primary-50 flex items-center justify-center text-primary-700 font-bold uppercase">
                    <?php echo htmlspecialchars(substr($user['prenom'] ?? 'U', 0, 1) . substr($user['nom'] ?? '', 0, 1)); ?>
                </div>
                <div class="sidebar-text min-w-0">
                    <div class="text-sm font-semibold text-gray-800 truncate"><?php echo htmlspecialchars($fullName); ?></div>
                    <div class="text-xs text-gray-500 truncate"><?php echo htmlspecialchars($role ?: 'Visiteur'); ?></div>
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
                <h1 class="text-lg font-bold text-primary-900 font-display"><?php echo isset($title) ? htmlspecialchars($title) : 'Administration'; ?></h1>
                <p class="text-sm text-gray-500">Bienvenue<?php echo $role ? ' ' . htmlspecialchars($role) : ''; ?></p>
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
            <div class="flex items-center gap-2 pl-2 border-l border-gray-200 ml-1">
                <span class="hidden sm:inline text-sm text-gray-600"><?php echo htmlspecialchars($fullName); ?></span>
                <div class="w-9 h-9 rounded-full bg-primary-50 text-primary-700 flex items-center justify-center font-semibold uppercase">
                    <?php echo htmlspecialchars(substr($user['prenom'] ?? 'U', 0, 1) . substr($user['nom'] ?? '', 0, 1)); ?>
                </div>
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
            if (window.lucide) {
                window.lucide.replace();
            }
        }

        document.addEventListener('click', function(event) {
            if (!sidebar.contains(event.target) && !event.target.closest('button[onclick="toggleSidebar()"]')) {
                closeSidebar();
            }
        });

        if (window.lucide) {
            window.lucide.replace();
        }
    </script>
</body>
</html>
