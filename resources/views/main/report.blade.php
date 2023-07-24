@if (!empty($report))
	<div class="panel-body">
		<div class="form-group">
			<label>Тип отчета:</label>&nbsp;&nbsp;&nbsp;
			<label class="radio-inline">
				<input type="radio" name="report-type" value="default" checked>
				Краткий
			</label>
			<label class="radio-inline">
				<input type="radio" name="report-type" value="extended">
				Расширенный
			</label>
		</div>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr class="info">
					<th class="text-center" style="width: 10%;">Год</th>
					<th class="text-center" style="width: 10%;">Месяц</th>
					@if (!empty($optypes))
						@foreach ($optypes as $optype)
							<th class="text-center" style="width: 15%;">{{ $optype['name'] }}</th>
						@endforeach
						<th class="text-center" style="width: 15%;">Прибыль</th>
						<th class="text-center" style="width: 15%;">Баланс</th>
					@endif
				</tr>
			</thead>
			<tbody>
			@foreach ($report as $period => $rows)
				@php
					$periodParts = explode(' ', $period);
				@endphp
				<tr>
					<td data-year="{{ $periodParts[0] }}" class="text-center">{{ $periodParts[0] }}</td>
					<td data-month="{{ $periodParts[1] }}" class="text-center">{{ $months[$periodParts[1]] }}</td>
					@if (!empty($optypes))
						@foreach ($optypes as $optype)
							<td class="text-right text-nowrap">
								@foreach ($rows['optype'] as $alias => $opsum)
									@if ($optype['alias'] == $alias)
										{{ number_format($opsum['opsum'], 2, '.', ' ') }}

										@if (!empty($opsum['opcat']))
											<table class="table table-striped table-bordered table-hover js-detail-report hidden" style="margin-top: 15px;">
												@foreach ($opsum['opcat'] as $opcat => $opcatOpsum)
													@if ($alias == 'revaluation' && !$opcat)
														@continue
													@endif
													<tr>
														<td class="text-left text-nowrap" style="font-size: 12px;padding: 3px;">
															{{ $opcat }}
														</td>
														<td class="text-right text-nowrap" style="font-size: 12px;padding: 3px;">
															{{ number_format($opcatOpsum['opsum'], 2, '.', ' ') }}
														</td>
													</tr>
												@endforeach
											</table>
										@endif
									@endif
								@endforeach
							</td>
						@endforeach
					@endif
					<td nowrap class="text-right text-nowrap">
						@if ($rows['balance'])
							{{ number_format(($rows['balance'] - $rows['optype']['revaluation']['opsum']), 2, '.', ' ') }}
						@endif
					</td>
					<td nowrap class="text-right text-nowrap">
						@if ($rows['balance'])
							{{ number_format($rows['balance'], 2, '.', ' ') }}
						@endif
					</td>
				</tr>
			@endforeach
			</tbody>
			<tfoot>
				<tr class="warning">
					<th colspan="2" class="text-center">Итого</th>
					@if (!empty($optypes))
						@foreach ($optypes as $optype)
							<th class="text-right">
								@if (isset($reportSum[$optype['alias']]['opsum']) && !in_array($optype['alias'], ['revaluation']))
									{{ number_format($reportSum[$optype['alias']]['opsum'], 2, '.', ' ') }}
								@endif
								@if (!empty($reportSum[$optype['alias']]['opcat']))
									<table class="table table-striped table-bordered table-hover js-detail-report hidden" style="margin-top: 15px;">
										@foreach ($reportSum[$optype['alias']]['opcat'] as $opcat => $opcatOpsum)
											@if ($optype['alias'] == 'revaluation' && !$opcat)
												@continue
											@endif
											<tr>
												<th class="text-left text-nowrap" style="font-size: 12px;padding: 3px;">
													{{ $opcat }}
												</th>
												<th class="text-right text-nowrap" style="font-size: 12px;padding: 3px;">
													{{ number_format($opcatOpsum['opsum'], 2, '.', ' ') }}
												</th>
											</tr>
										@endforeach
									</table>
								@endif
							</th>
						@endforeach
					@endif
					<th nowrap class="text-right">
						{{ number_format(($reportSum['incomes']['opsum'] - $reportSum['expenses']['opsum']), 2, '.', ' ') }}
					</th>
					<th nowrap class="text-right"></th>
				</tr>
			</tfoot>
		</table>
	</div>
@endif
