@extends('layouts.app')
		
@section('content')
	<h1>Criar Loja</h1>
	<form action="{{ route('admin.stores.store') }}" method="POST">
		@csrf
		
		<div class="form-group">
			<label for="">Nome Loja</label>
			<input type="text" name="name" class="form-control">
		</div>

		<div class="form-group">
			<label for="">Descrição</label>
			<input type="text" name="description" class="form-control">	
		</div>

		<div class="form-group">
			<label for="">Telefone</label>
			<input type="text" name="phone" class="form-control">	
		</div>

		<div class="form-group">
			<label for="">Celular/Whatsapp</label>
			<input type="text" name="mobile_phone" class="form-control">	
		</div>

		<div class="form-group">
			<label for="">Slug</label>
			<input type="text" name="slug" class="form-control">	
		</div>

		<div>
			<button type="submit" class="btn btn-primary">Criar loja</button>
		</div>
	</form>
@endsection