@extends('layouts.app')

@section('content')
	
	<a href="{{ route('admin.notifications.read.all') }}" class="btn btn-lg btn-success">Marcar todas como lidas</a>

	<table class="table table-striped">
		<thead>
			<th>Notificação</th>
			<th>Criado em</th>
			<th>Ações</th>			
		</thead>
		<tbody>
			@forelse($unreadNotifications as $n)
				<tr>
					<td>{{ $n->data['message'] }}</td>
					{{-- <td>{{ $n->created_at->format('d/m/Y H:i:s') }}</td>			 --}}
					<td>{{ $n->created_at->locale('pt')->diffForHumans() }}</td>			
					<td>
						<div class="btn-group">
							<a href="{{route('admin.notifications.read',['notification' => $n->id])}}" class="btn btn-sm btn-primary">Marcar como lida</a>
														
						</div>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="3">
						<div class="alert alert-warning">
							Nenhuma notificação encontrada
						</div>
					</td>
				</tr>				
			@endforelse
		</tbody>
		
	</table>

	{{-- {{ $products->links() }} --}}

@endsection


