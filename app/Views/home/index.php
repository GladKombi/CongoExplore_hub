<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Congo Explorer Hub - L'Autre Visage du Congo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            --color-primary: #2d5a4c;
            --color-gold: #d4a843;
            --color-dark: #1a2e2a;
        }

        * { scroll-behavior: smooth; }

        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: #f9f7f3;
        }

        [data-lucide] {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: currentColor;
        }

        [data-lucide] svg,
        svg[data-lucide] {
            width: 100%;
            height: 100%;
            stroke: currentColor;
            color: currentColor;
            flex-shrink: 0;
        }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        @keyframes pulse-gold {
            0%, 100% { box-shadow: 0 0 0 0 rgba(212, 168, 67, 0.4); }
            50% { box-shadow: 0 0 0 20px rgba(212, 168, 67, 0); }
        }
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes like-pop {
            0% { transform: scale(1); }
            30% { transform: scale(1.4); }
            50% { transform: scale(0.85); }
            70% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        @keyframes card-enter {
            from { opacity: 0; transform: translateY(30px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes avatar-pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(212, 168, 67, 0.6); }
            50% { box-shadow: 0 0 0 6px rgba(212, 168, 67, 0); }
        }
        @keyframes border-glow {
            0%, 100% { border-color: rgba(212, 168, 67, 0.15); }
            50% { border-color: rgba(212, 168, 67, 0.4); }
        }
        @keyframes dot-wave {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .animate-fade-in-up { animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-card-enter { animation: card-enter 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-float { animation: float 8s ease-in-out infinite; }
        .animate-gradient { background-size: 200% 200%; animation: gradient-shift 10s ease infinite; }
        .animate-border-glow { animation: border-glow 3s ease-in-out infinite; }
        .stagger-1 { animation-delay: 0.08s; }
        .stagger-2 { animation-delay: 0.16s; }
        .stagger-3 { animation-delay: 0.24s; }
        .stagger-4 { animation-delay: 0.32s; }
        .stagger-5 { animation-delay: 0.40s; }

        /* Glass */
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glass-strong {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        /* Post Card */
        .post-card {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }
        .post-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 25px 50px -15px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(212, 168, 67, 0.08);
        }
        .post-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            padding: 1px;
            background: linear-gradient(135deg, rgba(212,168,67,0.12), transparent 40%, transparent 60%, rgba(212,168,67,0.08));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .img-zoom {
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .post-card:hover .img-zoom {
            transform: scale(1.02);
        }

        .like-btn.liked svg {
            animation: like-pop 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .text-gradient {
            background: linear-gradient(135deg, #d4a843 0%, #f0c96e 40%, #e5ad33 70%, #d4a843 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 200% 200%;
            animation: gradient-shift 4s ease infinite;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d4a843; border-radius: 4px; }

        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Nav */
        .nav-link {
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 20px;
            height: 2px;
            background: #d4a843;
            border-radius: 2px;
            transition: transform 0.3s ease;
        }
        .nav-link:hover::after,
        .nav-link.active::after {
            transform: translateX(-50%) scaleX(1);
        }

        /* Footer */
        .footer-link {
            position: relative;
            display: inline-block;
        }
        .footer-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: #d4a843;
            transition: width 0.3s ease;
        }
        .footer-link:hover::after { width: 100%; }

        /* Card hover */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px -15px rgba(0, 0, 0, 0.12);
        }

        /* Feature card */
        .feature-card {
            position: relative;
            overflow: hidden;
        }
        .feature-card .feature-icon {
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        /* Service decorative blob */
        .service-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.15;
            transition: all 0.5s ease;
        }
        .feature-card:hover .service-blob {
            opacity: 0.25;
            transform: scale(1.2);
        }

        /* Vision cards */
        .vision-card {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }
        .vision-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(212,168,67,0.5), transparent);
            transform: scaleX(0);
            transition: transform 0.5s ease;
        }
        .vision-card:hover::before {
            transform: scaleX(1);
        }
        .vision-card:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.05);
        }
    </style>
</head>
<body class="text-gray-800 font-sans overflow-x-hidden antialiased">

    <!-- ========== NAVIGATION ========== -->
    <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-500" id="header">
        <div class="glass-strong mx-1.5 mt-1.5 md:mx-5 md:mt-3 rounded-[1.75rem] md:rounded-3xl shadow-2xl shadow-black/10">
            <div class="max-w-7xl mx-auto px-3 sm:px-6">
                <div class="flex justify-between items-center h-12 md:h-16">
                    <a href="#" class="flex items-center space-x-2 md:space-x-3 group flex-shrink-0">
                        <div class="relative w-8 h-8 md:w-10 md:h-10 rounded-xl md:rounded-2xl bg-white/10 flex items-center justify-center overflow-hidden border border-white/20 group-hover:border-gold-500/50 transition-all duration-500">
                            <img src="img/hub2.png" alt="CEH" class="w-6 h-6 md:w-8 md:h-8 object-contain relative z-10">
                        </div>
                        <span class="text-white font-bold text-sm md:text-lg tracking-tight font-display">
                            Congo<span class="text-gradient">Explorer</span><span class="hidden sm:inline">Hub</span>
                        </span>
                    </a>

                    <nav class="hidden md:flex items-center space-x-1">
                        <a href="#hero" class="nav-link active px-3 py-2 text-sm font-medium text-white/90 hover:text-white transition-colors">Accueil</a>
                        <a href="#feed" class="nav-link px-3 py-2 text-sm font-medium text-white/70 hover:text-white transition-colors">Fil</a>
                        <a href="#about" class="nav-link px-3 py-2 text-sm font-medium text-white/70 hover:text-white transition-colors">À propos</a>
                        <a href="#services" class="nav-link px-3 py-2 text-sm font-medium text-white/70 hover:text-white transition-colors">Services</a>
                        <a href="#vision" class="nav-link px-3 py-2 text-sm font-medium text-white/70 hover:text-white transition-colors">Vision</a>
                    </nav>

                    <div class="flex items-center space-x-0.5 md:space-x-2 flex-shrink-0">
                        <button onclick="toggleSearch()" class="p-1.5 md:p-2 text-white/70 hover:text-white transition-colors rounded-xl hover:bg-white/5">
                            <i data-lucide="search" class="w-4 h-4 md:w-5 md:h-5"></i>
                        </button>
                        <button class="hidden sm:block p-1.5 md:p-2 text-white/70 hover:text-white transition-colors relative rounded-xl hover:bg-white/5">
                            <i data-lucide="bell" class="w-4 h-4 md:w-5 md:h-5"></i>
                            <span class="absolute top-1 right-1 w-1.5 h-1.5 md:w-2 md:h-2 bg-red-500 rounded-full animate-pulse"></span>
                        </button>
                        <a href="#contact" class="hidden md:inline-flex items-center px-4 py-2 bg-gold-500 text-primary-900 font-bold text-xs md:text-sm rounded-2xl hover:bg-gold-400 transition-all shadow-lg shadow-gold-500/20">
                            Contact
                            <i data-lucide="arrow-up-right" class="w-3 h-3 md:w-3.5 md:h-3.5 ml-1.5"></i>
                        </a>
                        <button onclick="toggleMobileMenu()" class="md:hidden p-1.5 text-white/70 hover:text-white transition-colors rounded-xl hover:bg-white/5">
                            <i data-lucide="menu" class="w-5 h-5" id="mobile-menu-icon"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div id="search-bar" class="hidden border-t border-white/10 px-3 py-2.5 md:px-4 md:py-3">
                <div class="relative max-w-lg mx-auto">
                    <i data-lucide="search" class="absolute left-3 md:left-4 top-1/2 -translate-y-1/2 w-3.5 h-3.5 md:w-4 md:h-4 text-gray-400"></i>
                    <input type="text" placeholder="Rechercher articles, événements, talents..." class="w-full pl-9 md:pl-11 pr-4 py-2 md:py-3 bg-white/5 border border-white/10 rounded-xl md:rounded-2xl text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gold-500/40 focus:border-transparent transition-all">
                </div>
            </div>

            <div id="mobile-menu" class="hidden md:hidden border-t border-white/10">
                <div class="px-3 py-4 space-y-1">
                    <a href="#hero" class="block px-4 py-3 text-white/85 hover:text-white hover:bg-white/5 rounded-2xl transition-all text-sm font-medium">Accueil</a>
                    <a href="#feed" class="block px-4 py-3 text-white/85 hover:text-white hover:bg-white/5 rounded-2xl transition-all text-sm font-medium">Fil d'actualité</a>
                    <a href="#about" class="block px-4 py-3 text-white/85 hover:text-white hover:bg-white/5 rounded-2xl transition-all text-sm font-medium">Qui sommes-nous</a>
                    <a href="#services" class="block px-4 py-3 text-white/85 hover:text-white hover:bg-white/5 rounded-2xl transition-all text-sm font-medium">Services</a>
                    <a href="#vision" class="block px-4 py-3 text-white/85 hover:text-white hover:bg-white/5 rounded-2xl transition-all text-sm font-medium">Vision</a>
                    <div class="pt-2">
                        <a href="#contact" class="block w-full text-center px-4 py-3 bg-gold-500 text-primary-900 font-bold rounded-2xl hover:bg-gold-400 transition-all text-sm">Nous contacter</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ========== HERO SECTION ========== -->
    <section id="hero" class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-900 via-primary-800 to-primary-950 animate-gradient"></div>
        <div class="absolute inset-0 opacity-15">
            <div class="absolute top-0 left-0 w-full h-full" style="background-image: radial-gradient(circle at 25% 45%, rgba(212,168,67,0.4) 0%, transparent 45%), radial-gradient(circle at 75% 25%, rgba(45,90,76,0.5) 0%, transparent 45%), radial-gradient(circle at 50% 70%, rgba(212,168,67,0.3) 0%, transparent 45%);"></div>
        </div>
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-1/4 left-1/4 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-gold-500/8 rounded-full blur-[80px] md:blur-[120px] animate-float"></div>
            <div class="absolute bottom-1/3 right-1/4 w-[250px] md:w-[500px] h-[250px] md:h-[500px] bg-primary-500/12 rounded-full blur-[80px] md:blur-[100px] animate-float" style="animation-delay: -4s;"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-10 text-center">
            <div class="animate-fade-in-up">
                <div class="inline-flex items-center px-3.5 py-1.5 md:px-5 md:py-2 rounded-full glass mb-6 md:mb-10 border-white/10">
                    <span class="relative flex h-2 w-2 md:h-2.5 md:w-2.5 mr-2 md:mr-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-gold-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 md:h-2.5 md:w-2.5 bg-gold-500"></span>
                    </span>
                    <span class="text-gold-300/90 text-xs md:text-sm font-medium tracking-wide">Média & Agence créative • RDC</span>
                </div>

                <h1 class="font-serif text-4xl sm:text-6xl md:text-7xl lg:text-8xl font-bold text-white mb-4 md:mb-8 leading-[1.08] tracking-tight px-2">
                    L'Autre Visage<br>du <span class="text-gradient">Congo</span>
                </h1>

                <p class="text-base sm:text-xl md:text-2xl text-white/55 max-w-2xl mx-auto mb-8 md:mb-12 font-light leading-relaxed px-2">
                    Révélons ensemble les talents, les initiatives et les histoires qui redéfinissent l'image de notre nation.
                </p>

                <div class="flex flex-col sm:flex-row gap-3 justify-center items-center">
                    <a href="#feed" class="group w-full sm:w-auto px-6 py-3 md:px-8 md:py-4 bg-gold-500 text-primary-900 font-bold rounded-2xl hover:bg-gold-400 transition-all transform hover:scale-105 shadow-2xl shadow-gold-500/25 flex items-center justify-center gap-2 text-sm md:text-base">
                        Explorer le fil
                        <i data-lucide="arrow-right" class="w-4 h-4 md:w-5 md:h-5 group-hover:translate-x-1.5 transition-transform"></i>
                    </a>
                    <a href="#about" class="w-full sm:w-auto px-6 py-3 md:px-8 md:py-4 border-2 border-white/15 text-white font-semibold rounded-2xl hover:bg-white/5 transition-all flex items-center justify-center gap-2 text-sm md:text-base">
                        <i data-lucide="play-circle" class="w-4 h-4 md:w-5 md:h-5"></i>
                        Notre mission
                    </a>
                </div>
            </div>

            <div class="mt-12 md:mt-24 grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-5 max-w-3xl mx-auto">
                <div class="glass rounded-2xl p-4 md:p-6 text-center stagger-1 animate-fade-in-up">
                    <div class="text-xl md:text-3xl font-bold text-gold-400 mb-1 font-display">3+</div>
                    <div class="text-white/45 text-xs md:text-sm font-medium">Mois d'activité</div>
                </div>
                <div class="glass rounded-2xl p-4 md:p-6 text-center stagger-2 animate-fade-in-up">
                    <div class="text-xl md:text-3xl font-bold text-gold-400 mb-1 font-display">50+</div>
                    <div class="text-white/45 text-xs md:text-sm font-medium">Projets</div>
                </div>
                <div class="glass rounded-2xl p-4 md:p-6 text-center stagger-3 animate-fade-in-up">
                    <div class="text-xl md:text-3xl font-bold text-gold-400 mb-1 font-display">360°</div>
                    <div class="text-white/45 text-xs md:text-sm font-medium">Stratégie</div>
                </div>
                <div class="glass rounded-2xl p-4 md:p-6 text-center stagger-4 animate-fade-in-up">
                    <div class="text-xl md:text-3xl font-bold text-gold-400 mb-1 font-display">∞</div>
                    <div class="text-white/45 text-xs md:text-sm font-medium">Créativité</div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-6 md:bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1.5 md:gap-2 animate-bounce">
            <span class="text-white/30 text-xs font-medium tracking-widest uppercase">Défiler</span>
            <div class="w-4 md:w-5 h-7 md:h-8 rounded-full border-2 border-white/15 flex items-start justify-center pt-1 md:pt-1.5">
                <div class="w-1 h-2 md:h-2.5 bg-gold-400/60 rounded-full animate-pulse"></div>
            </div>
        </div>
    </section>

    <!-- ========== FEED SECTION ========== -->
    <section id="feed" class="relative py-12 md:py-24 bg-[#f9f7f3]">
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(circle at 1px 1px, #1a2e2a 1px, transparent 0); background-size: 40px 40px;"></div>
        
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 relative">
            <div class="text-center mb-10 md:mb-20">
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 md:px-4 md:py-2 bg-gold-100/80 text-gold-700 rounded-full text-xs md:text-sm font-semibold mb-4 md:mb-5 backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 bg-gold-500 rounded-full"></span>
                    Fil d'actualité
                </span>
                <h2 class="font-serif text-3xl md:text-5xl lg:text-6xl font-bold text-primary-900 mb-3 md:mb-5 leading-tight">
                    Les dernières <span class="text-gold-500">histoires</span>
                </h2>
                <p class="text-gray-500 max-w-lg mx-auto text-sm md:text-lg leading-relaxed px-2">
                    Découvrez les récits, événements et talents qui façonnent le Congo d'aujourd'hui.
                </p>
            </div>

            <div class="flex gap-6 lg:gap-10">
                <main class="flex-1 max-w-full lg:max-w-none space-y-5 md:space-y-8">
                    <?php if (!empty($homeContents)): ?>
                        <?php foreach (array_slice($homeContents, 0, 6) as $index => $content): ?>
                            <?php
                            $author = trim(($content['auteur_prenom'] ?? '') . ' ' . ($content['auteur_nom'] ?? '')) ?: 'Congo Explorer Hub';
                            $image = !empty($content['media_url']) ? BASE_URL . ltrim((string)$content['media_url'], '/') : 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?w=900&h=650&fit=crop';
                            $publishedAt = !empty($content['date_publication']) ? date('d/m/Y', strtotime((string)$content['date_publication'])) : '';
                            $body = trim((string)($content['corps_text'] ?? ''));
                            $excerpt = strlen($body) > 180 ? substr($body, 0, 180) . '...' : $body;
                            ?>
                            <article id="contenu-<?php echo htmlspecialchars((string)$content['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" class="post-card bg-white rounded-[1.5rem] md:rounded-[2rem] shadow-sm overflow-hidden animate-card-enter opacity-0">
                                <div class="flex items-center justify-between p-3.5 md:p-6">
                                    <div class="flex items-center space-x-2.5 md:space-x-3.5 min-w-0 flex-1">
                                        <div class="w-9 h-9 md:w-12 md:h-12 rounded-full bg-primary-50 text-primary-700 flex items-center justify-center font-bold ring-2 ring-gold-200 ring-offset-2 ring-offset-white">
                                            <?php echo htmlspecialchars(strtoupper(substr($author, 0, 1)), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <span class="font-bold text-xs md:text-sm text-primary-900 truncate block"><?php echo htmlspecialchars($author, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
                                            <div class="flex items-center gap-1 text-[10px] md:text-xs text-gray-400 mt-0.5">
                                                <i data-lucide="tag" class="w-2.5 h-2.5 md:w-3 md:h-3 flex-shrink-0"></i>
                                                <span class="truncate"><?php echo htmlspecialchars($content['categorie_nom'] ?? 'Publication', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
                                                <span class="text-gray-300 flex-shrink-0">-</span>
                                                <span class="flex-shrink-0"><?php echo htmlspecialchars($publishedAt, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?php echo BASE_URL; ?>contenu/detail/<?php echo htmlspecialchars((string)$content['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" class="relative mx-1.5 md:mx-3 rounded-xl md:rounded-2xl overflow-hidden group block">
                                    <img src="<?php echo htmlspecialchars($image, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" class="img-zoom w-full aspect-[4/3] object-cover" loading="lazy">
                                </a>
                                <div class="p-3.5 md:p-6">
                                    <a href="<?php echo BASE_URL; ?>contenu/detail/<?php echo htmlspecialchars((string)$content['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" class="block">
                                        <h3 class="font-display text-lg md:text-2xl font-bold text-primary-900 mb-2 hover:text-gold-600 transition-colors"><?php echo htmlspecialchars($content['titre'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></h3>
                                    </a>
                                    <p class="text-xs md:text-[15px] text-gray-700 leading-relaxed mb-4"><?php echo htmlspecialchars($excerpt, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                                    <div class="flex items-center justify-between mb-3 md:mb-4">
                                        <div class="flex items-center gap-3 md:gap-5">
                                            <form method="POST" action="<?php echo BASE_URL; ?>contenu/like">
                                                <input type="hidden" name="contenu_id" value="<?php echo htmlspecialchars((string)$content['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                                                <button type="submit" class="like-btn group flex items-center gap-1.5 md:gap-2 text-gray-500 hover:text-red-500 transition-all">
                                                    <div class="w-7 h-7 md:w-9 md:h-9 rounded-full bg-gray-50 group-hover:bg-red-50 flex items-center justify-center transition-colors"><i data-lucide="heart" class="w-4 h-4 md:w-5 md:h-5"></i></div>
                                                    <span class="text-xs md:text-sm font-semibold text-gray-600"><?php echo htmlspecialchars((string)($content['likes_count'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
                                                </button>
                                            </form>
                                            <div class="group flex items-center gap-1.5 md:gap-2 text-gray-500">
                                                <div class="w-7 h-7 md:w-9 md:h-9 rounded-full bg-gray-50 flex items-center justify-center"><i data-lucide="message-circle" class="w-4 h-4 md:w-5 md:h-5"></i></div>
                                                <span class="text-xs md:text-sm font-semibold text-gray-600"><?php echo htmlspecialchars((string)($content['commentaires_count'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
                                            </div>
                                            <form method="POST" action="<?php echo BASE_URL; ?>contenu/share" class="flex items-center gap-2">
                                                <input type="hidden" name="contenu_id" value="<?php echo htmlspecialchars((string)$content['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                                                <input type="hidden" name="plateforme" value="Facebook">
                                                <button type="submit" class="group flex items-center gap-1.5 md:gap-2 text-gray-500 hover:text-primary-600 transition-all">
                                                    <div class="w-7 h-7 md:w-9 md:h-9 rounded-full bg-gray-50 group-hover:bg-primary-50 flex items-center justify-center transition-colors"><i data-lucide="share-2" class="w-4 h-4 md:w-5 md:h-5"></i></div>
                                                    <span class="text-xs md:text-sm font-semibold text-gray-600"><?php echo htmlspecialchars((string)($content['partages_count'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
                                                </button>
                                            </form>
                                        </div>
                                        <form method="POST" action="<?php echo BASE_URL; ?>contenu/favorite">
                                            <input type="hidden" name="contenu_id" value="<?php echo htmlspecialchars((string)$content['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                                            <button type="submit" class="group w-7 h-7 md:w-9 md:h-9 rounded-full bg-gray-50 hover:bg-gold-50 flex items-center justify-center transition-all" title="Ajouter aux favoris">
                                                <i data-lucide="bookmark" class="w-4 h-4 md:w-5 md:h-5 text-gray-400 group-hover:text-gold-500"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <form method="POST" action="<?php echo BASE_URL; ?>contenu/comment" class="flex items-center gap-2 md:gap-3 pt-3 md:pt-4 border-t border-gray-100">
                                        <input type="hidden" name="contenu_id" value="<?php echo htmlspecialchars((string)$content['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                                        <div class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-primary-50 text-primary-700 flex items-center justify-center text-xs font-bold flex-shrink-0">CE</div>
                                        <input name="commentaire" type="text" placeholder="Commentaire..." class="flex-1 text-xs md:text-sm bg-transparent focus:outline-none placeholder-gray-400 py-1 min-w-0" required>
                                        <button class="text-gold-500 font-semibold text-xs md:text-sm hover:text-gold-600 transition-colors px-2 md:px-3 py-1 md:py-1.5 rounded-full hover:bg-gold-50 flex-shrink-0">Publier</button>
                                    </form>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <article class="post-card bg-white rounded-[1.5rem] md:rounded-[2rem] shadow-sm overflow-hidden animate-card-enter opacity-0">
                            <div class="p-6 md:p-10 text-center">
                                <div class="mx-auto mb-4 w-12 h-12 rounded-2xl bg-gold-50 text-gold-600 flex items-center justify-center">
                                    <i data-lucide="newspaper" class="w-6 h-6"></i>
                                </div>
                                <h3 class="font-display text-xl md:text-2xl font-bold text-primary-900 mb-2">Aucun contenu dans la base</h3>
                                <p class="text-sm md:text-base text-gray-500 max-w-md mx-auto">Les publications ajoutees depuis le module Contenu apparaitront ici automatiquement.</p>
                            </div>
                        </article>
                    <?php endif; ?>
                    <?php if (false): ?>
                    
                    <!-- Post 1 -->
                    <article class="post-card bg-white rounded-[1.5rem] md:rounded-[2rem] shadow-sm overflow-hidden animate-card-enter stagger-1 opacity-0">
                        <div class="flex items-center justify-between p-3.5 md:p-6">
                            <div class="flex items-center space-x-2.5 md:space-x-3.5 min-w-0 flex-1">
                                <div class="relative flex-shrink-0">
                                    <img src="https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?w=100&h=100&fit=crop&crop=face" class="relative w-9 h-9 md:w-12 md:h-12 rounded-full object-cover ring-2 ring-gold-200 ring-offset-2 ring-offset-white">
                                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 md:w-4 md:h-4 bg-gold-500 rounded-full border-[2px] md:border-[3px] border-white flex items-center justify-center">
                                        <i data-lucide="check" class="w-2 h-2 md:w-2.5 md:h-2.5 text-white"></i>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <span class="font-bold text-xs md:text-sm text-primary-900 truncate block">Marie Lumumba</span>
                                    <div class="flex items-center gap-1 text-[10px] md:text-xs text-gray-400 mt-0.5">
                                        <i data-lucide="map-pin" class="w-2.5 h-2.5 md:w-3 md:h-3 flex-shrink-0"></i>
                                        <span class="truncate">Kinshasa</span>
                                        <span class="text-gray-300 flex-shrink-0">•</span>
                                        <span class="flex-shrink-0">Il y a 2h</span>
                                    </div>
                                </div>
                            </div>
                            <button class="text-gray-300 hover:text-gray-500 p-1 rounded-xl flex-shrink-0 ml-2">
                                <i data-lucide="more-horizontal" class="w-4 h-4 md:w-5 md:h-5"></i>
                            </button>
                        </div>
                        <div class="relative mx-1.5 md:mx-3 rounded-xl md:rounded-2xl overflow-hidden group cursor-pointer">
                            <img src="https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?w=800&h=600&fit=crop" class="img-zoom w-full aspect-[4/3] object-cover" loading="lazy">
                            <div class="absolute top-2.5 md:top-4 left-2.5 md:left-4">
                                <span class="bg-black/40 backdrop-blur-md text-white text-[10px] md:text-xs px-2 md:px-3 py-1 md:py-1.5 rounded-full flex items-center gap-1 font-medium">
                                    <i data-lucide="map-pin" class="w-2.5 h-2.5 md:w-3 md:h-3"></i> Kinshasa
                                </span>
                            </div>
                        </div>
                        <div class="p-3.5 md:p-6">
                            <div class="flex items-center justify-between mb-3 md:mb-4">
                                <div class="flex items-center gap-3 md:gap-5">
                                    <button onclick="toggleLike(this)" class="like-btn group flex items-center gap-1.5 md:gap-2 text-gray-500 hover:text-red-500 transition-all">
                                        <div class="w-7 h-7 md:w-9 md:h-9 rounded-full bg-gray-50 group-hover:bg-red-50 flex items-center justify-center transition-colors">
                                            <i data-lucide="heart" class="w-4 h-4 md:w-5 md:h-5"></i>
                                        </div>
                                        <span class="text-xs md:text-sm font-semibold text-gray-600">1,234</span>
                                    </button>
                                    <button class="group flex items-center gap-1.5 md:gap-2 text-gray-500 hover:text-primary-600 transition-all">
                                        <div class="w-7 h-7 md:w-9 md:h-9 rounded-full bg-gray-50 group-hover:bg-primary-50 flex items-center justify-center transition-colors">
                                            <i data-lucide="message-circle" class="w-4 h-4 md:w-5 md:h-5"></i>
                                        </div>
                                        <span class="text-xs md:text-sm font-semibold text-gray-600">89</span>
                                    </button>
                                    <button class="group flex items-center gap-1.5 md:gap-2 text-gray-500 hover:text-primary-600 transition-all">
                                        <div class="w-7 h-7 md:w-9 md:h-9 rounded-full bg-gray-50 group-hover:bg-primary-50 flex items-center justify-center transition-colors">
                                            <i data-lucide="share-2" class="w-4 h-4 md:w-5 md:h-5"></i>
                                        </div>
                                    </button>
                                </div>
                                <button class="group w-7 h-7 md:w-9 md:h-9 rounded-full bg-gray-50 hover:bg-gold-50 flex items-center justify-center transition-all">
                                    <i data-lucide="bookmark" class="w-4 h-4 md:w-5 md:h-5 text-gray-400 group-hover:text-gold-500"></i>
                                </button>
                            </div>
                            <p class="text-xs md:text-[15px] text-gray-700 leading-relaxed mb-3">
                                <span class="font-bold text-primary-900">Marie Lumumba</span> La magie de Kinshasa by night 🌆✨
                            </p>
                            <div class="flex flex-wrap gap-1.5 md:gap-2 mb-3">
                                <span class="text-gold-600 text-[10px] md:text-xs font-semibold bg-gold-50 px-2 md:px-2.5 py-0.5 md:py-1 rounded-full">#CongoExplorer</span>
                                <span class="text-gold-600 text-[10px] md:text-xs font-semibold bg-gold-50 px-2 md:px-2.5 py-0.5 md:py-1 rounded-full">#Kinshasa</span>
                            </div>
                            <div class="flex items-center gap-2 md:gap-3 pt-3 md:pt-4 border-t border-gray-100">
                                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&h=100&fit=crop&crop=face" class="w-6 h-6 md:w-8 md:h-8 rounded-full object-cover ring-1 ring-gray-200 flex-shrink-0">
                                <input type="text" placeholder="Commentaire..." class="flex-1 text-xs md:text-sm bg-transparent focus:outline-none placeholder-gray-400 py-1 min-w-0">
                                <button class="text-gold-500 font-semibold text-xs md:text-sm hover:text-gold-600 transition-colors px-2 md:px-3 py-1 md:py-1.5 rounded-full hover:bg-gold-50 flex-shrink-0">Publier</button>
                            </div>
                        </div>
                    </article>

                    <!-- Post 2 -->
                    <article class="post-card bg-white rounded-[1.5rem] md:rounded-[2rem] shadow-sm overflow-hidden animate-card-enter stagger-2 opacity-0">
                        <div class="flex items-center justify-between p-3.5 md:p-6">
                            <div class="flex items-center space-x-2.5 md:space-x-3.5 min-w-0 flex-1">
                                <div class="relative flex-shrink-0">
                                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop&crop=face" class="relative w-9 h-9 md:w-12 md:h-12 rounded-full object-cover ring-2 ring-gray-200 ring-offset-2 ring-offset-white">
                                    <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 md:w-3 md:h-3 bg-green-500 rounded-full border-[2px] md:border-[3px] border-white"></div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <span class="font-bold text-xs md:text-sm text-primary-900 truncate block">David Kanda</span>
                                    <div class="flex items-center gap-1 text-[10px] md:text-xs text-gray-400 mt-0.5">
                                        <i data-lucide="map-pin" class="w-2.5 h-2.5 md:w-3 md:h-3 flex-shrink-0"></i>
                                        <span class="truncate">Lubumbashi</span>
                                        <span class="text-gray-300 flex-shrink-0">•</span>
                                        <span class="flex-shrink-0">Il y a 4h</span>
                                    </div>
                                </div>
                            </div>
                            <button class="text-gray-300 hover:text-gray-500 p-1 rounded-xl flex-shrink-0 ml-2">
                                <i data-lucide="more-horizontal" class="w-4 h-4 md:w-5 md:h-5"></i>
                            </button>
                        </div>
                        <div class="relative mx-1.5 md:mx-3 rounded-xl md:rounded-2xl overflow-hidden group cursor-pointer bg-black">
                            <img src="https://images.unsplash.com/photo-1489392191049-fc10c97e64b6?w=800&h=500&fit=crop" class="img-zoom w-full aspect-video object-cover opacity-80">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-12 h-12 md:w-20 md:h-20 bg-white/15 backdrop-blur-xl rounded-full flex items-center justify-center group-hover:bg-white/25 group-hover:scale-110 transition-all duration-500 shadow-2xl border border-white/20">
                                    <i data-lucide="play" class="w-5 h-5 md:w-9 md:h-9 text-white fill-white ml-0.5 drop-shadow-lg"></i>
                                </div>
                            </div>
                            <div class="absolute bottom-3 md:bottom-4 right-3 md:right-4 bg-black/60 backdrop-blur-md text-white text-[10px] md:text-xs px-2 md:px-3 py-1 md:py-1.5 rounded-full font-mono">2:34</div>
                        </div>
                        <div class="p-3.5 md:p-6">
                            <div class="flex items-center justify-between mb-3 md:mb-4">
                                <div class="flex items-center gap-3 md:gap-5">
                                    <button onclick="toggleLike(this)" class="like-btn group flex items-center gap-1.5 md:gap-2 text-gray-500 hover:text-red-500 transition-all">
                                        <div class="w-7 h-7 md:w-9 md:h-9 rounded-full bg-gray-50 group-hover:bg-red-50 flex items-center justify-center transition-colors">
                                            <i data-lucide="heart" class="w-4 h-4 md:w-5 md:h-5"></i>
                                        </div>
                                        <span class="text-xs md:text-sm font-semibold text-gray-600">856</span>
                                    </button>
                                    <button class="group flex items-center gap-1.5 md:gap-2 text-gray-500 hover:text-primary-600 transition-all">
                                        <div class="w-7 h-7 md:w-9 md:h-9 rounded-full bg-gray-50 group-hover:bg-primary-50 flex items-center justify-center transition-colors">
                                            <i data-lucide="message-circle" class="w-4 h-4 md:w-5 md:h-5"></i>
                                        </div>
                                        <span class="text-xs md:text-sm font-semibold text-gray-600">45</span>
                                    </button>
                                    <button class="group flex items-center gap-1.5 md:gap-2 text-gray-500 hover:text-primary-600 transition-all">
                                        <div class="w-7 h-7 md:w-9 md:h-9 rounded-full bg-gray-50 group-hover:bg-primary-50 flex items-center justify-center transition-colors">
                                            <i data-lucide="share-2" class="w-4 h-4 md:w-5 md:h-5"></i>
                                        </div>
                                    </button>
                                </div>
                                <button class="group w-7 h-7 md:w-9 md:h-9 rounded-full bg-gray-50 hover:bg-gold-50 flex items-center justify-center transition-all">
                                    <i data-lucide="bookmark" class="w-4 h-4 md:w-5 md:h-5 text-gray-400 group-hover:text-gold-500"></i>
                                </button>
                            </div>
                            <p class="text-xs md:text-[15px] text-gray-700 leading-relaxed mb-3">
                                <span class="font-bold text-primary-900">David Kanda</span> Immersion dans les ateliers de Lubumbashi 🎥
                            </p>
                            <div class="flex flex-wrap gap-1.5 md:gap-2 mb-3">
                                <span class="text-gold-600 text-[10px] md:text-xs font-semibold bg-gold-50 px-2 md:px-2.5 py-0.5 md:py-1 rounded-full">#Artisanat</span>
                                <span class="text-gold-600 text-[10px] md:text-xs font-semibold bg-gold-50 px-2 md:px-2.5 py-0.5 md:py-1 rounded-full">#Congo</span>
                            </div>
                            <div class="flex items-center gap-2 md:gap-3 pt-3 md:pt-4 border-t border-gray-100">
                                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&h=100&fit=crop&crop=face" class="w-6 h-6 md:w-8 md:h-8 rounded-full object-cover ring-1 ring-gray-200 flex-shrink-0">
                                <input type="text" placeholder="Commentaire..." class="flex-1 text-xs md:text-sm bg-transparent focus:outline-none placeholder-gray-400 py-1 min-w-0">
                                <button class="text-gold-500 font-semibold text-xs md:text-sm hover:text-gold-600 transition-colors px-2 md:px-3 py-1 md:py-1.5 rounded-full hover:bg-gold-50 flex-shrink-0">Publier</button>
                            </div>
                        </div>
                    </article>

                    <!-- Post 3 -->
                    <article class="post-card bg-white rounded-[1.5rem] md:rounded-[2rem] shadow-sm overflow-hidden animate-card-enter stagger-3 opacity-0">
                        <div class="flex items-center justify-between p-3.5 md:p-6">
                            <div class="flex items-center space-x-2.5 md:space-x-3.5 min-w-0 flex-1">
                                <div class="relative flex-shrink-0">
                                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop&crop=face" class="relative w-9 h-9 md:w-12 md:h-12 rounded-full object-cover ring-2 ring-gold-200 ring-offset-2 ring-offset-white">
                                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 md:w-4 md:h-4 bg-gold-500 rounded-full border-[2px] md:border-[3px] border-white flex items-center justify-center">
                                        <i data-lucide="check" class="w-2 h-2 md:w-2.5 md:h-2.5 text-white"></i>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <span class="font-bold text-xs md:text-sm text-primary-900 truncate block">Amina Tshibola</span>
                                    <div class="flex items-center gap-1 text-[10px] md:text-xs text-gray-400 mt-0.5">
                                        <i data-lucide="map-pin" class="w-2.5 h-2.5 md:w-3 md:h-3 flex-shrink-0"></i>
                                        <span class="truncate">Goma</span>
                                        <span class="text-gray-300 flex-shrink-0">•</span>
                                        <span class="flex-shrink-0">Il y a 6h</span>
                                    </div>
                                </div>
                            </div>
                            <button class="text-gray-300 hover:text-gray-500 p-1 rounded-xl flex-shrink-0 ml-2">
                                <i data-lucide="more-horizontal" class="w-4 h-4 md:w-5 md:h-5"></i>
                            </button>
                        </div>
                        <div class="relative mx-1.5 md:mx-3 rounded-xl md:rounded-2xl overflow-hidden group cursor-pointer">
                            <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=800&h=600&fit=crop" class="img-zoom w-full aspect-[4/3] object-cover" loading="lazy">
                        </div>
                        <div class="p-3.5 md:p-6">
                            <div class="flex items-center justify-between mb-3 md:mb-4">
                                <div class="flex items-center gap-3 md:gap-5">
                                    <button onclick="toggleLike(this)" class="like-btn group flex items-center gap-1.5 md:gap-2 text-gray-500 hover:text-red-500 transition-all">
                                        <div class="w-7 h-7 md:w-9 md:h-9 rounded-full bg-gray-50 group-hover:bg-red-50 flex items-center justify-center transition-colors">
                                            <i data-lucide="heart" class="w-4 h-4 md:w-5 md:h-5"></i>
                                        </div>
                                        <span class="text-xs md:text-sm font-semibold text-gray-600">2,567</span>
                                    </button>
                                    <button class="group flex items-center gap-1.5 md:gap-2 text-gray-500 hover:text-primary-600 transition-all">
                                        <div class="w-7 h-7 md:w-9 md:h-9 rounded-full bg-gray-50 group-hover:bg-primary-50 flex items-center justify-center transition-colors">
                                            <i data-lucide="message-circle" class="w-4 h-4 md:w-5 md:h-5"></i>
                                        </div>
                                        <span class="text-xs md:text-sm font-semibold text-gray-600">234</span>
                                    </button>
                                    <button class="group flex items-center gap-1.5 md:gap-2 text-gray-500 hover:text-primary-600 transition-all">
                                        <div class="w-7 h-7 md:w-9 md:h-9 rounded-full bg-gray-50 group-hover:bg-primary-50 flex items-center justify-center transition-colors">
                                            <i data-lucide="share-2" class="w-4 h-4 md:w-5 md:h-5"></i>
                                        </div>
                                    </button>
                                </div>
                                <button class="group w-7 h-7 md:w-9 md:h-9 rounded-full bg-gray-50 hover:bg-gold-50 flex items-center justify-center transition-all">
                                    <i data-lucide="bookmark" class="w-4 h-4 md:w-5 md:h-5 text-gray-400 group-hover:text-gold-500"></i>
                                </button>
                            </div>
                            <p class="text-xs md:text-[15px] text-gray-700 leading-relaxed mb-3">
                                <span class="font-bold text-primary-900">Amina Tshibola</span> Le lac Kivu, joyau naturel 🌊💙
                            </p>
                            <div class="flex flex-wrap gap-1.5 md:gap-2 mb-3">
                                <span class="text-gold-600 text-[10px] md:text-xs font-semibold bg-gold-50 px-2 md:px-2.5 py-0.5 md:py-1 rounded-full">#Goma</span>
                                <span class="text-gold-600 text-[10px] md:text-xs font-semibold bg-gold-50 px-2 md:px-2.5 py-0.5 md:py-1 rounded-full">#LacKivu</span>
                            </div>
                            <div class="flex items-center gap-2 md:gap-3 pt-3 md:pt-4 border-t border-gray-100">
                                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&h=100&fit=crop&crop=face" class="w-6 h-6 md:w-8 md:h-8 rounded-full object-cover ring-1 ring-gray-200 flex-shrink-0">
                                <input type="text" placeholder="Commentaire..." class="flex-1 text-xs md:text-sm bg-transparent focus:outline-none placeholder-gray-400 py-1 min-w-0">
                                <button class="text-gold-500 font-semibold text-xs md:text-sm hover:text-gold-600 transition-colors px-2 md:px-3 py-1 md:py-1.5 rounded-full hover:bg-gold-50 flex-shrink-0">Publier</button>
                            </div>
                        </div>
                    </article>

                    <?php endif; ?>

                    <!-- Category Carousel -->
                    <div class="bg-white rounded-[1.5rem] md:rounded-[2rem] shadow-sm overflow-hidden p-4 md:p-8 animate-card-enter stagger-4 opacity-0">
                        <div class="flex items-center justify-between mb-4 md:mb-6">
                            <h3 class="text-sm md:text-xl font-bold text-primary-900 flex items-center gap-2 md:gap-2.5">
                                <span class="w-7 h-7 md:w-8 md:h-8 bg-gold-100 rounded-xl flex items-center justify-center">
                                    <i data-lucide="grid" class="w-3.5 h-3.5 md:w-4 md:h-4 text-gold-600"></i>
                                </span>
                                Par catégorie
                            </h3>
                            <div class="flex items-center gap-2 md:gap-3">
                                <button onclick="moveCarousel(-1)" class="w-7 h-7 md:w-9 md:h-9 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition-colors">
                                    <i data-lucide="chevron-left" class="w-3.5 h-3.5 md:w-4 md:h-4 text-gray-600"></i>
                                </button>
                                <button onclick="moveCarousel(1)" class="w-7 h-7 md:w-9 md:h-9 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition-colors">
                                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 md:w-4 md:h-4 text-gray-600"></i>
                                </button>
                            </div>
                        </div>
                        <?php if (!empty($homeCategories)): ?>
                            <div class="grid gap-3 sm:grid-cols-2">
                                <?php foreach ($homeCategories as $category): ?>
                                    <div class="rounded-2xl border border-gray-100 bg-gray-50 p-4 transition hover:border-gold-200 hover:bg-gold-50">
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-gold-600 shadow-sm">
                                                <i data-lucide="folder" class="h-5 w-5"></i>
                                            </span>
                                            <div class="min-w-0">
                                                <div class="truncate text-sm font-bold text-primary-900"><?php echo htmlspecialchars($category['nom'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div>
                                                <div class="text-xs text-gray-400">Categorie de la base de donnees</div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="rounded-2xl bg-gray-50 p-4 text-sm text-gray-500">Aucune categorie enregistree.</p>
                        <?php endif; ?>
                        <?php if (false): ?>
                        <div class="flex gap-1.5 md:gap-2 mb-4 md:mb-5 overflow-x-auto hide-scrollbar pb-1">
                            <button onclick="switchCategory('sport')" class="category-btn whitespace-nowrap px-3 py-2 md:px-4 md:py-2.5 rounded-full text-xs md:text-sm font-bold bg-gold-500 text-primary-900 shadow-lg shadow-gold-500/20 transition-all flex items-center gap-1.5 md:gap-2">
                                <span>🏅</span> Sport
                            </button>
                            <button onclick="switchCategory('sante')" class="category-btn whitespace-nowrap px-3 py-2 md:px-4 md:py-2.5 rounded-full text-xs md:text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all flex items-center gap-1.5 md:gap-2">
                                <span>❤️</span> Santé
                            </button>
                            <button onclick="switchCategory('science')" class="category-btn whitespace-nowrap px-3 py-2 md:px-4 md:py-2.5 rounded-full text-xs md:text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all flex items-center gap-1.5 md:gap-2">
                                <span>🔬</span> Science
                            </button>
                            <button onclick="switchCategory('culture')" class="category-btn whitespace-nowrap px-3 py-2 md:px-4 md:py-2.5 rounded-full text-xs md:text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all flex items-center gap-1.5 md:gap-2">
                                <span>🎨</span> Culture
                            </button>
                            <button onclick="switchCategory('tech')" class="category-btn whitespace-nowrap px-3 py-2 md:px-4 md:py-2.5 rounded-full text-xs md:text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all flex items-center gap-1.5 md:gap-2">
                                <span>💻</span> Tech
                            </button>
                        </div>
                        <div class="relative">
                            <div class="overflow-hidden rounded-xl md:rounded-2xl">
                                <div id="carouselTrack" class="flex transition-transform duration-500 ease-out gap-3 md:gap-4"></div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </main>

                <!-- Sidebar Desktop -->
                <aside class="hidden lg:block w-80 flex-shrink-0">
                    <div class="sticky top-24 space-y-5">
                        <div class="bg-white rounded-[2rem] shadow-sm p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-600 to-primary-800 flex items-center justify-center shadow-lg">
                                    <img src="img/hub2.png" class="w-10 h-10 object-contain brightness-110">
                                </div>
                                <div>
                                    <div class="font-bold text-primary-900 text-sm">Congo Explorer Hub</div>
                                    <div class="text-xs text-gray-500">Média & Agence créative</div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 leading-relaxed mb-4">Révélons l'autre visage du Congo.</p>
                            <div class="flex gap-3 text-xs">
                                <span class="flex items-center gap-1.5 text-gray-500 bg-gray-50 px-3 py-1.5 rounded-full"><i data-lucide="users" class="w-3.5 h-3.5"></i> 2.5k</span>
                                <span class="flex items-center gap-1.5 text-gray-500 bg-gray-50 px-3 py-1.5 rounded-full"><i data-lucide="file-text" class="w-3.5 h-3.5"></i> 120</span>
                            </div>
                        </div>
                        <div class="bg-white rounded-[2rem] shadow-sm p-6">
                            <h4 class="font-bold text-primary-900 text-sm mb-4 flex items-center gap-2"><i data-lucide="trending-up" class="w-4 h-4 text-gold-500"></i> Tendances</h4>
                            <div class="space-y-1">
                                <div class="hover:bg-gray-50 p-3 rounded-2xl transition-colors cursor-pointer"><div class="text-xs text-gray-400">Politique</div><div class="font-bold text-sm">#ElectionsRDC</div><div class="text-xs text-gray-400">12.5K posts</div></div>
                                <div class="hover:bg-gray-50 p-3 rounded-2xl transition-colors cursor-pointer"><div class="text-xs text-gray-400">Culture</div><div class="font-bold text-sm">#RumbaCongolaise</div><div class="text-xs text-gray-400">8.2K posts</div></div>
                                <div class="hover:bg-gray-50 p-3 rounded-2xl transition-colors cursor-pointer"><div class="text-xs text-gray-400">Tech</div><div class="font-bold text-sm">#StartupCongo</div><div class="text-xs text-gray-400">3.1K posts</div></div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- ========== ABOUT SECTION ========== -->
    <section id="about" class="py-12 md:py-24 bg-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-gold-50 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute bottom-0 left-0 w-[300px] md:w-[400px] h-[300px] md:h-[400px] bg-primary-50 rounded-full blur-3xl opacity-40"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-20 items-center">
                <div>
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 md:px-4 md:py-2 bg-primary-50 text-primary-700 rounded-full text-xs md:text-sm font-semibold mb-4 md:mb-6">
                        <span class="w-1.5 h-1.5 bg-primary-600 rounded-full"></span> Qui sommes-nous
                    </span>
                    <h2 class="font-serif text-2xl md:text-4xl lg:text-5xl font-bold text-primary-900 mb-4 md:mb-6 leading-tight">
                        Un média engagé pour <span class="text-gold-500">changer le narratif</span>
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4 text-sm md:text-base">
                        <strong class="text-primary-900">Congo Explorer Hub</strong> est né d'une conviction profonde : le Congo mérite d'être vu autrement. Nous mettons en lumière les talents, les initiatives et les événements qui façonnent un avenir positif pour notre pays.
                    </p>
                    <p class="text-gray-600 leading-relaxed mb-6 md:mb-8 text-sm md:text-base">
                        Jeune structure dynamique lancée en 2026, nous allions <strong class="text-primary-900">créativité</strong>, <strong class="text-primary-900">réactivité</strong> et <strong class="text-primary-900">connaissance du terrain</strong> pour offrir des solutions sur-mesure à nos partenaires.
                    </p>
                    <div class="flex items-center gap-4 p-4 md:p-5 bg-primary-50/50 rounded-2xl border border-primary-100/50">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-primary-900 rounded-2xl flex items-center justify-center text-gold-400 font-bold text-base md:text-lg shadow-lg flex-shrink-0">?</div>
                        <div>
                            <div class="font-semibold text-primary-900 text-sm md:text-base">Une question, un projet ?</div>
                            <div class="text-xs md:text-sm text-gray-500">Notre équipe est à votre écoute</div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="relative rounded-2xl md:rounded-3xl overflow-hidden shadow-2xl shadow-primary-900/10">
                        <img src="https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?w=600&h=700&fit=crop" class="w-full h-[280px] md:h-[400px] lg:h-[500px] object-cover" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-primary-900/50 via-transparent to-transparent"></div>
                        <div class="absolute bottom-4 md:bottom-6 left-4 md:left-6 text-white">
                            <div class="text-xl md:text-3xl font-bold font-display">Congo</div>
                            <div class="text-xs md:text-sm text-white/70">Explorer Hub</div>
                        </div>
                    </div>
                    <div class="absolute -bottom-6 -left-6 md:-bottom-8 md:-left-8 bg-gold-500 text-primary-900 p-4 md:p-5 rounded-2xl shadow-2xl shadow-gold-500/30">
                        <div class="text-xl md:text-2xl font-bold font-display">2026</div>
                        <div class="text-xs md:text-sm font-semibold">Lancement</div>
                    </div>
                    <div class="absolute -top-4 -right-4 md:-top-6 md:-right-6 w-12 h-12 md:w-16 md:h-16 bg-white rounded-2xl flex items-center justify-center shadow-xl rotate-6">
                        <i data-lucide="sparkles" class="w-6 h-6 md:w-8 md:h-8 text-gold-500"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SERVICES SECTION ========== -->
    <section id="services" class="py-12 md:py-24 bg-[#f9f7f3] relative overflow-hidden">
        <!-- Decorative background -->
        <div class="absolute top-0 left-0 w-full h-full opacity-[0.03]" style="background-image: radial-gradient(circle at 1px 1px, #1a2e2a 1px, transparent 0); background-size: 50px 50px;"></div>
        <div class="absolute top-1/4 right-0 w-[400px] md:w-[600px] h-[400px] md:h-[600px] bg-gold-100/50 rounded-full blur-[100px] md:blur-[150px] opacity-40"></div>
        <div class="absolute bottom-0 left-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-primary-100/50 rounded-full blur-[100px] md:blur-[150px] opacity-30"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center mb-12 md:mb-20">
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 md:px-4 md:py-2 bg-gold-100/80 text-gold-700 rounded-full text-xs md:text-sm font-semibold mb-4 md:mb-5 backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 bg-gold-500 rounded-full"></span>
                    Nos expertises
                </span>
                <h2 class="font-serif text-3xl md:text-5xl lg:text-6xl font-bold text-primary-900 mb-4 md:mb-6 leading-tight">
                    Des solutions <span class="text-gold-500">sur-mesure</span>
                </h2>
                <p class="text-gray-500 max-w-xl mx-auto text-sm md:text-lg leading-relaxed">
                    Communication, marketing, événementiel : nous couvrons tous les aspects pour faire rayonner votre projet.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-8">
                <!-- Service 1 : Communication -->
                <div class="feature-card bg-white rounded-[2rem] p-5 md:p-8 shadow-sm card-hover group cursor-pointer relative overflow-hidden border border-gray-100">
                    <div class="service-blob w-40 h-40 bg-gold-200 -top-10 -right-10"></div>
                    <div class="relative">
                        <div class="feature-icon w-12 h-12 md:w-14 md:h-14 bg-primary-50 rounded-2xl flex items-center justify-center mb-4 md:mb-5 text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-all duration-500">
                            <i data-lucide="camera" class="w-6 h-6 md:w-7 md:h-7"></i>
                        </div>
                        <h3 class="text-lg md:text-xl font-bold text-primary-900 mb-2 md:mb-3 font-display">Communication & Contenu</h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-4 md:mb-6">
                            Production éditoriale, photo et vidéo. Interviews, reportages et couverture d'événements pour donner de l'écho aux initiatives locales.
                        </p>
                        <ul class="space-y-2 md:space-y-2.5 mb-4 md:mb-6">
                            <li class="flex items-center text-xs md:text-sm text-gray-600">
                                <i data-lucide="check-circle" class="w-4 h-4 text-gold-500 mr-2 md:mr-2.5 flex-shrink-0"></i> Reportages & interviews
                            </li>
                            <li class="flex items-center text-xs md:text-sm text-gray-600">
                                <i data-lucide="check-circle" class="w-4 h-4 text-gold-500 mr-2 md:mr-2.5 flex-shrink-0"></i> Live coverage événementiel
                            </li>
                            <li class="flex items-center text-xs md:text-sm text-gray-600">
                                <i data-lucide="check-circle" class="w-4 h-4 text-gold-500 mr-2 md:mr-2.5 flex-shrink-0"></i> Contenus éditoriaux engageants
                            </li>
                        </ul>
                        <a href="#contact" class="inline-flex items-center text-primary-600 font-semibold text-xs md:text-sm group-hover:text-gold-600 transition-colors">
                            En savoir plus
                            <i data-lucide="arrow-right" class="w-4 h-4 ml-1.5 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>

                <!-- Service 2 : Marketing -->
                <div class="feature-card bg-white rounded-[2rem] p-5 md:p-8 shadow-sm card-hover group cursor-pointer relative overflow-hidden border border-gray-100">
                    <div class="service-blob w-40 h-40 bg-primary-200 -bottom-10 -left-10"></div>
                    <div class="relative">
                        <div class="feature-icon w-12 h-12 md:w-14 md:h-14 bg-gold-50 rounded-2xl flex items-center justify-center mb-4 md:mb-5 text-gold-600 group-hover:bg-gold-500 group-hover:text-white transition-all duration-500">
                            <i data-lucide="megaphone" class="w-6 h-6 md:w-7 md:h-7"></i>
                        </div>
                        <h3 class="text-lg md:text-xl font-bold text-primary-900 mb-2 md:mb-3 font-display">Marketing 360°</h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-4 md:mb-6">
                            Stratégies digitales et physiques pour les marques et projets. Campagnes social media, influence, street marketing et activations terrain.
                        </p>
                        <ul class="space-y-2 md:space-y-2.5 mb-4 md:mb-6">
                            <li class="flex items-center text-xs md:text-sm text-gray-600">
                                <i data-lucide="check-circle" class="w-4 h-4 text-gold-500 mr-2 md:mr-2.5 flex-shrink-0"></i> Stratégie social media
                            </li>
                            <li class="flex items-center text-xs md:text-sm text-gray-600">
                                <i data-lucide="check-circle" class="w-4 h-4 text-gold-500 mr-2 md:mr-2.5 flex-shrink-0"></i> Marketing d'influence
                            </li>
                            <li class="flex items-center text-xs md:text-sm text-gray-600">
                                <i data-lucide="check-circle" class="w-4 h-4 text-gold-500 mr-2 md:mr-2.5 flex-shrink-0"></i> Activations terrain & street marketing
                            </li>
                        </ul>
                        <a href="#contact" class="inline-flex items-center text-primary-600 font-semibold text-xs md:text-sm group-hover:text-gold-600 transition-colors">
                            En savoir plus
                            <i data-lucide="arrow-right" class="w-4 h-4 ml-1.5 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>

                <!-- Service 3 : Événementiel -->
                <div class="feature-card bg-white rounded-[2rem] p-5 md:p-8 shadow-sm card-hover group cursor-pointer relative overflow-hidden border border-gray-100 sm:col-span-2 lg:col-span-1">
                    <div class="service-blob w-40 h-40 bg-gold-200 -top-10 -left-10"></div>
                    <div class="relative">
                        <div class="feature-icon w-12 h-12 md:w-14 md:h-14 bg-primary-50 rounded-2xl flex items-center justify-center mb-4 md:mb-5 text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-all duration-500">
                            <i data-lucide="calendar-star" class="w-6 h-6 md:w-7 md:h-7"></i>
                        </div>
                        <h3 class="text-lg md:text-xl font-bold text-primary-900 mb-2 md:mb-3 font-display">Événementiel</h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-4 md:mb-6">
                            Conception et pilotage d'expériences sur-mesure. De l'idéation à la production, nous créons des moments à fort impact qui marquent les esprits.
                        </p>
                        <ul class="space-y-2 md:space-y-2.5 mb-4 md:mb-6">
                            <li class="flex items-center text-xs md:text-sm text-gray-600">
                                <i data-lucide="check-circle" class="w-4 h-4 text-gold-500 mr-2 md:mr-2.5 flex-shrink-0"></i> Conception créative sur-mesure
                            </li>
                            <li class="flex items-center text-xs md:text-sm text-gray-600">
                                <i data-lucide="check-circle" class="w-4 h-4 text-gold-500 mr-2 md:mr-2.5 flex-shrink-0"></i> Production & logistique complète
                            </li>
                            <li class="flex items-center text-xs md:text-sm text-gray-600">
                                <i data-lucide="check-circle" class="w-4 h-4 text-gold-500 mr-2 md:mr-2.5 flex-shrink-0"></i> Pilotage & coordination A à Z
                            </li>
                        </ul>
                        <a href="#contact" class="inline-flex items-center text-primary-600 font-semibold text-xs md:text-sm group-hover:text-gold-600 transition-colors">
                            En savoir plus
                            <i data-lucide="arrow-right" class="w-4 h-4 ml-1.5 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== VISION SECTION ========== -->
    <section id="vision" class="py-12 md:py-24 bg-primary-900 text-white relative overflow-hidden">
        <!-- Background patterns -->
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 50px 50px;"></div>
        <div class="absolute top-0 right-0 w-[400px] md:w-[700px] h-[400px] md:h-[700px] bg-gold-500/5 rounded-full blur-[120px] md:blur-[180px] -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-[400px] md:w-[600px] h-[400px] md:h-[600px] bg-primary-400/5 rounded-full blur-[120px] md:blur-[150px] translate-y-1/2 -translate-x-1/4"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center mb-12 md:mb-20">
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 md:px-4 md:py-2 bg-gold-500/15 text-gold-300 rounded-full text-xs md:text-sm font-semibold mb-4 md:mb-5 backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 bg-gold-400 rounded-full"></span>
                    Notre vision
                </span>
                <h2 class="font-serif text-3xl md:text-5xl lg:text-6xl font-bold mb-4 md:mb-6 leading-tight">
                    Changer le narratif,<br class="sm:hidden"> <span class="text-gold-400">un projet à la fois</span>
                </h2>
                <p class="text-white/50 max-w-xl mx-auto text-sm md:text-lg leading-relaxed">
                    Congo Explorer Hub n'est pas qu'un simple média. C'est un mouvement. Une volonté de montrer au monde que le Congo est bien plus que ce qu'on en dit.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 max-w-5xl mx-auto">
                <!-- Vision 1 -->
                <div class="vision-card bg-white/3 rounded-3xl p-5 md:p-8 text-center border border-white/5 hover:border-gold-500/20 transition-all group cursor-pointer">
                    <div class="w-14 h-14 md:w-16 md:h-16 bg-gold-500/15 rounded-2xl flex items-center justify-center mx-auto mb-4 md:mb-5 group-hover:bg-gold-500/25 transition-all">
                        <i data-lucide="lightbulb" class="w-7 h-7 md:w-8 md:h-8 text-gold-400"></i>
                    </div>
                    <h3 class="font-bold text-lg md:text-xl mb-2 md:mb-3 font-display text-white">Révéler</h3>
                    <p class="text-white/40 text-xs md:text-sm leading-relaxed">
                        Mettre en lumière les talents et initiatives qui transforment le Congo de l'intérieur.
                    </p>
                </div>

                <!-- Vision 2 -->
                <div class="vision-card bg-white/3 rounded-3xl p-5 md:p-8 text-center border border-white/5 hover:border-gold-500/20 transition-all group cursor-pointer">
                    <div class="w-14 h-14 md:w-16 md:h-16 bg-gold-500/15 rounded-2xl flex items-center justify-center mx-auto mb-4 md:mb-5 group-hover:bg-gold-500/25 transition-all">
                        <i data-lucide="link" class="w-7 h-7 md:w-8 md:h-8 text-gold-400"></i>
                    </div>
                    <h3 class="font-bold text-lg md:text-xl mb-2 md:mb-3 font-display text-white">Connecter</h3>
                    <p class="text-white/40 text-xs md:text-sm leading-relaxed">
                        Créer des ponts entre les acteurs pour bâtir un écosystème plus fort et solidaire.
                    </p>
                </div>

                <!-- Vision 3 -->
                <div class="vision-card bg-white/3 rounded-3xl p-5 md:p-8 text-center border border-white/5 hover:border-gold-500/20 transition-all group cursor-pointer">
                    <div class="w-14 h-14 md:w-16 md:h-16 bg-gold-500/15 rounded-2xl flex items-center justify-center mx-auto mb-4 md:mb-5 group-hover:bg-gold-500/25 transition-all">
                        <i data-lucide="rocket" class="w-7 h-7 md:w-8 md:h-8 text-gold-400"></i>
                    </div>
                    <h3 class="font-bold text-lg md:text-xl mb-2 md:mb-3 font-display text-white">Inspirer</h3>
                    <p class="text-white/40 text-xs md:text-sm leading-relaxed">
                        Montrer que tout est possible avec de la passion, du travail et de la détermination.
                    </p>
                </div>

                <!-- Vision 4 -->
                <div class="vision-card bg-white/3 rounded-3xl p-5 md:p-8 text-center border border-white/5 hover:border-gold-500/20 transition-all group cursor-pointer sm:col-span-2 lg:col-span-1">
                    <div class="w-14 h-14 md:w-16 md:h-16 bg-gold-500/15 rounded-2xl flex items-center justify-center mx-auto mb-4 md:mb-5 group-hover:bg-gold-500/25 transition-all">
                        <i data-lucide="globe" class="w-7 h-7 md:w-8 md:h-8 text-gold-400"></i>
                    </div>
                    <h3 class="font-bold text-lg md:text-xl mb-2 md:mb-3 font-display text-white">Rayonner</h3>
                    <p class="text-white/40 text-xs md:text-sm leading-relaxed">
                        Porter la voix du Congo au-delà des frontières et inspirer le monde entier.
                    </p>
                </div>
            </div>

            <!-- Quote -->
            <div class="mt-12 md:mt-16 text-center max-w-2xl mx-auto">
                <div class="relative inline-block">
                    <i data-lucide="quote" class="w-8 h-8 md:w-10 md:h-10 text-gold-500/30 absolute -top-4 -left-4 md:-top-6 md:-left-6"></i>
                    <p class="font-serif text-lg md:text-2xl text-white/70 italic leading-relaxed px-4">
                        "Le Congo n'est pas un pays pauvre, c'est un pays riche dont les richesses n'ont pas encore été pleinement révélées au monde."
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== CTA SECTION ========== -->
    <section id="contact" class="py-12 md:py-24 bg-gradient-to-br from-primary-800 via-primary-900 to-primary-950 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-gold-500/8 rounded-full blur-[100px] md:blur-[150px]"></div>
        <div class="absolute bottom-0 left-0 w-[300px] md:w-[400px] h-[300px] md:h-[400px] bg-primary-500/10 rounded-full blur-[100px] md:blur-[120px]"></div>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
            <h2 class="font-serif text-3xl md:text-5xl lg:text-6xl font-bold mb-4 md:mb-6">
                Prêt à révéler <span class="text-gold-400">votre histoire</span> ?
            </h2>
            <p class="text-white/50 text-sm md:text-lg mb-8 md:mb-10 max-w-lg mx-auto leading-relaxed">
                Que vous soyez une marque, un artiste, une organisation ou un talent, nous sommes là pour vous accompagner dans votre visibilité et votre impact.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center">
                <a href="mailto:contact@congoexplorerhub.com" class="group px-6 py-3 md:px-8 md:py-4 bg-gold-500 text-primary-900 font-bold rounded-2xl hover:bg-gold-400 transition-all transform hover:scale-105 shadow-2xl shadow-gold-500/20 flex items-center justify-center gap-2 text-sm md:text-base">
                    <i data-lucide="mail" class="w-4 h-4 md:w-5 md:h-5"></i> Nous contacter
                    <i data-lucide="arrow-up-right" class="w-3.5 h-3.5 md:w-4 md:h-4 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"></i>
                </a>
                <a href="#" class="px-6 py-3 md:px-8 md:py-4 border-2 border-white/15 text-white font-semibold rounded-2xl hover:bg-white/5 transition-all flex items-center justify-center gap-2 text-sm md:text-base backdrop-blur-sm">
                    <i data-lucide="download" class="w-4 h-4 md:w-5 md:h-5"></i> Notre plaquette
                </a>
            </div>
            <div class="flex justify-center gap-3 md:gap-4 mt-8 md:mt-10">
                <a href="#" class="w-9 h-9 md:w-10 md:h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-gold-500 hover:text-primary-900 transition-all duration-300"><i data-lucide="instagram" class="w-4 h-4 md:w-5 md:h-5"></i></a>
                <a href="#" class="w-9 h-9 md:w-10 md:h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-gold-500 hover:text-primary-900 transition-all duration-300"><i data-lucide="twitter" class="w-4 h-4 md:w-5 md:h-5"></i></a>
                <a href="#" class="w-9 h-9 md:w-10 md:h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-gold-500 hover:text-primary-900 transition-all duration-300"><i data-lucide="facebook" class="w-4 h-4 md:w-5 md:h-5"></i></a>
                <a href="#" class="w-9 h-9 md:w-10 md:h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-gold-500 hover:text-primary-900 transition-all duration-300"><i data-lucide="youtube" class="w-4 h-4 md:w-5 md:h-5"></i></a>
                <a href="#" class="w-9 h-9 md:w-10 md:h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-gold-500 hover:text-primary-900 transition-all duration-300"><i data-lucide="linkedin" class="w-4 h-4 md:w-5 md:h-5"></i></a>
            </div>
        </div>
    </section>

    <!-- ========== FOOTER PREMIUM ========== -->
    <footer class="relative bg-[#0d1714] text-white overflow-hidden">
        <div class="h-[2px] bg-gradient-to-r from-transparent via-gold-500/50 to-transparent"></div>
        <div class="absolute top-0 right-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-primary-800/20 rounded-full blur-[100px] md:blur-[150px] -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-[250px] md:w-[400px] h-[250px] md:h-[400px] bg-gold-900/10 rounded-full blur-[80px] md:blur-[120px] translate-y-1/2 -translate-x-1/4"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative py-12 md:py-20">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8 md:gap-10">
                <!-- Brand -->
                <div class="sm:col-span-2 lg:col-span-2">
                    <div class="flex items-center space-x-3 mb-4 md:mb-6">
                        <div class="w-10 h-10 md:w-11 md:h-11 rounded-2xl bg-white/5 flex items-center justify-center border border-white/10">
                            <img src="img/hub2.png" alt="CEH" class="w-7 h-7 md:w-8 md:h-8 object-contain brightness-125">
                        </div>
                        <span class="text-white font-bold text-lg md:text-xl tracking-tight font-display">
                            Congo<span class="text-gold-400">Explorer</span>Hub
                        </span>
                    </div>
                    <p class="text-white/35 text-xs md:text-sm leading-relaxed mb-4 md:mb-6 max-w-xs">
                        L'autre visage du Congo. Nous révélons les talents, les acteurs et les événements qui façonnent positivement l'écosystème congolais.
                    </p>
                    <div class="flex gap-2 md:gap-3">
                        <a href="#" class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-gold-500 hover:text-primary-900 transition-all duration-300">
                            <i data-lucide="instagram" class="w-3.5 h-3.5 md:w-4 md:h-4"></i>
                        </a>
                        <a href="#" class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-gold-500 hover:text-primary-900 transition-all duration-300">
                            <i data-lucide="twitter" class="w-3.5 h-3.5 md:w-4 md:h-4"></i>
                        </a>
                        <a href="#" class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-gold-500 hover:text-primary-900 transition-all duration-300">
                            <i data-lucide="facebook" class="w-3.5 h-3.5 md:w-4 md:h-4"></i>
                        </a>
                        <a href="#" class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-gold-500 hover:text-primary-900 transition-all duration-300">
                            <i data-lucide="youtube" class="w-3.5 h-3.5 md:w-4 md:h-4"></i>
                        </a>
                        <a href="#" class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-gold-500 hover:text-primary-900 transition-all duration-300">
                            <i data-lucide="linkedin" class="w-3.5 h-3.5 md:w-4 md:h-4"></i>
                        </a>
                    </div>
                </div>

                <!-- Navigation -->
                <div>
                    <h4 class="text-white font-bold text-xs md:text-sm mb-4 md:mb-5 tracking-wide uppercase">Navigation</h4>
                    <ul class="space-y-2 md:space-y-3">
                        <li><a href="#hero" class="footer-link text-white/40 text-xs md:text-sm hover:text-gold-400 transition-colors">Accueil</a></li>
                        <li><a href="#feed" class="footer-link text-white/40 text-xs md:text-sm hover:text-gold-400 transition-colors">Fil d'actualité</a></li>
                        <li><a href="#about" class="footer-link text-white/40 text-xs md:text-sm hover:text-gold-400 transition-colors">Qui sommes-nous</a></li>
                        <li><a href="#services" class="footer-link text-white/40 text-xs md:text-sm hover:text-gold-400 transition-colors">Services</a></li>
                        <li><a href="#vision" class="footer-link text-white/40 text-xs md:text-sm hover:text-gold-400 transition-colors">Notre vision</a></li>
                        <li><a href="<?php echo BASE_URL; ?>login" class="footer-link text-white/40 text-xs md:text-sm hover:text-gold-400 transition-colors">Se connecter</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="text-white font-bold text-xs md:text-sm mb-4 md:mb-5 tracking-wide uppercase">Expertises</h4>
                    <ul class="space-y-2 md:space-y-3">
                        <li><a href="#services" class="footer-link text-white/40 text-xs md:text-sm hover:text-gold-400 transition-colors">Communication</a></li>
                        <li><a href="#services" class="footer-link text-white/40 text-xs md:text-sm hover:text-gold-400 transition-colors">Marketing 360°</a></li>
                        <li><a href="#services" class="footer-link text-white/40 text-xs md:text-sm hover:text-gold-400 transition-colors">Événementiel</a></li>
                        <li><a href="#services" class="footer-link text-white/40 text-xs md:text-sm hover:text-gold-400 transition-colors">Production vidéo</a></li>
                        <li><a href="#services" class="footer-link text-white/40 text-xs md:text-sm hover:text-gold-400 transition-colors">Stratégie digitale</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-white font-bold text-xs md:text-sm mb-4 md:mb-5 tracking-wide uppercase">Contact</h4>
                    <div class="space-y-2.5 md:space-y-3">
                        <a href="mailto:contact@congoexplorerhub.com" class="flex items-center gap-2 text-white/40 text-xs md:text-sm hover:text-gold-400 transition-colors">
                            <i data-lucide="mail" class="w-3.5 h-3.5 md:w-4 md:h-4 text-gold-500/60 flex-shrink-0"></i> 
                            <span class="break-all">contact@congoexplorerhub.com</span>
                        </a>
                        <div class="flex items-center gap-2 text-white/40 text-xs md:text-sm">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 md:w-4 md:h-4 text-gold-500/60 flex-shrink-0"></i> 
                            Kinshasa, RDC
                        </div>
                        <div class="flex items-center gap-2 text-white/40 text-xs md:text-sm">
                            <i data-lucide="phone" class="w-3.5 h-3.5 md:w-4 md:h-4 text-gold-500/60 flex-shrink-0"></i> 
                            +243 000 000 000
                        </div>
                    </div>
                    <!-- Newsletter -->
                    <div class="mt-4 md:mt-6">
                        <p class="text-white/30 text-xs mb-2 md:mb-3">Restons connectés</p>
                        <form class="flex gap-2" onsubmit="event.preventDefault();">
                            <input type="email" placeholder="Votre email" class="flex-1 px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-xs text-white placeholder-white/20 focus:outline-none focus:ring-1 focus:ring-gold-500/40 focus:border-transparent transition-all min-w-0">
                            <button type="submit" class="px-3 py-2 bg-gold-500 text-primary-900 font-bold text-xs rounded-xl hover:bg-gold-400 transition-all flex items-center gap-1 flex-shrink-0">
                                <i data-lucide="send" class="w-3.5 h-3.5"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="mt-10 md:mt-14 pt-6 md:pt-8 border-t border-white/5 flex flex-col sm:flex-row justify-between items-center gap-3 md:gap-4">
                <p class="text-white/25 text-xs md:text-sm">
                    &copy; 2026 Congo Explorer Hub. Tous droits réservés.
                </p>
                <div class="flex gap-4 md:gap-6 text-xs md:text-sm text-white/25">
                    <a href="#" class="hover:text-gold-400 transition-colors">Politique de confidentialité</a>
                    <a href="#" class="hover:text-gold-400 transition-colors">Conditions d'utilisation</a>
                    <a href="#" class="hover:text-gold-400 transition-colors">Mentions légales</a>
                </div>
                <p class="text-white/25 text-xs md:text-sm flex items-center gap-1.5">
                    Fait par <span class="text-gold-400"><a href="https://wa.me/+243997019883" target="_blank">Lad_77</a></span> avec <span class="text-red-400">❤️</span> Chez Evotech Africa
                </p>
            </div>
        </div>
    </footer>

    <script>
        const iconPaths = {
            search: '<circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>',
            bell: '<path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>',
            'arrow-up-right': '<path d="M7 17L17 7"/><path d="M7 7h10v10"/>',
            menu: '<path d="M4 6h16"/><path d="M4 12h16"/><path d="M4 18h16"/>',
            x: '<path d="M18 6L6 18"/><path d="M6 6l12 12"/>',
            'arrow-right': '<path d="M5 12h14"/><path d="M12 5l7 7-7 7"/>',
            'play-circle': '<circle cx="12" cy="12" r="10"/><path d="M10 8l6 4-6 4z"/>',
            play: '<path d="M8 5v14l11-7z"/>',
            tag: '<path d="M20.6 13.1l-7.5 7.5a2 2 0 0 1-2.8 0L3 13.3V3h10.3l7.3 7.3a2 2 0 0 1 0 2.8z"/><circle cx="7.5" cy="7.5" r=".5"/>',
            heart: '<path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/>',
            'message-circle': '<path d="M21 11.5a8.4 8.4 0 0 1-9 8.5 8.5 8.5 0 0 1-4.1-1.1L3 20l1.1-4.5A8.5 8.5 0 1 1 21 11.5z"/>',
            'share-2': '<circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="M8.6 13.5l6.8 4"/><path d="M15.4 6.5l-6.8 4"/>',
            bookmark: '<path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>',
            newspaper: '<path d="M4 19a2 2 0 0 0 2 2h14"/><path d="M6 17V3H4a2 2 0 0 0-2 2v14"/><path d="M8 5h10v12H8z"/><path d="M10 9h6"/><path d="M10 13h6"/>',
            check: '<path d="M20 6L9 17l-5-5"/>',
            'check-circle': '<circle cx="12" cy="12" r="10"/><path d="M9 12l2 2 4-4"/>',
            'map-pin': '<path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0z"/><circle cx="12" cy="10" r="3"/>',
            'more-horizontal': '<circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/>',
            grid: '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
            'chevron-left': '<path d="M15 18l-6-6 6-6"/>',
            'chevron-right': '<path d="M9 18l6-6-6-6"/>',
            folder: '<path d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>',
            users: '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
            'file-text': '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/>',
            'trending-up': '<path d="M3 17l6-6 4 4 8-8"/><path d="M14 7h7v7"/>',
            sparkles: '<path d="M12 3l1.7 5.3L19 10l-5.3 1.7L12 17l-1.7-5.3L5 10l5.3-1.7z"/><path d="M5 3v4"/><path d="M3 5h4"/><path d="M19 17v4"/><path d="M17 19h4"/>',
            camera: '<path d="M14.5 4l1.5 2H20a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l1.5-2z"/><circle cx="12" cy="13" r="4"/>',
            megaphone: '<path d="M3 11v2a2 2 0 0 0 2 2h2l4 5V4L7 9H5a2 2 0 0 0-2 2z"/><path d="M16 8a5 5 0 0 1 0 8"/><path d="M19 5a9 9 0 0 1 0 14"/>',
            'calendar-star': '<path d="M8 2v4"/><path d="M16 2v4"/><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M3 10h18"/><path d="M12 14l.8 1.7 1.8.2-1.3 1.3.3 1.8-1.6-.9-1.6.9.3-1.8-1.3-1.3 1.8-.2z"/>',
            lightbulb: '<path d="M9 18h6"/><path d="M10 22h4"/><path d="M12 2a7 7 0 0 0-4 12c.7.6 1 1.5 1 2h6c0-.5.3-1.4 1-2a7 7 0 0 0-4-12z"/>',
            link: '<path d="M10 13a5 5 0 0 0 7.1 0l2-2a5 5 0 0 0-7.1-7.1l-1.1 1.1"/><path d="M14 11a5 5 0 0 0-7.1 0l-2 2a5 5 0 0 0 7.1 7.1l1.1-1.1"/>',
            rocket: '<path d="M4.5 16.5c-1 1-1.5 3-1.5 3s2-.5 3-1.5"/><path d="M9 15l-2-2a12 12 0 0 1 8-10l4-1-1 4a12 12 0 0 1-10 8z"/><path d="M15 9h.01"/>',
            globe: '<circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15 15 0 0 1 0 20"/><path d="M12 2a15 15 0 0 0 0 20"/>',
            quote: '<path d="M3 21c3-2 4-5 4-8V5H3v8h4"/><path d="M14 21c3-2 4-5 4-8V5h-4v8h4"/>',
            mail: '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
            download: '<path d="M12 3v12"/><path d="M7 10l5 5 5-5"/><path d="M5 21h14"/>',
            instagram: '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".5"/>',
            twitter: '<path d="M4 4l16 16"/><path d="M20 4L4 20"/>',
            facebook: '<path d="M14 8h3V4h-3a5 5 0 0 0-5 5v3H6v4h3v6h4v-6h3l1-4h-4V9a1 1 0 0 1 1-1z"/>',
            youtube: '<path d="M22 12s0-3-1-4-4-1-9-1-8 0-9 1-1 4-1 4 0 3 1 4 4 1 9 1 8 0 9-1 1-4 1-4z"/><path d="M10 9l5 3-5 3z"/>',
            linkedin: '<path d="M6 9H3v12h3z"/><circle cx="4.5" cy="4.5" r="1.5"/><path d="M10 9h3v2a4 4 0 0 1 7 3v7h-3v-6a2 2 0 0 0-4 0v6h-3z"/>',
            phone: '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.3 1.8.7 2.6a2 2 0 0 1-.5 2.1L8 9.7a16 16 0 0 0 6.3 6.3l1.3-1.3a2 2 0 0 1 2.1-.5c.8.3 1.7.6 2.6.7a2 2 0 0 1 1.7 2z"/>',
            send: '<path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4z"/>'
        };

        function fallbackIcon(name) {
            const path = iconPaths[name] || '<circle cx="12" cy="12" r="9"/><path d="M12 8v4"/><path d="M12 16h.01"/>';
            return `<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">${path}</svg>`;
        }

        function renderIcons() {
            document.querySelectorAll('i[data-lucide]').forEach((icon) => {
                icon.innerHTML = fallbackIcon(icon.dataset.lucide);
            });
        }

        renderIcons();

        // ===== CATEGORY CAROUSEL =====
        const categoryData = {
            sport: [
                { title: "Les Léopards en préparation", img: "https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=400&h=300&fit=crop", desc: "Stage intensif avant la CAN 2026" },
                { title: "Marathon de Kinshasa", img: "https://images.unsplash.com/photo-1552674605-db6ffd4facb5?w=400&h=300&fit=crop", desc: "Plus de 5000 participants attendus" },
                { title: "Finale du championnat", img: "https://images.unsplash.com/photo-1546519638-68e109498ffc?w=400&h=300&fit=crop", desc: "Un match historique en perspective" },
                { title: "Football féminin RDC", img: "https://images.unsplash.com/photo-1575361204480-aadea25e6e68?w=400&h=300&fit=crop", desc: "Les talents émergents du pays" }
            ],
            sante: [
                { title: "Campagne de vaccination", img: "https://images.unsplash.com/photo-1584483766114-2cea6facdf57?w=400&h=300&fit=crop", desc: "Protégeons nos enfants ensemble" },
                { title: "Nutrition au Congo", img: "https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=400&h=300&fit=crop", desc: "Manger sain, vivre mieux" },
                { title: "Hôpital moderne", img: "https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=400&h=300&fit=crop", desc: "Des soins de qualité pour tous" }
            ],
            science: [
                { title: "Innovation Lab", img: "https://images.unsplash.com/photo-1507413245164-6160d8298b31?w=400&h=300&fit=crop", desc: "Les jeunes talents tech congolais" },
                { title: "Énergies renouvelables", img: "https://images.unsplash.com/photo-1509391366360-2e959784a276?w=400&h=300&fit=crop", desc: "Le solaire au service du Congo" },
                { title: "Robotique éducative", img: "https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=400&h=300&fit=crop", desc: "Former la relève de demain" }
            ],
            culture: [
                { title: "Festival des arts", img: "https://images.unsplash.com/photo-1533106497176-45ae19e68ba2?w=400&h=300&fit=crop", desc: "La richesse culturelle congolaise" },
                { title: "Mode congolaise", img: "https://images.unsplash.com/photo-1485968579580-b6d095142e6e?w=400&h=300&fit=crop", desc: "Les créateurs qui émergent" },
                { title: "Gastronomie locale", img: "https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400&h=300&fit=crop", desc: "Saveurs authentiques du terroir" }
            ],
            tech: [
                { title: "Startups RDC", img: "https://images.unsplash.com/photo-1559136555-9303baea8ebd?w=400&h=300&fit=crop", desc: "L'écosystème tech en croissance" },
                { title: "Coding Bootcamp", img: "https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop", desc: "Former les développeurs de demain" },
                { title: "Fintech au Congo", img: "https://images.unsplash.com/photo-1563986768609-322da13575f2?w=400&h=300&fit=crop", desc: "La révolution financière numérique" }
            ]
        };

        let currentCategory = 'sport';
        let currentSlide = 0;

        function getSlideConfig() {
            const w = window.innerWidth;
            if (w < 480) return { slideWidth: 200, gap: 10, visible: 1.2 };
            if (w < 640) return { slideWidth: 220, gap: 12, visible: 1.3 };
            if (w < 1024) return { slideWidth: 240, gap: 16, visible: 2 };
            return { slideWidth: 270, gap: 16, visible: 3 };
        }

        function renderCarousel(cat) {
            const track = document.getElementById('carouselTrack');
            if (!track || !categoryData[cat]) return;
            const items = categoryData[cat];
            const cfg = getSlideConfig();
            track.innerHTML = items.map(item => `
                <div class="flex-shrink-0 bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 hover:shadow-lg transition-all cursor-pointer group" style="width: ${cfg.slideWidth}px;">
                    <div class="relative overflow-hidden">
                        <img src="${item.img}" class="w-full h-28 md:h-44 object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    </div>
                    <div class="p-3 md:p-4">
                        <h4 class="font-semibold text-xs md:text-sm text-primary-900 line-clamp-2">${item.title}</h4>
                        <p class="text-[10px] md:text-xs text-gray-500 mt-1 line-clamp-1">${item.desc}</p>
                    </div>
                </div>
            `).join('');
            currentSlide = 0;
            updateCarouselPosition();
        }

        function updateCarouselPosition() {
            const track = document.getElementById('carouselTrack');
            if (!track) return;
            const cfg = getSlideConfig();
            track.style.transform = `translateX(${-currentSlide * (cfg.slideWidth + cfg.gap)}px)`;
        }

        function moveCarousel(dir) {
            const items = categoryData[currentCategory];
            const cfg = getSlideConfig();
            const max = Math.max(0, items.length - Math.floor(cfg.visible));
            if (dir === 1 && currentSlide < max) currentSlide++;
            else if (dir === -1 && currentSlide > 0) currentSlide--;
            updateCarouselPosition();
        }

        function switchCategory(cat) {
            currentCategory = cat;
            document.querySelectorAll('.category-btn').forEach(b => {
                b.classList.remove('bg-gold-500', 'text-primary-900', 'shadow-lg', 'shadow-gold-500/20', 'font-bold');
                b.classList.add('bg-gray-100', 'text-gray-600', 'font-semibold');
            });
            const ab = document.querySelector(`[onclick="switchCategory('${cat}')"]`);
            if (ab) {
                ab.classList.remove('bg-gray-100', 'text-gray-600', 'font-semibold');
                ab.classList.add('bg-gold-500', 'text-primary-900', 'shadow-lg', 'shadow-gold-500/20', 'font-bold');
            }
            renderCarousel(cat);
        }

        window.addEventListener('resize', () => {
            clearTimeout(window._rt);
            window._rt = setTimeout(() => renderCarousel(currentCategory), 200);
        });

        renderCarousel('sport');

        // Touch swipe
        let touchStartX = 0;
        const carouselTrack = document.getElementById('carouselTrack');
        if (carouselTrack) {
            carouselTrack.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0].screenX; }, {passive: true});
            carouselTrack.addEventListener('touchend', e => {
                const diff = touchStartX - e.changedTouches[0].screenX;
                if (Math.abs(diff) > 40) moveCarousel(diff > 0 ? 1 : -1);
            }, {passive: true});
        }

        // ===== LIKE BUTTON =====
        function toggleLike(btn) {
            const icon = btn.querySelector('svg');
            const span = btn.querySelector('span');
            btn.classList.toggle('text-red-500');
            btn.classList.toggle('text-gray-500');
            if (btn.classList.contains('text-red-500')) {
                icon.setAttribute('fill', '#ef4444');
                icon.setAttribute('stroke', '#ef4444');
                btn.classList.add('liked');
                if (span) {
                    const val = span.textContent.replace(/,/g, '');
                    const num = parseInt(val);
                    if (!isNaN(num)) span.textContent = (num + 1).toLocaleString();
                }
            } else {
                icon.setAttribute('fill', 'none');
                icon.setAttribute('stroke', 'currentColor');
                btn.classList.remove('liked');
            }
            setTimeout(() => btn.classList.remove('liked'), 500);
        }

        // ===== MOBILE MENU =====
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('mobile-menu-icon');
            menu.classList.toggle('hidden');
            icon.setAttribute('data-lucide', menu.classList.contains('hidden') ? 'menu' : 'x');
            renderIcons();
        }

        // ===== SEARCH =====
        function toggleSearch() {
            const bar = document.getElementById('search-bar');
            bar.classList.toggle('hidden');
            if (!bar.classList.contains('hidden')) bar.querySelector('input').focus();
        }

        // ===== SMOOTH SCROLL =====
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', function(e) {
                e.preventDefault();
                const t = document.querySelector(this.getAttribute('href'));
                if (t) {
                    t.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    document.getElementById('mobile-menu')?.classList.add('hidden');
                }
            });
        });

        // ===== HEADER SCROLL =====
        window.addEventListener('scroll', () => {
            const h = document.getElementById('header');
            if (window.scrollY > 50) {
                h.style.background = 'rgba(10, 28, 23, 0.85)';
                h.style.backdropFilter = 'blur(25px)';
            } else {
                h.style.background = '';
                h.style.backdropFilter = '';
            }
        });
    </script>
</body>
</html>
