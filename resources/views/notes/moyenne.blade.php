 

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Moyenne des Notes de l'Étudiant</h1>

        
        <p><strong>Étudiant ID: {{ $etudiantId }}</strong></p>

        @if (isset($notes) && $notes->isNotEmpty())
            <h3>Notes de l'Étudiant:</h3>
            <ul>
                @foreach ($notes as $note)
                    <li>Note: {{ $note->note }} | Coefficient: {{ $note->ec->coefficient }} </li>
                @endforeach
            </ul>
        @else
            <p>Aucune note trouvée pour cet étudiant.</p>
        @endif

        @if ($moyenne > 0)
            <p><strong>Moyenne pondérée : {{ number_format($moyenne, 2) }}</strong></p>
        @else
            <p>Aucune note valide pour calculer la moyenne.</p>
        @endif
 
        <a href="{{ route('notes.index') }}" class="btn btn-primary">Retour à la liste des notes</a>
    </div>
@endsection
