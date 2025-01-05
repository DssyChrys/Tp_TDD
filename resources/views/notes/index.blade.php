@extends('dashboard')

@section('content')
<div class="container mx-auto">

    <h1 class="text-2xl font-semibold text-gray-700 mb-6">Liste des Notes</h1>

    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Numéro</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Nom</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Prénom</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Notes</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($etudiants as $etudiant)
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">{{ $etudiant->matricule }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $etudiant->nom }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $etudiant->prenom }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            @if ($etudiant->notes->isNotEmpty())
                                @foreach ($etudiant->notes as $note)
                                    <div class="flex items-center gap-4 mb-2">
                                        <span>{{ $note->note }}</span>
                                        <span class="badge bg-{{ $note->session == 'normale' ? 'green' : 'red' }}-500 text-white px-2 py-1 rounded-full text-xs">
                                            {{ $note->session == 'normale' ? 'Contrôle Continu' : 'Contrôle Terminal' }}
                                        </span>
                                        <div class="flex gap-2">
                                            <a href="{{ route('notes.edit', $note) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Modifier</a>
                                            <form action="{{ route('notes.destroy', $note) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?')">Supprimer</button>
                                            </form>
                                            <span class="badge bg-{{ $note->session == 'normale' ? 'green' : 'red' }}-500 text-white px-2 py-1 rounded-full">
                                                Session {{ ucfirst ($note->session) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>Aucune Note</p>
                            @endif
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            <div class="flex gap-2">
                                <a href="{{ route('notes.create', $etudiant) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Ajouter Note</a>
                                <a href="{{ route('notes.moyenne', $etudiant->id) }}" class="bg-info text-white bg-blue-600 px-3 py-1 rounded hover:bg-blue-700">Voir Moyenne</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
