@extends('layouts.app')

@section('content')
	<h1>Atualizar Loja</h1>
	<form action="{{ route('admin.stores.update', ['store'=> $store->id]) }}" method="POST" enctype="multipart/form-data">
		@csrf
		@method("PUT")
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
			<p>
				<img src="{{asset('storage/'. $store->logo)}}" alt="">
			</p>
			<label for="logo">Foto da Loja</label>
			<input type="file" id="logo" name="logo" class="form-control @error('logo') is-invalid @enderror">
			@error('logo')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
			@enderror
		</div>
		
		<div>
			<button type="submit" class="btn btn-primary">Atualizar loja</button>
		</div>
	</form>
@endsection
