@extends('dashboard')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-lg">
        <h1 class="text-2xl font-semibold mb-4">Moyenne des Notes de l'Étudiant</h1>

        <p class="text-lg mb-4"><strong>Étudiant ID: {{ $etudiantId }}</strong></p>

        @if (isset($notes) && $notes->isNotEmpty())
            <h3 class="text-xl font-semibold mb-3">Notes de l'Étudiant:</h3>
            <ul class="list-disc pl-5 mb-4">
                @foreach ($notes as $note)
                    <li class="mb-2">Note: <span class="font-semibold">{{ $note->note }}</span> | 
                        Coefficient: <span class="font-semibold">{{ $note->ec->coefficient }}</span> 
                        - <span class="text-sm text-gray-600">{{ $note->session == 'normale' ? 'Contrôle Continu' : 'Contrôle Terminal' }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-red-600 mb-4">Aucune note trouvée pour cet étudiant.</p>
        @endif

        @if ($moyenne > 0)
            <p class="font-semibold text-lg mb-4">Moyenne pondérée : <span class="text-blue-600">{{ number_format($moyenne, 2) }}</span></p>
        @else
            <p class="text-red-600 mb-4">Aucune note valide pour calculer la moyenne.</p>
        @endif

        <div class="text-center">
            <a href="{{ route('notes.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:ring focus:ring-blue-300">Retour à la liste des notes</a>
        </div>
    </div>
</div>
@endsection
