@extends('layouts.app')

@section('content')
	
	<a href="{{ route('admin.stores.create') }}" class="btn btn-lg btn-success">Criar Loja</a>
	<table class="table table-striped">
		<thead>
			<th>#</th>
			<th>Loja</th>
			<th>Ações</th>
		</thead>
		<tbody>
			@foreach($stores as $store)
				<tr>
					<td>{{ $store->id }}</td>
					<td>{{ $store->name }}</td>
					<td>
						<div class="btn-group">							
							<a href="{{ route('admin.stores.edit', ['store'=>$store->id]) }}" class="btn btn-sm btn-primary">Editar</a>

							<form action="{{ route('admin.stores.destroy', ['store'=>$store->id]) }}" method="POST">
								@csrf
								@method("delete")
								<button type="submit" class="btn btn-sm btn-danger">Apagar</button>
							</form>
						</div>						
					</td>
				</tr>
			@endforeach	
		</tbody>
		
	</table>

	{{ $stores->links() }}

@endsection


