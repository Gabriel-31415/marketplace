@extends('layouts.app')
		
@section('content')
		<h1>Atualizar Produto</h1>
	<form action="{{ route('admin.products.update', ['product'=> $product->id]) }}" method="POST">
		@csrf
		@method("PUT")
		<div class="form-group">
			<label for="">Nome Produto</label>
			<input type="text" name="name" class="form-control" value="{{ $product->name }}">
		</div>

		<div class="form-group">
			<label for="">Descrição</label>
			<input type="text" name="description" class="form-control"  value="{{ $product->description }}">	
		</div>

		<div class="form-group">
			<label for="">Conteúdo</label>
			<textarea name="body" id="" cols="30" rows="10" class="form-control"  >{{ $product->body }} </textarea> 	
		</div>

		<div class="form-group">
			<label for="">Preço</label>
			<input type="text" name="price" class="form-control" value="{{ $product->price }}">	
		</div>

		<div class="form-group">
			<label for="">Slug</label>
			<input type="text" name="slug" class="form-control" value="{{ $product->slug }}">	
		</div>

		<div>
			<button type="submit" class="btn btn-primary">Atualizar Produto</button>
		</div>
	</form>
@endsection