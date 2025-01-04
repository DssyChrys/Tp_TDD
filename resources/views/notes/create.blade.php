@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter une Note</h1>
    <form action="{{ route('notes.store') }}" method="POST">
        @csrf
        <div>
            <label for="etudiant_id">Étudiant :</label>
            <select name="etudiant_id" id="etudiant_id" required>
                @foreach($etudiants as $etudiant)
                    <option value="{{ $etudiant->id }}">{{ $etudiant->nom }} {{ $etudiant->prenom }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="ec_id">Élément Constitutif (EC) :</label>
            <select name="ec_id" id="ec_id">
                @foreach($ecs as $ec)
                    <option value="{{ $ec->id }}">{{ $ec->code }} - {{ $ec->nom }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="note">Note :</label>
            <input type="number" name="note" id="note" min="0" max="20" step="0.25" required>
        </div>
        <div>
            <label for="session">Session :</label>
            <select name="session" id="session" required>
                <option value="normale">Session Normale</option>
                <option value="rattrapage">Session de Rattrapage</option>
            </select>
        </div>
        <div>
            <button type="submit">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
