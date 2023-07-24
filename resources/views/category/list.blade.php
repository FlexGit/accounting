@if (!empty($categories))
	<div class="panel-body">
		<table class="table table-striped table-bordered table-hover">
			<thead>
			<tr class="info">
				<th style="width: 5%;">ID</th>
				<th class="text-center" style="width: 30%;">Наименование</th>
				<th class="text-center" style="width: 20%;">Дата создания</th>
				<th class="text-center" style="width: 15%;">Действие</th>
			</tr>
			</thead>
			<tbody>
			@foreach ($categories['rows'] as $opcatId => $category)
				<tr>
					<td>{{ $opcatId }}</td>
					<td>{{ $category['name'] }}</td>
					<td class="text-center">@if ($category['created_at']){{ date('Y-m-d', strtotime($category['created_at'])) }}@endif</td>
					<td class="text-center">
						<a href="javascript:void(0);" data-category-id="{{ $opcatId }}" class="js-category-edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
						<a href="javascript:void(0);" data-category-id="{{ $opcatId }}" class="js-category-delete"><i class="fas fa-trash-alt"></i></a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
@endif
