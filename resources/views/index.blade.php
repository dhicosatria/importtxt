<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ToDo</title>
</head>
<body>
	<form action="{{ url('/add-todo') }}" method="post">
		@csrf
		<input type="text" name="title" placeholder="Title">
		<input type="submit" name="submit" value="Add ToDo"><br/>
	</form>

	<table border="1" style="margin-top: 20px;">
		<tr>
			<td></td>
			<th>Title</th>
			<th>Check</th>
			<th>Action</th>
		</tr>
		@foreach($data_todo as $data)
			<tr>
				<td>
					<form action="{{ url('check-todo/'.$data->id) }}" method="post">
						@csrf
						@method('put')
						@if($data->checked == 0)
							@php
								$check = 1;
							@endphp
						@else
							@php
								$check = 0;
							@endphp
						@endif
						<input type="hidden" name="check" value="{{ $check }}">
						<input type="submit" value="check">
					</form>
				</td>
				<td>{{ $data->title }}</td>
				<td>{{ $data->checked }}</td>
				<td>
					<form action="{{ url('delete-todo/'.$data->id) }}" method="post">
						@csrf
						@method('delete')
						<input type="submit" value="delete">
					</form>
				</td>
			</tr>
		@endforeach
	</table>

</body>
</html>