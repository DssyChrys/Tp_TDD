@extends('dashboard')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <form action="{{ route('etudiants.update', $etudiant->id) }}" method="POST" class="bg-white p-8 rounded shadow-md w-full max-w-lg">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-4 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4">
            <input type="hidden" name="numero_etudiant" id="numero_etudiant" 
                   class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" 
                   value="{{ old('matricule', $etudiant->matricule) }}" required>
            @error('numero_etudiant')
                <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="nom" class="block text-gray-700 font-semibold">Nom :</label>
            <input type="text" name="nom" id="nom" 
                   class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" 
                   value="{{ old('nom', $etudiant->nom) }}" required>
            @error('nom')
                <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="prenom" class="block text-gray-700 font-semibold">Prénom :</label>
            <input type="text" name="prenom" id="prenom" 
                   class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" 
                   value="{{ old('prenom', $etudiant->prenom) }}" required>
            @error('prenom')
                <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="niveau" class="block text-gray-700 font-semibold">Niveau :</label>
            <select name="niveau" id="niveau" 
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" 
                    required>
                <option value="L1" {{ old('niveau', $etudiant->niveau) == 'L1' ? 'selected' : '' }}>L1</option>
                <option value="L2" {{ old('niveau', $etudiant->niveau) == 'L2' ? 'selected' : '' }}>L2</option>
                <option value="L3" {{ old('niveau', $etudiant->niveau) == 'L3' ? 'selected' : '' }}>L3</option>
            </select>
            @error('niveau')
                <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="text-center">
            <button type="submit" 
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:ring focus:ring-blue-300">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection
