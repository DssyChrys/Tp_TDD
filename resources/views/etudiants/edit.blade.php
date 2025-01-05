@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier un Étudiant</h1>

     
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

     
    <form action="{{ route('etudiants.update', $etudiant->id) }}" method="POST">
        @csrf
        @method('PUT')

         
        <div class="form-group">
            <label for="numero_etudiant">Numéro étudiant :</label>
            <input type="text" name="numero_etudiant" id="numero_etudiant" value="{{ old('numero_etudiant', $etudiant->numero_etudiant) }}" class="form-control" required>
            @error('numero_etudiant')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom', $etudiant->nom) }}" class="form-control" required>
            @error('nom')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

         
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $etudiant->prenom) }}" class="form-control" required>
            @error('prenom')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

         
        <div class="form-group">
            <label for="niveau">Niveau :</label>
            <select name="niveau" id="niveau" class="form-control" required>
                <option value="L1" {{ old('niveau', $etudiant->niveau) == 'L1' ? 'selected' : '' }}>L1</option>
                <option value="L2" {{ old('niveau', $etudiant->niveau) == 'L2' ? 'selected' : '' }}>L2</option>
                <option value="L3" {{ old('niveau', $etudiant->niveau) == 'L3' ? 'selected' : '' }}>L3</option>
            </select>
            @error('niveau')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        
        <button type="submit" class="btn btn-primary mt-3">Mettre à jour</button>
    </form>
</div>
@endsection
