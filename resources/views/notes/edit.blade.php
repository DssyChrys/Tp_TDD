 

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifier la Note</h1>

        <form action="{{ route('notes.update', $note) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="note">Note :</label>
                <input type="text" name="note" id="note" value="{{ old('note', $note->note) }}" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Sauvegarder</button>
            </div>
        </form>
    </div>
@endsection
