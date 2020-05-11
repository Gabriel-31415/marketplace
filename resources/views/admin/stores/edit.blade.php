@extends('layouts.app')
		
@section('content')
	<h1>Criar Loja</h1>
	<form action="{{ route('admin.stores.update', ['store'=> $store->id]) }}" method="POST">
		@csrf
		<div class="form-group">
			<label for="">Nome Loja</label>
			<input type="text" name="name" class="form-control" value="{{ $store->name }}">
		</div>

		<div class="form-group">
			<label for="">Descrição</label>
			<input type="text" name="description" class="form-control" value="{{ $store->description }}">	
		</div>

		<div class="form-group">
			<label for="">Telefone</label>
			<input type="text" name="phone" class="form-control" value="{{ $store->phone }}">	
		</div>

		<div class="form-group">
			<label for="">Celular/Whatsapp</label>
			<input type="text" name="mobile_phone" class="form-control" value="{{ $store->mobile_phone }}">	
		</div>

		<div class="form-group">
			<label for="">Slug</label>
			<input type="text" name="slug" class="form-control" value="{{ $store->slug }}">	
		</div>

		
		<div>
			<button type="submit" class="btn btn-primary">Atualizar loja</button>
		</div>
	</form>
@endsection