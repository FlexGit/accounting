@if (!empty($templates))
	<div class="panel-body">
		<table class="table table-striped table-bordered table-hover">
			<thead>
			<tr class="info">
				<th style="width: 5%;">ID</th>
				<th class="text-center" style="width: 15%;">Тип</th>
				<th class="text-center" style="width: 15%;">Категория</th>
				<th class="text-center" style="width: 30%;">Наименование</th>
				<th class="text-center" style="width: 20%;">Сумма по умолчанию, руб</th>
				<th class="text-center" style="width: 20%;">Дата создания</th>
				<th class="text-center" style="width: 15%;">Действие</th>
			</tr>
			</thead>
			<tbody>
			@foreach ($templates['rows'] as $templateId => $template)
				<tr>
					<td>{{ $templateId }}</td>
					<td class="text-center">{{ $template['optype'] }}</td>
					<td class="text-center">{{ $template['opcat'] }}</td>
					<td>{{ $template['name'] }}</td>
					<td class="text-right">@if (!empty($template['default_value'])){{ number_format($template['default_value'], 2, '.', ' ') }}@endif</td>
					<td class="text-center">@if ($template['created_at']){{ date('Y-m-d', strtotime($template['created_at'])) }}@endif</td>
					<td class="text-center">
						<a href="javascript:void(0);" data-template-id="{{ $templateId }}" class="js-template-edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
						<a href="javascript:void(0);" data-template-id="{{ $templateId }}" class="js-template-delete"><i class="fas fa-trash-alt"></i></a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
@endif
