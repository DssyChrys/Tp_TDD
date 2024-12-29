@extends('welcome')
@section('content')
<style>
    .main{
        width: 80%;
        margin-left: 100px;
        margin-top: 30px;
    }
    .main2 a{
        margin-right: 20px;
    }
    .action{
        display: flex;
    }
</style>
<div class="main">
    <div class="main2">
        <a href="{{route('Ue.create')}}" class="">
            Creer une UE
        </a>
        <a href="{{route('Ec.create')}}" class="">
            Creer une EC
        </a>
    </div>
    @foreach ($Ues as $Ue)
        <h2>{{$Ue->nom}} {{$Ue->code}}</h2>  
            @foreach($Ue->elements_constitutifs as $ec)
            <table>
                <thead>
                    <tr>
                        <th>nom</th>
                        <th>code</th>
                        <th>coefficient</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>{{ $ec->nom }}</td>
                        <td>{{ $ec->code }}</td>
                        <td>{{ $ec->coefficient }}</td>
                        <td>
                            <div class="action">
                            <button type="submit"><a href="{{ route('Ec.edit', $ec->id) }}">Modifier</a></button>
                            <form action="{{ route('Ec.delete', $ec->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                     <button type="submit">Supprimer</button>
                             </form>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            @endforeach
    
    @endforeach
</div>