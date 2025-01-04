<table class="table table-striped">
    <h1>Liste des étudiants</h1>
    
    
    <a href="{{ route('etudiants.create') }}" class="btn btn-primary mb-3">Ajouter un étudiant</a>

    <thead>
        <tr>
            <th>Numéro</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Niveau</th>
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
                <td>{{ $etudiant->niveau }}</td>
                <td>
                    @if ($etudiant->notes->isNotEmpty())
                        @foreach ($etudiant->notes as $note)
                            {{ $note->note }}<br>
                        @endforeach
                    @else
                        Aucune Note
                    @endif
                </td>
                <td>{{ $etudiant->notes->first()->session ?? 'N/A' }}</td>
                <td>
                     
                    @foreach ($etudiant->notes as $note)
                        <a href="{{ route('notes.edit', $note) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('notes.destroy', $note) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?')">Supprimer</button>
                        </form>
                    @endforeach
                    <a href="{{ route('notes.moyenne', $etudiant->id) }}" class="btn btn-info btn-sm">Voir Moyenne</a>
                    <a href="{{ route('etudiants.edit', $etudiant->id) }}" class="btn btn-warning btn-sm">Modifier Étudiant</a>       
                    <form action="{{ route('etudiants.destroy', $etudiant->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')">Supprimer Étudiant</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
