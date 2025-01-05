@extends('dashboard')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <form action="{{ route('notes.store') }}" method="POST" class="bg-white p-8 rounded shadow-md w-full max-w-lg">
        @csrf

        @if(session('error'))
            <div class="bg-red-100 text-red-600 p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-4">
            <label for="etudiant_id" class="block text-gray-700 font-semibold">Étudiant :</label>
            <select name="etudiant_id" id="etudiant_id" 
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" 
                    required>
                @foreach($etudiants as $etudiant)
                    <option value="{{ $etudiant->id }}">{{ $etudiant->nom }} {{ $etudiant->prenom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="ec_id" class="block text-gray-700 font-semibold">Élément Constitutif (EC) :</label>
            <select name="ec_id" id="ec_id" 
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" 
                    required>
                @foreach($ecs as $ec)
                    <option value="{{ $ec->id }}">{{ $ec->code }} - {{ $ec->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="note" class="block text-gray-700 font-semibold">Note :</label>
            <input type="number" name="note" id="note" 
                   class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" 
                   min="0" max="20" step="0.25" required>
        </div>

        <div class="mb-4">
            <label for="session" class="block text-gray-700 font-semibold">Session :</label>
            <select name="session" id="session" 
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" 
                    required>
                <option value="normale">Session Normale</option>
                <option value="rattrapage">Session de Rattrapage</option>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" 
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:ring focus:ring-blue-300">
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
