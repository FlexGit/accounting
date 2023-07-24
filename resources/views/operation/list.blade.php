@if (!empty($operations))
	<div class="panel-body">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr class="info">
					<th style="width: 5%;">ID</th>
					<th class="text-center" style="width: 15%;">Тип</th>
					<th class="text-center" style="width: 25%;">Категория</th>
					<th class="text-center" style="width: 20%;">Комментарий</th>
					<th class="text-center" style="width: 15%;">Сумма, руб</th>
					<th class="text-center" style="width: 15%;">Дата создания</th>
					<th class="text-center" style="width: 15%;">Действие</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($operations['rows'] as $operationId => $operation)
					<tr>
						<td>{{ $operationId }}</td>
						<td class="text-center">
							{{ $operation['optype'] }}
							@if ($operation['revaluationType'])
								<div class="alert alert-info" role="alert" style="padding: 0;margin: 0;">
									{{ $operation['revaluationType'] }}
								</div>
							@endif
						</td>
						<td class="text-center">{{ $operation['opcat'] }}</td>
						<td>{!! $operation['comment'] !!}</td>
						<td class="text-right">
							{{ number_format($operation['opsum'], 2, '.', ' ') }}
							@if ($operation['percent'])
								<div class="alert alert-info" role="alert" style="padding: 0;margin: 0;">
									{{ $operation['percent'] }} %
								</div>
							@endif
							@if ($operation['is_accrued'])
								<div class="alert alert-warning" role="alert" style="padding: 0;margin: 0;">
									Виртуально
								</div>
							@endif
						</td>
						<td class="text-center">@if ($operation['created_at']){{ date('Y-m-d H:i', strtotime($operation['created_at'])) }}@endif</td>
						<td class="text-center">
							<a href="javascript:void(0);" data-operation-id="{{ $operationId }}" class="js-operation-edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
							<a href="javascript:void(0);" data-operation-id="{{ $operationId }}" class="js-operation-delete"><i class="fas fa-trash-alt"></i></a>
						</td>
					</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr class="warning">
					<th colspan="4" class="text-right">Баланс:</th>
					<th class="text-right">{{ number_format($operations['total'], 2, '.', ' ') }}</th>
					<th colspan="3"></th>
				</tr>
			</tfoot>
		</table>
	</div>
@endif
