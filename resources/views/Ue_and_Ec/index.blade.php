@extends('dashboard')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between mb-6">
        <a href="{{ route('Ue.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Créer une UE
        </a>
        <a href="{{ route('Ec.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Créer une EC
        </a>
    </div>

    @foreach ($Ues as $Ue)
        <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4 flex justify-between items-center">
    <span>UE:{{ $Ue->nom }} CODE:({{ $Ue->code }}) COEF:{{ $Ue->credits_ects }}</span>
    
    <form action="{{ route('Ue.delete', $Ue->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
            Supprimer UE
        </button>
    </form>
</h2>

            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead class="bg-blue-500 text-white">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-left">Nom</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Code</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Coefficient</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Ue->elements_constitutifs as $ec)
                            <tr class="hover:bg-gray-100">
                                <td class="border border-gray-300 px-4 py-2">{{ $ec->nom }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $ec->code }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $ec->coefficient }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <div class="flex gap-2">
                                        <a href="{{ route('Ec.edit', $ec->id) }}" 
                                           class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                            Modifier
                                        </a>
                                        <form action="{{ route('Ec.delete', $ec->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

    <footer class="bg-blue-600 py-4 mt-10">
    <div class="flex justify-center">
        <form action="" method="POST">
            @csrf
            <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-green-600 transition duration-300">
                Enregistrer les notes
            </button>
        </form>
    </div>
</footer>
</div>


@endsection
