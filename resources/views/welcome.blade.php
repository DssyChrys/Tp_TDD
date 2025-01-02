<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue - Gestion des Résultats des Étudiants</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <section class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-500 to-indigo-600">
        <div class="text-center bg-white rounded-lg shadow-lg p-8 max-w-lg">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Bienvenue !</h1>
            <p class="text-lg text-gray-600 mb-6">
                Bienvenue dans l'application de gestion des résultats des étudiants.
                Cette plateforme vous permet de gérer facilement les unités d'enseignement,
                les étudiants et leurs résultats de manière efficace.
            </p>
            <a href="{{ route('index') }}" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">
                Commencer
            </a>
        </div>
    </section>
    <section>
    
    </section>
</body>
</html>
