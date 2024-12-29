@extends('welcome')
@section('content')
<div class="container-fluid">
    <form action="{{ route('Ec.update', $ec->id)}}" method="POST">
    @csrf
    @method('PUT')
        @if($errors->any())
           <div class="alert alert-danger">
               <ul>
                   @foreach($errors->all() as $error)
                       <li>{{ $error }}</li>
                   @endforeach
               </ul>
           </div>
        @endif
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="code">Code</label>
                        <input type="text" required value="{{ $ec->code }}" name="code" id="code">
                    </div>
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" required value="{{ $ec->nom }}" name="nom" id="nom">
                    </div>
                    <div class="form-group">
                        <label for="coefficient">Coefficient</label>
                        <input type="text" required value="{{ $ec->coefficient }}" name="coefficient" id="coefficient">
                    </div>
                    <div class="form-group">
                        <label for="Ue">Ue</label>
                        <select type="text" name="Ue_id" id="Ue_id">
                            @foreach ($Ues as $Ue)
                                <option value="{{ $Ue->id}}" {{ $Ue->id == old('Ue') ? 'selected' : '' }}>
                                    {{ $Ue->nom}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit">Enregistrer modification</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>