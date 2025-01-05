@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la Note</h1>
    
    <form action="{{ route('notes.update', $note->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="etudiant_id">Étudiant :</label>
            <select name="etudiant_id" id="etudiant_id" required>
                @foreach($etudiants as $etudiant)
                    <option value="{{ $etudiant->id }}" {{ $etudiant->id == $note->etudiant_id ? 'selected' : '' }}>
                        {{ $etudiant->nom }} {{ $etudiant->prenom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="ec_id">Élément Constitutif (EC) :</label>
            <select name="ec_id" id="ec_id" required>
                @foreach($ecs as $ec)
                    <option value="{{ $ec->id }}" {{ $ec->id == $note->ec_id ? 'selected' : '' }}>
                        {{ $ec->code }} - {{ $ec->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="note">Note :</label>
            <input type="number" name="note" id="note" min="0" max="20" step="0.25" value="{{ $note->note }}" required>
        </div>

        <div>
            <label for="session">Session :</label>
            <select name="session" id="session" required>
                <option value="normale" {{ $note->session == 'normale' ? 'selected' : '' }}>Session Normale</option>
                <option value="rattrapage" {{ $note->session == 'rattrapage' ? 'selected' : '' }}>Session de Rattrapage</option>
            </select>
        </div>

        <div>
            <button type="submit">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection
