@extends('welcome')
@section('content')
<div class="container-fluid">
    <form action="{{ route('Ue.store')}}" method="POST">
    @csrf
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
                        <input type="text" name="code" id="code">
                    </div>
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" id="nom">
                    </div>
                    <div class="form-group">
                        <label for="credit">Credit</label>
                        <input type="text" name="credit" id="credit">
                    </div>
                    <div class="form-group">
                        <label for="semestre">Semestre</label>
                        <input type="text" name="semestre" plaria-placeholder="semestre compris entre 1 et 6 " id="semestre">
                    </div>
                    <div class="form-group">
                        <button type="submit">Envoyer</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>