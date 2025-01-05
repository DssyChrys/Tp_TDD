@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Notes</h1>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Notes</th>
                <th>Session</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($etudiants as $etudiant)
                <tr>
                    <td>{{ $etudiant->matricule }}</td>
                    <td>{{ $etudiant->nom }}</td>
                    <td>{{ $etudiant->prenom }}</td>
                    <td>
                        @if ($etudiant->notes->isNotEmpty())
                            @foreach ($etudiant->notes as $note)
                                <div>
                                    {{ $note->note }} 
                                    <span class="badge badge-info">{{ $note->session == 'normale' ? 'Contrôle Continu' : 'Contrôle Terminal' }}</span>
                                </div>
                            @endforeach
                        @else
                            Aucune Note
                        @endif
                    </td>
                    <td>
                        @foreach ($etudiant->notes as $note)
                            <span class="badge badge-{{ $note->session == 'normale' ? 'success' : 'danger' }}">
                                {{ ucfirst($note->session) }}
                            </span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('notes.create', $etudiant) }}" class="btn btn-primary mb-3">Ajouter Note</a>
                        @foreach ($etudiant->notes as $note)
                            <a href="{{ route('notes.edit', $note) }}" class="btn btn-warning">Modifier</a>
                        
                            <form action="{{ route('notes.destroy', $note) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?')">Supprimer</button>
                            </form>
                        @endforeach
                        <a href="{{ route('notes.moyenne', $etudiant->id) }}" class="btn btn-info">Voir Moyenne</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
