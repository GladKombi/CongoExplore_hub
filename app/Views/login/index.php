<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Congo Explorer Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': {
                            50: '#f0f5f2',
                            100: '#d4e5db',
                            200: '#a8ccb7',
                            300: '#74ad8c',
                            400: '#4a8f6b',
                            500: '#2d5a4c',
                            600: '#234a3d',
                            700: '#1a3a30',
                            800: '#122b23',
                            900: '#0a1c17',
                        },
                        'gold': {
                            50: '#fef9f0',
                            100: '#fdf0d5',
                            200: '#fae0a8',
                            300: '#f5cb6e',
                            400: '#f0b940',
                            500: '#d4a843',
                            600: '#b88a2e',
                            700: '#8f6b23',
                            800: '#6b4f1a',
                            900: '#473311',
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

        * {
            scroll-behavior: smooth;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: #f9f7f3;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.96);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .animate-scale-in {
            animation: scaleIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-float {
            animation: float 8s ease-in-out infinite;
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-shift 8s ease infinite;
        }

        .animate-slide-right {
            animation: slideInRight 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .stagger-1 {
            animation-delay: 0.1s;
        }

        .stagger-2 {
            animation-delay: 0.2s;
        }

        .stagger-3 {
            animation-delay: 0.3s;
        }

        .text-gradient {
            background: linear-gradient(135deg, #d4a843 0%, #f0c96e 40%, #e5ad33 70%, #d4a843 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 200% 200%;
            animation: gradient-shift 4s ease infinite;
        }

        /* Input styles */
        .input-group:focus-within .input-icon {
            color: #d4a843;
        }

        .input-field {
            transition: all 0.3s ease;
        }

        .input-field:focus {
            border-color: rgba(212, 168, 67, 0.4);
            box-shadow: 0 0 0 3px rgba(212, 168, 67, 0.06);
        }

        /* Button ripple */
        .btn-ripple {
            position: relative;
            overflow: hidden;
        }

        .btn-ripple::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-ripple:active::after {
            width: 300px;
            height: 300px;
        }

        /* Glass effect */
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>

<body class="text-gray-800 font-sans overflow-x-hidden antialiased min-h-screen">

    <!-- ========== LOGIN PAGE ========== -->
    <div class="min-h-screen flex items-center justify-center relative overflow-hidden bg-[#f9f7f3]">

        <!-- Subtle background pattern -->
        <div class="absolute inset-0 opacity-[0.015]" style="background-image: radial-gradient(circle at 1px 1px, #1a2e2a 1px, transparent 0); background-size: 30px 30px;"></div>

        <!-- Decorative shapes -->
        <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-gold-100/60 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/3 opacity-70"></div>
        <div class="absolute bottom-0 left-0 w-[350px] h-[350px] bg-primary-100/60 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/3 opacity-60"></div>

        <!-- Main container -->
        <div class="relative z-10 w-full max-w-md mx-auto px-4">

            <!-- Card -->
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-primary-900/5 p-8 md:p-10 border border-gray-100 animate-scale-in">

                <!-- Logo -->
                <div class="flex items-center justify-center space-x-3 mb-8">
                    <div class="w-11 h-11 rounded-2xl bg-primary-900 flex items-center justify-center overflow-hidden shadow-lg shadow-primary-900/20">
                        <img src="img/hub2.png" alt="CEH" class="w-8 h-8 object-contain brightness-125">
                    </div>
                    <span class="text-primary-900 font-bold text-lg tracking-tight font-display">
                        Congo<span class="text-gradient">Explorer</span>Hub
                    </span>
                </div>

                <!-- Error message -->
                <?php if (!empty($error)): ?>
                    <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                <form action="<?php echo BASE_URL; ?>login" method="post" class="space-y-5">

                    <!-- Email -->
                    <div class="input-group stagger-2 animate-fade-in-up opacity-0">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Email</label>
                        <div class="relative">
                            <i data-lucide="mail" class="input-icon absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 transition-colors"></i>
                            <input type="email" name="email" placeholder="votre@email.com" required
                                class="input-field w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:bg-white transition-all">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="input-group stagger-3 animate-fade-in-up opacity-0">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Mot de passe</label>
                        <div class="relative">
                            <i data-lucide="lock" class="input-icon absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 transition-colors"></i>
                            <input type="password" name="password" placeholder="••••••••" required id="password-input"
                                class="input-field w-full pl-11 pr-12 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:bg-white transition-all">
                            <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 text-gray-400 hover:text-gray-600 transition-colors rounded-lg hover:bg-gray-100">
                                <i data-lucide="eye" class="w-4 h-4" id="password-icon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember & Forgot -->
                    <!-- <div class="flex items-center justify-between stagger-3 animate-fade-in-up opacity-0">
                        <label class="flex items-center gap-2.5 cursor-pointer group">
                            <input type="checkbox" class="w-4 h-4 rounded-md border-2 border-gray-300 text-gold-500 focus:ring-gold-500 focus:ring-offset-0 cursor-pointer transition-all">
                            <span class="text-xs text-gray-500 group-hover:text-gray-700 transition-colors">Se souvenir de moi</span>
                        </label>
                        <a href="#" class="text-xs font-semibold text-gold-600 hover:text-gold-700 transition-colors">
                            Mot de passe oublié ?
                        </a>
                    </div> -->

                    <!-- Submit Button -->
                    <button type="submit"
                        class="btn-ripple w-full py-3.5 bg-primary-900 text-white font-bold rounded-2xl hover:bg-primary-800 transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-primary-900/15 flex items-center justify-center gap-2 text-sm stagger-3 animate-fade-in-up opacity-0">
                        Se connecter
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>

            <!-- Footer links -->
            <div class="text-center mt-6 space-y-2">
                <a href="<?php echo BASE_URL; ?>home" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-gray-600 transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Retour au site
                </a>
            </div>
        </div>

        <!-- Toast notification -->
        <div id="toast" class="hidden fixed top-6 right-6 z-50 flex items-center gap-3 px-5 py-4 rounded-2xl shadow-2xl text-sm font-medium animate-slide-right bg-primary-900 text-white">
            <i data-lucide="check-circle" class="w-5 h-5 text-gold-400"></i>
            <span id="toast-message">Connexion réussie !</span>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // ===== TOGGLE PASSWORD =====
        function togglePassword() {
            const input = document.getElementById('password-input');
            const icon = document.getElementById('password-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }

        // ===== HANDLE LOGIN =====
        function handleLogin(e) {
            e.preventDefault();
            const email = e.target.querySelector('input[type="email"]').value;
            showToast('Connexion réussie ! Bienvenue sur Congo Explorer Hub.');

            // Simulation de redirection après connexion
            setTimeout(() => {
                window.location.href = 'index.html#feed';
            }, 1500);
        }

        // ===== SOCIAL LOGIN =====
        function handleSocialLogin(provider) {
            showToast(`Connexion avec ${provider} en cours...`);
        }

        // ===== TOAST =====
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');

            toastMessage.textContent = message;
            toast.classList.remove('hidden');

            // Re-trigger animation
            toast.classList.remove('animate-slide-right');
            void toast.offsetWidth;
            toast.classList.add('animate-slide-right');

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(50px)';
                toast.style.transition = 'all 0.4s ease';
                setTimeout(() => {
                    toast.classList.add('hidden');
                    toast.style.opacity = '1';
                    toast.style.transform = 'translateX(0)';
                }, 400);
            }, 3000);
        }

        // ===== INITIALIZE =====
        lucide.createIcons();
    </script>
</body>

</html>