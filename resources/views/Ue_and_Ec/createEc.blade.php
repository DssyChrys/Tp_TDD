@extends('dashboard')
@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <form action="{{ route('Ec.store') }}" method="POST" class="bg-white p-8 rounded shadow-md w-full max-w-lg">
        @csrf

        @if($errors->any())
            <div class="bg-red-100 text-red-600 p-4 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4">
            <label for="code" class="block text-gray-700 font-semibold">Code</label>
            <input type="text" name="code" id="code" 
                   class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" 
                   required>
        </div>

        <div class="mb-4">
            <label for="nom" class="block text-gray-700 font-semibold">Nom</label>
            <input type="text" name="nom" id="nom" 
                   class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" 
                   required>
        </div>

        <div class="mb-4">
            <label for="coefficient" class="block text-gray-700 font-semibold">Coefficient</label>
            <input type="text" name="coefficient" id="coefficient" 
                   class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" 
                   required>
        </div>

        <div class="mb-4">
            <label for="Ue" class="block text-gray-700 font-semibold">Ue</label>
            <select name="ue_id" id="ue_id" 
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300">
                @foreach($Ues as $Ue)
                    <option value="{{ $Ue->id }}" {{ $Ue->id == old('Ue') ? 'selected' : '' }}>
                        {{ $Ue->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="text-center">
            <button type="submit" 
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:ring focus:ring-blue-300">
                Envoyer
            </button>
        </div>
    </form>
</div>
@endsection
