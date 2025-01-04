 

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ajouter un Étudiant</h1>

         
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

         
        <form action="{{ route('etudiants.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="matricule" class="form-label">Numéro étudiant :</label>
                <input type="text" name="matricule" id="matricule" class="form-control" value="{{ old('matricule') }}" required>
            </div>

            <div class="mb-3">
                <label for="nom" class="form-label">Nom :</label>
                <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom') }}" required>
            </div>

            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom :</label>
                <input type="text" name="prenom" id="prenom" class="form-control" value="{{ old('prenom') }}" required>
            </div>

            <div class="mb-3">
                <label for="niveau" class="form-label">Niveau :</label>
                <select name="niveau" id="niveau" class="form-control" required>
                    <option value="L1" {{ old('niveau') == 'L1' ? 'selected' : '' }}>L1</option>
                    <option value="L2" {{ old('niveau') == 'L2' ? 'selected' : '' }}>L2</option>
                    <option value="L3" {{ old('niveau') == 'L3' ? 'selected' : '' }}>L3</option>
                </select>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
    </div>
@endsection
