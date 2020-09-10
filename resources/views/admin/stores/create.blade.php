@extends('layouts.app')

@section('content')
	<h1>Criar Loja</h1>
	<form action="{{ route('admin.stores.store') }}" method="POST" enctype="multipart/form-data">
		@csrf

		<div class="form-group">
			<label for="">Nome Loja</label>
			<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">

			@error('name')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
			@enderror
		</div>

		<div class="form-group">
			<label for="">Descrição</label>
			<input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}">

			@error('description')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
			@enderror
		</div>

		<div class="form-group">
			<label for="">Telefone</label>
			<input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value={{ old('phone') }}>

			@error('phone')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
			@enderror
		</div>

		<div class="form-group">
			<label for="">Celular/Whatsapp</label>
			<input type="text" name="mobile_phone" class="form-control @error('mobile_phone') is-invalid @enderror" value="{{ old('mobile_phone') }}">

			@error('mobile_phone')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
			@enderror
		</div>

		<div class="form-group">
			<label for="logo">Foto da Loja</label>
			<input type="file" id="logo" name="logo" class="form-control @error('logo') is-invalid @enderror">
			@error('logo')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
			@enderror
		</div>

		<div>
			<button type="submit" class="btn btn-primary">Criar loja</button>
		</div>
	</form>
@endsection