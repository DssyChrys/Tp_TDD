<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<nav class="bg-gray-700 shadow">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo Universitaire -->
            <div class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Universitaire" class="h-10 w-10" href="/dashboard">
                <span class="text-white font-bold text-lg ml-2">Bilan de performance</span>
            </div>

            <!-- Menu pour grand écran -->
            <div class="hidden md:flex space-x-6">
                <a href="{{ route('etudiants.index') }}" class="text-gray-300 hover:text-white">Liste des Étudiants</a>
                <a href="{{ route('notes.index') }}" class="text-gray-300 hover:text-white">Liste des Notes</a>
                <a href="" class="text-gray-300 hover:text-white">Nos Meilleurs Profils</a>
                <a href="" class="text-gray-300 hover:text-white">À Propos</a>
            </div>

            <!-- Bouton pour mobile -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-300 hover:text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu mobile -->
    <div id="mobile-menu" class="hidden md:hidden bg-gray-600">
        <a href="{{ route('etudiants.index') }}" class="block text-gray-300 hover:text-white px-4 py-2">Liste des Étudiants</a>
        <a href="{{ route('notes.index') }}" class="block text-gray-300 hover:text-white px-4 py-2">Liste des Notes</a>
        <a href="" class="block text-gray-300 hover:text-white px-4 py-2">Nos Meilleurs Profils</a>
        <a href="" class="block text-gray-300 hover:text-white px-4 py-2">À Propos</a>
    </div>
</nav>

<!-- Espacement après la navbar -->
<div class="mt-6 transform translate-x-[-100%] hover:translate-x-0 transition-transform duration-700">
    <h1>Salut</h1>
</div>

<div class="min-h-screen w-full bg-gray-100">
    @yield('content')
</div>

<script>
    // Script pour gérer le menu mobile
    const menuButton = document.getElementById("mobile-menu-button");
    const mobileMenu = document.getElementById("mobile-menu");
    
    menuButton.addEventListener("click", function() {
        mobileMenu.classList.toggle("hidden");
    });
</script>

</body>
</html>
