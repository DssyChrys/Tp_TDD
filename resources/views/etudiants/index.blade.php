@extends('dashboard')

@section('content')
<div class="container mx-auto">

    <h1 class="text-2xl font-semibold text-gray-700 mb-6">Liste des étudiants</h1>

    <div class="flex justify-between mb-6">
        <a href="{{ route('etudiants.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Ajouter un étudiant
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Numéro</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Nom</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Prénom</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Niveau</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($etudiants as $etudiant)
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">{{ $etudiant->matricule }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $etudiant->nom }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $etudiant->prenom }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $etudiant->niveau }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <div class="flex gap-2">
                                <a href="{{ route('notes.moyenne', $etudiant->id) }}" class="bg-info text-white bg-blue-600 px-3 py-1 rounded hover:bg-blue-600">Voir Moyenne</a>
                                <a href="{{ route('etudiants.edit', $etudiant->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Modifier Étudiant</a>
                                <form action="{{ route('etudiants.destroy', $etudiant->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')">Supprimer Étudiant</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

   
</div>
@endsection
