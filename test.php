<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Congo Explorer Hub - The Other Face of Congo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'congo-dark': '#1a2e2a',
                        'congo-green': '#2d5a4c',
                        'congo-gold': '#d4a843',
                        'congo-gold-light': '#f0c96e',
                        'congo-navy': '#1e3a5f',
                        'congo-cream': '#f5f0e8',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                        'serif': ['Playfair Display', 'serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'slide-up': 'slideUp 0.3s ease-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-20px)'
                            },
                        },
                        fadeInUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(30px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        },
                        slideUp: {
                            '0%': {
                                transform: 'translateY(100%)',
                                opacity: '0'
                            },
                            '100%': {
                                transform: 'translateY(0)',
                                opacity: '1'
                            },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #1a2e2a 0%, #2d5a4c 50%, #1e3a5f 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .text-gradient {
            background: linear-gradient(135deg, #d4a843 0%, #f0c96e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .scroll-reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }

        .scroll-reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px -12px rgba(212, 168, 67, 0.25);
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .like-anim {
            animation: likePop 0.4s ease-out;
        }

        @keyframes likePop {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1);
            }
        }

        .nav-active {
            position: relative;
        }

        .nav-active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            background: #d4a843;
            border-radius: 50%;
        }

        .carousel-slide {
            transition: transform 0.5s ease;
        }
    </style>
</head>

<body class="bg-congo-cream text-gray-800 font-sans overflow-x-hidden">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-congo-dark/95 backdrop-blur-lg shadow-lg" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center overflow-hidden border-2 border-congo-gold/50">
                        <img src="img/hub2.png" alt="Congo Explorer Hub" class="w-8 h-8 object-contain">
                    </div>
                    <div class="hidden md:block">
                        <span class="text-white font-bold text-lg tracking-tight">Congo Explorer<span
                                class="text-congo-gold">Hub</span></span>
                    </div>
                </div>

                <div class="hidden md:flex flex-1 max-w-md mx-8">
                    <div class="relative w-full">
                        <i data-lucide="search"
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input type="text" placeholder="Rechercher des publications, événements..."
                            class="w-full pl-10 pr-4 py-2 bg-white/10 border border-white/20 rounded-full text-sm text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-congo-gold/50 transition-all">
                    </div>
                </div>

                <div class="flex items-center space-x-1 md:space-x-4">
                    <button class="p-2 nav-active text-white" onclick="switchTab('feed')">
                        <i data-lucide="home" class="w-6 h-6"></i>
                    </button>
                    <button class="p-2 text-white/60 hover:text-white transition-colors" onclick="switchTab('explore')">
                        <i data-lucide="compass" class="w-6 h-6"></i>
                    </button>
                    <button class="p-2 text-white/60 hover:text-white transition-colors relative"
                        onclick="switchTab('messages')">
                        <i data-lucide="send" class="w-6 h-6"></i>
                    </button>
                    <button class="p-2 text-white/60 hover:text-white transition-colors relative"
                        onclick="switchTab('notifications')">
                        <i data-lucide="heart" class="w-6 h-6"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>

                    <div class="relative ml-2">
                        <button onclick="toggleProfileMenu()"
                            class="w-8 h-8 rounded-full overflow-hidden border-2 border-congo-gold">
                            <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&h=100&fit=crop&crop=face"
                                alt="Profile" class="w-full h-full object-cover">
                        </button>
                        <div id="profile-menu"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                            <a href="#about" class="block px-4 py-2 text-sm hover:bg-gray-50 flex items-center gap-2">
                                <i data-lucide="info" class="w-4 h-4"></i> Qui sommes-nous
                            </a>
                            <a href="#services"
                                class="block px-4 py-2 text-sm hover:bg-gray-50 flex items-center gap-2">
                                <i data-lucide="briefcase" class="w-4 h-4"></i> Nos expertises
                            </a>
                            <a href="#ambition"
                                class="block px-4 py-2 text-sm hover:bg-gray-50 flex items-center gap-2">
                                <i data-lucide="target" class="w-4 h-4"></i> Notre ambition
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="#contact"
                                class="block px-4 py-2 text-sm hover:bg-gray-50 flex items-center gap-2 text-congo-gold font-semibold">
                                <i data-lucide="mail" class="w-4 h-4"></i> Nous contacter
                            </a>
                        </div>
                    </div>
                </div>

                <button class="md:hidden text-white" onclick="toggleMobileMenu()">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-congo-dark/95 backdrop-blur-lg border-t border-white/10">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="#about" class="block px-3 py-2 text-white/80 hover:text-congo-gold">Qui sommes-nous</a>
                <a href="#services" class="block px-3 py-2 text-white/80 hover:text-congo-gold">Expertises</a>
                <a href="#ambition" class="block px-3 py-2 text-white/80 hover:text-congo-gold">Ambition</a>
                <a href="#contact" class="block px-3 py-2 text-congo-gold font-semibold">Nous contacter</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen hero-gradient flex items-center justify-center overflow-hidden pt-16">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-20 left-10 w-72 h-72 bg-congo-gold/20 rounded-full blur-3xl animate-pulse-slow">
            </div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-congo-green/30 rounded-full blur-3xl animate-pulse-slow"
                style="animation-delay: 2s;"></div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] border border-white/5 rounded-full">
            </div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] border border-white/5 rounded-full">
            </div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in-up">
                <h1 class="font-serif text-5xl md:text-7xl lg:text-8xl font-bold text-white mb-6 leading-tight">
                    L'autre face<br>
                    <span class="text-gradient">du Congo</span>
                </h1>

                <p class="text-xl md:text-2xl text-white/70 max-w-3xl mx-auto mb-12 font-light leading-relaxed">
                    Nous révélons l'autre facette de chez nous. Les acteurs, les talents et les événements qui façonnent
                    positivement la culture et l'écosystème congolais.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="#feed"
                        class="px-8 py-4 bg-congo-gold text-congo-dark font-bold rounded-full hover:bg-congo-gold-light transition-all transform hover:scale-105 shadow-lg shadow-congo-gold/25 flex items-center gap-2">
                        Explorer le fil
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </a>
                    <a href="#about"
                        class="px-8 py-4 border-2 border-white/30 text-white font-semibold rounded-full hover:bg-white/10 transition-all flex items-center gap-2">
                        En savoir plus
                    </a>
                </div>
            </div>

            <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
                <div class="glass-card rounded-2xl p-6 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="text-3xl font-bold text-congo-gold mb-1">3+</div>
                    <div class="text-white/60 text-sm">Mois d'existence</div>
                </div>
                <div class="glass-card rounded-2xl p-6 animate-fade-in-up" style="animation-delay: 0.4s;">
                    <div class="text-3xl font-bold text-congo-gold mb-1">360°</div>
                    <div class="text-white/60 text-sm">Stratégies Marketing</div>
                </div>
                <div class="glass-card rounded-2xl p-6 animate-fade-in-up" style="animation-delay: 0.6s;">
                    <div class="text-3xl font-bold text-congo-gold mb-1">100%</div>
                    <div class="text-white/60 text-sm">Engagement</div>
                </div>
                <div class="glass-card rounded-2xl p-6 animate-fade-in-up" style="animation-delay: 0.8s;">
                    <div class="text-3xl font-bold text-congo-gold mb-1">∞</div>
                    <div class="text-white/60 text-sm">Créativité</div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <i data-lucide="chevron-down" class="w-6 h-6 text-white/50"></i>
        </div>
    </section>

    <!-- Publications & Tendances Section -->
    <section id="feed" class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex gap-8">

                <!-- Main Feed -->
                <main class="flex-1">
                    <div class="space-y-6">

                        <!-- Post 1: Photo -->
                        <article class="bg-white border border-gray-200 rounded-xl overflow-hidden scroll-reveal">
                            <div class="flex items-center justify-between p-4">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-10 h-10 rounded-full overflow-hidden border-2 border-congo-gold p-0.5">
                                        <img src="https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?w=100&h=100&fit=crop&crop=face"
                                            class="w-full h-full rounded-full object-cover">
                                    </div>
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <span class="font-semibold text-sm hover:underline cursor-pointer">Marie
                                                Lumumba</span>
                                            <i data-lucide="badge-check"
                                                class="w-4 h-4 text-congo-gold fill-congo-gold"></i>
                                        </div>
                                        <div class="text-xs text-gray-500">Kinshasa, RDC • Il y a 2h</div>
                                    </div>
                                </div>
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                                </button>
                            </div>

                            <div class="relative">
                                <img src="https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?w=800&h=600&fit=crop"
                                    class="w-full aspect-[4/3] object-cover">
                                <div
                                    class="absolute top-4 right-4 bg-black/50 backdrop-blur text-white text-xs px-3 py-1 rounded-full">
                                    <i data-lucide="map-pin" class="w-3 h-3 inline mr-1"></i> Kinshasa
                                </div>
                            </div>

                            <div class="p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-4">
                                        <button onclick="toggleLike(this)"
                                            class="text-gray-600 hover:text-red-500 transition-colors group">
                                            <i data-lucide="heart"
                                                class="w-7 h-7 group-hover:scale-110 transition-transform"></i>
                                        </button>
                                        <button class="text-gray-600 hover:text-congo-dark transition-colors">
                                            <i data-lucide="message-circle" class="w-7 h-7"></i>
                                        </button>
                                        <button class="text-gray-600 hover:text-congo-dark transition-colors">
                                            <i data-lucide="send" class="w-7 h-7"></i>
                                        </button>
                                    </div>
                                    <button class="text-gray-600 hover:text-congo-dark transition-colors">
                                        <i data-lucide="bookmark" class="w-7 h-7"></i>
                                    </button>
                                </div>

                                <div class="font-semibold text-sm mb-2">1,234 J'aime</div>

                                <div class="mb-2">
                                    <span class="font-semibold text-sm mr-1">Marie Lumumba</span>
                                    <span class="text-sm text-gray-700">
                                        La beauté de notre capitale ! 🌆✨ Kinshasa by night, un spectacle unique au
                                        monde.
                                        <span
                                            class="text-congo-gold cursor-pointer hover:underline">#CongoExplorer</span>
                                        <span class="text-congo-gold cursor-pointer hover:underline">#Kinshasa</span>
                                        <span class="text-congo-gold cursor-pointer hover:underline">#RDC</span>
                                    </span>
                                </div>

                                <div class="text-gray-500 text-sm mb-2 cursor-pointer hover:text-gray-700">
                                    Voir les 89 commentaires
                                </div>
                                <div class="text-xs text-gray-400 uppercase tracking-wide mb-3">
                                    Il y a 2 heures
                                </div>

                                <div class="flex items-center space-x-3 pt-3 border-t border-gray-100">
                                    <i data-lucide="smile" class="w-5 h-5 text-gray-400"></i>
                                    <input type="text" placeholder="Ajouter un commentaire..."
                                        class="flex-1 text-sm focus:outline-none">
                                    <button
                                        class="text-congo-gold font-semibold text-sm hover:text-congo-gold-light">Publier</button>
                                </div>
                            </div>
                        </article>

                        <!-- Post 2: Video -->
                        <article class="bg-white border border-gray-200 rounded-xl overflow-hidden scroll-reveal">
                            <div class="flex items-center justify-between p-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-300 p-0.5">
                                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop&crop=face"
                                            class="w-full h-full rounded-full object-cover">
                                    </div>
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <span class="font-semibold text-sm hover:underline cursor-pointer">David
                                                Kanda</span>
                                            <span
                                                class="text-xs bg-congo-gold/20 text-congo-dark px-2 py-0.5 rounded-full">Photographe</span>
                                        </div>
                                        <div class="text-xs text-gray-500">Lubumbashi • Il y a 4h</div>
                                    </div>
                                </div>
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                                </button>
                            </div>

                            <div class="relative bg-black">
                                <img src="https://images.unsplash.com/photo-1489392191049-fc10c97e64b6?w=800&h=500&fit=crop"
                                    class="w-full aspect-video object-cover">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <button
                                        class="w-16 h-16 bg-white/20 backdrop-blur rounded-full flex items-center justify-center hover:bg-white/30 transition-all group">
                                        <i data-lucide="play" class="w-8 h-8 text-white fill-white ml-1"></i>
                                    </button>
                                </div>
                                <div class="absolute bottom-4 right-4 bg-black/60 text-white text-xs px-2 py-1 rounded">
                                    2:34
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gray-700">
                                    <div class="h-full bg-congo-gold w-1/3"></div>
                                </div>
                            </div>

                            <div class="p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-4">
                                        <button onclick="toggleLike(this)"
                                            class="text-gray-600 hover:text-red-500 transition-colors group">
                                            <i data-lucide="heart"
                                                class="w-7 h-7 group-hover:scale-110 transition-transform"></i>
                                        </button>
                                        <button class="text-gray-600 hover:text-congo-dark transition-colors">
                                            <i data-lucide="message-circle" class="w-7 h-7"></i>
                                        </button>
                                        <button class="text-gray-600 hover:text-congo-dark transition-colors">
                                            <i data-lucide="send" class="w-7 h-7"></i>
                                        </button>
                                    </div>
                                    <button class="text-gray-600 hover:text-congo-dark transition-colors">
                                        <i data-lucide="bookmark" class="w-7 h-7"></i>
                                    </button>
                                </div>
                                <div class="font-semibold text-sm mb-2">856 J'aime</div>
                                <div class="mb-2">
                                    <span class="font-semibold text-sm mr-1">David Kanda</span>
                                    <span class="text-sm text-gray-700">
                                        Interview exclusive avec les artisans de Lubumbashi ! 🎥 Le savoir-faire
                                        congolais mérite d'être célébré.
                                        <span class="text-congo-gold cursor-pointer hover:underline">#Artisanat</span>
                                        <span class="text-congo-gold cursor-pointer hover:underline">#Congo</span>
                                    </span>
                                </div>
                                <div class="text-gray-500 text-sm mb-2 cursor-pointer hover:text-gray-700">
                                    Voir les 45 commentaires
                                </div>
                                <div class="text-xs text-gray-400 uppercase tracking-wide mb-3">
                                    Il y a 4 heures
                                </div>
                                <div class="flex items-center space-x-3 pt-3 border-t border-gray-100">
                                    <i data-lucide="smile" class="w-5 h-5 text-gray-400"></i>
                                    <input type="text" placeholder="Ajouter un commentaire..."
                                        class="flex-1 text-sm focus:outline-none">
                                    <button
                                        class="text-congo-gold font-semibold text-sm hover:text-congo-gold-light">Publier</button>
                                </div>
                            </div>
                        </article>

                        <!-- Post 3: Carousel -->
                        <article class="bg-white border border-gray-200 rounded-xl overflow-hidden scroll-reveal">
                            <div class="flex items-center justify-between p-4">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-10 h-10 rounded-full overflow-hidden border-2 border-congo-gold p-0.5">
                                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop&crop=face"
                                            class="w-full h-full rounded-full object-cover">
                                    </div>
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <span class="font-semibold text-sm hover:underline cursor-pointer">Amina
                                                Tshibola</span>
                                            <i data-lucide="badge-check"
                                                class="w-4 h-4 text-congo-gold fill-congo-gold"></i>
                                        </div>
                                        <div class="text-xs text-gray-500">Goma, RDC • Il y a 6h</div>
                                    </div>
                                </div>
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                                </button>
                            </div>

                            <div class="relative">
                                <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=800&h=600&fit=crop"
                                    class="w-full aspect-[4/3] object-cover">
                                <div
                                    class="absolute top-4 right-4 bg-black/50 text-white text-xs px-2 py-1 rounded-full">
                                    1 / 3
                                </div>
                                <button
                                    class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 bg-white/80 rounded-full flex items-center justify-center hover:bg-white transition-colors">
                                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                                </button>
                                <button
                                    class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 bg-white/80 rounded-full flex items-center justify-center hover:bg-white transition-colors">
                                    <i data-lucide="chevron-right" class="w-5 h-5"></i>
                                </button>
                                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-1">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                    <div class="w-2 h-2 bg-white/50 rounded-full"></div>
                                    <div class="w-2 h-2 bg-white/50 rounded-full"></div>
                                </div>
                            </div>

                            <div class="p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-4">
                                        <button onclick="toggleLike(this)"
                                            class="text-gray-600 hover:text-red-500 transition-colors group">
                                            <i data-lucide="heart"
                                                class="w-7 h-7 group-hover:scale-110 transition-transform"></i>
                                        </button>
                                        <button class="text-gray-600 hover:text-congo-dark transition-colors">
                                            <i data-lucide="message-circle" class="w-7 h-7"></i>
                                        </button>
                                        <button class="text-gray-600 hover:text-congo-dark transition-colors">
                                            <i data-lucide="send" class="w-7 h-7"></i>
                                        </button>
                                    </div>
                                    <button class="text-gray-600 hover:text-congo-dark transition-colors">
                                        <i data-lucide="bookmark" class="w-7 h-7"></i>
                                    </button>
                                </div>
                                <div class="font-semibold text-sm mb-2">2,567 J'aime</div>
                                <div class="mb-2">
                                    <span class="font-semibold text-sm mr-1">Amina Tshibola</span>
                                    <span class="text-sm text-gray-700">
                                        Le lac Kivu, un trésor naturel de notre pays ! 🌊💙 La RDC regorge de merveilles
                                        à découvrir.
                                        <span class="text-congo-gold cursor-pointer hover:underline">#Goma</span>
                                        <span class="text-congo-gold cursor-pointer hover:underline">#LacKivu</span>
                                        <span class="text-congo-gold cursor-pointer hover:underline">#TourismeRDC</span>
                                    </span>
                                </div>
                                <div class="text-gray-500 text-sm mb-2 cursor-pointer hover:text-gray-700">
                                    Voir les 234 commentaires
                                </div>
                                <div class="text-xs text-gray-400 uppercase tracking-wide mb-3">
                                    Il y a 6 heures
                                </div>
                                <div class="flex items-center space-x-3 pt-3 border-t border-gray-100">
                                    <i data-lucide="smile" class="w-5 h-5 text-gray-400"></i>
                                    <input type="text" placeholder="Ajouter un commentaire..."
                                        class="flex-1 text-sm focus:outline-none">
                                    <button
                                        class="text-congo-gold font-semibold text-sm hover:text-congo-gold-light">Publier</button>
                                </div>
                            </div>
                        </article>

                        <!-- CATEGORY CAROUSEL SECTION -->
                        <div class="bg-white rounded-xl border border-gray-200 p-6 mt-8 scroll-reveal">
                            <h3 class="text-xl font-bold text-congo-dark mb-6 flex items-center gap-2">
                                <i data-lucide="layers" class="w-6 h-6 text-congo-gold"></i>
                                Explorer par catégorie
                            </h3>

                            <!-- Category Tabs -->
                            <div class="flex flex-wrap gap-2 mb-6">
                                <button onclick="switchCategory('sport')"
                                    class="category-btn px-4 py-2 rounded-full text-sm font-semibold bg-congo-gold text-congo-dark">Sport</button>
                                <button onclick="switchCategory('sante')"
                                    class="category-btn px-4 py-2 rounded-full text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200">Santé</button>
                                <button onclick="switchCategory('science')"
                                    class="category-btn px-4 py-2 rounded-full text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200">Science</button>
                                <button onclick="switchCategory('autres')"
                                    class="category-btn px-4 py-2 rounded-full text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200">Autres</button>
                            </div>

                            <!-- Carousel Container -->
                            <div class="relative">
                                <div class="overflow-hidden">
                                    <div id="carouselTrack" class="flex transition-transform duration-500 ease-out">
                                        <!-- Slides will be populated by JS -->
                                    </div>
                                </div>

                                <!-- Carousel Controls -->
                                <button onclick="moveCarousel(-1)"
                                    class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 w-10 h-10 bg-white shadow-lg rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors z-10">
                                    <i data-lucide="chevron-left" class="w-5 h-5 text-congo-dark"></i>
                                </button>
                                <button onclick="moveCarousel(1)"
                                    class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 w-10 h-10 bg-white shadow-lg rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors z-10">
                                    <i data-lucide="chevron-right" class="w-5 h-5 text-congo-dark"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Loading More -->
                        <div class="flex items-center justify-center py-8">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-congo-gold"></div>
                        </div>
                    </div>
                </main>

                <!-- Right Sidebar -->
                <aside class="hidden lg:block w-80 flex-shrink-0">
                    <div class="sticky top-20 space-y-4">
                        <div class="bg-white rounded-xl border border-gray-200 p-4">
                            <div class="flex items-center space-x-3 mb-3">
                                <img src="img/hub2.png" class="w-12 h-12 object-contain">
                                <div>
                                    <div class="font-bold text-congo-dark text-sm">Congo Explorer<span
                                            class="text-congo-gold">Hub</span></div>
                                    <div class="text-xs text-gray-500">The Other Face of Congo</div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed mb-3">
                                Média engagé pour révéler les talents et événements qui façonnent positivement
                                l'écosystème congolais.
                            </p>
                            <a href="#about" class="text-congo-gold text-xs font-semibold hover:underline">En savoir
                                plus →</a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- Footer (simplifié pour l'exemple) -->
    <footer class="bg-congo-dark border-t border-white/10 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="img/hub2.png" alt="Congo Explorer Hub" class="w-10 h-10 object-contain">
                        <span class="text-white font-bold text-xl">Congo Explorer<span class="text-congo-gold">Hub</span></span>
                    </div>
                    <p class="text-white/50 max-w-sm">
                        L'autre face du Congo. Révéler les talents, les acteurs et les événements qui façonnent positivement l'écosystème congolais.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Navigation</h4>
                    <ul class="space-y-2">
                        <li><a href="#about" class="text-white/50 hover:text-congo-gold transition-colors">Qui sommes-nous</a></li>
                        <li><a href="#services" class="text-white/50 hover:text-congo-gold transition-colors">Expertises</a></li>
                        <li><a href="#ambition" class="text-white/50 hover:text-congo-gold transition-colors">Ambition</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2">
                        <li class="text-white/50 flex items-center gap-2">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                            contact@congoexplorerhub.com
                        </li>
                        <li class="text-white/50 flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                            Congo
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-white/30 text-sm">© 2026 Congo Explorer Hub. Tous droits réservés.</p>
                <p class="text-white/30 text-sm mt-2 md:mt-0">Fait avec ❤️ au Congo</p>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();

        // Category data
        const categoryData = {
            sport: [{
                    title: "Les Léopards en préparation",
                    img: "https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=400&h=300&fit=crop",
                    desc: "Stage intensif avant la CAN"
                },
                {
                    title: "Marathon de Kinshasa",
                    img: "https://images.unsplash.com/photo-1552674605-db6ffd4facb5?w=400&h=300&fit=crop",
                    desc: "Plus de 5000 participants"
                },
                {
                    title: "Basket : Finale du championnat",
                    img: "https://images.unsplash.com/photo-1546519638-68e109498ffc?w=400&h=300&fit=crop",
                    desc: "Un match historique"
                }
            ],
            sante: [{
                    title: "Campagne de vaccination",
                    img: "https://images.unsplash.com/photo-1584483766114-2cea6facdf57?w=400&h=300&fit=crop",
                    desc: "Protégeons nos enfants"
                },
                {
                    title: "Nutrition au Congo",
                    img: "https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=400&h=300&fit=crop",
                    desc: "Manger sain, vivre mieux"
                }
            ],
            science: [{
                    title: "Innovation Lab à Lubumbashi",
                    img: "https://images.unsplash.com/photo-1507413245164-6160d8298b31?w=400&h=300&fit=crop",
                    desc: "Les jeunes talents tech"
                },
                {
                    title: "Énergies renouvelables",
                    img: "https://images.unsplash.com/photo-1509391366360-2e959784a276?w=400&h=300&fit=crop",
                    desc: "Le solaire au Congo"
                }
            ],
            autres: [{
                    title: "Culture & Traditions",
                    img: "https://images.unsplash.com/photo-1533106497176-45ae19e68ba2?w=400&h=300&fit=crop",
                    desc: "Festival des arts"
                },
                {
                    title: "Mode congolaise",
                    img: "https://images.unsplash.com/photo-1485968579580-b6d095142e6e?w=400&h=300&fit=crop",
                    desc: "Les créateurs émergents"
                }
            ]
        };

        let currentCategory = 'sport';
        let currentSlide = 0;

        function renderCarousel(category) {
            const track = document.getElementById('carouselTrack');
            const items = categoryData[category];

            track.innerHTML = items.map(item => `
                <div class="w-72 flex-shrink-0 mr-4 bg-gray-50 rounded-xl overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow cursor-pointer">
                    <img src="${item.img}" class="w-full h-40 object-cover">
                    <div class="p-3">
                        <h4 class="font-semibold text-sm text-congo-dark">${item.title}</h4>
                        <p class="text-xs text-gray-500 mt-1">${item.desc}</p>
                    </div>
                </div>
            `).join('');

            currentSlide = 0;
            updateCarouselPosition();
        }

        function updateCarouselPosition() {
            const track = document.getElementById('carouselTrack');
            const offset = -currentSlide * 304; // 288px + 16px gap
            track.style.transform = `translateX(${offset}px)`;
        }

        function moveCarousel(direction) {
            const items = categoryData[currentCategory];
            const maxSlides = Math.max(0, items.length - 3);

            if (direction === 1 && currentSlide < maxSlides) {
                currentSlide++;
            } else if (direction === -1 && currentSlide > 0) {
                currentSlide--;
            }
            updateCarouselPosition();
        }

        function switchCategory(category) {
            currentCategory = category;
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('bg-congo-gold', 'text-congo-dark');
                btn.classList.add('bg-gray-100', 'text-gray-600');
            });
            const activeBtn = document.querySelector(`[onclick="switchCategory('${category}')"]`);
            if (activeBtn) {
                activeBtn.classList.remove('bg-gray-100', 'text-gray-600');
                activeBtn.classList.add('bg-congo-gold', 'text-congo-dark');
            }
            renderCarousel(category);
        }

        // Initialize carousel
        renderCarousel('sport');

        function toggleProfileMenu() {
            const menu = document.getElementById('profile-menu');
            menu.classList.toggle('hidden');
        }

        document.addEventListener('click', (e) => {
            const menu = document.getElementById('profile-menu');
            if (!e.target.closest('#profile-menu') && !e.target.closest('button[onclick="toggleProfileMenu()"]')) {
                menu.classList.add('hidden');
            }
        });

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        function toggleLike(button) {
            const icon = button.querySelector('svg');
            if (button.classList.contains('text-red-500')) {
                button.classList.remove('text-red-500');
                button.classList.add('text-gray-600');
                icon.setAttribute('fill', 'none');
            } else {
                button.classList.remove('text-gray-600');
                button.classList.add('text-red-500');
                icon.setAttribute('fill', 'currentColor');
                button.classList.add('like-anim');
                setTimeout(() => button.classList.remove('like-anim'), 400);
            }
        }

        function switchTab(tab) {
            document.querySelectorAll('.nav-active').forEach(el => {
                el.classList.remove('nav-active');
            });
            event.currentTarget.classList.add('nav-active');
        }

        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.scroll-reveal').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>

</html>