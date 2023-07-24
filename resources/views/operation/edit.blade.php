<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">Операция # <span class="js-operation-id"></span></h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form method="POST" id="operation-form">
				<input type="hidden" name="operation_id" value="@if (!empty($operation)) {{ $operation['id'] }} @endif">
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label>Тип:</label>&nbsp;&nbsp;&nbsp;
							@if (!empty($optypes))
								@foreach ($optypes as $optype)
									<label class="radio-inline">
										<input type="radio" name="optype" value="{{ $optype['id'] }}" @if (!empty($operation) && $operation['optype_id'] == $optype['id']) checked @endif required>
										{{ $optype['name'] }}
									</label>
								@endforeach
							@endif
						</div>
						<div class="form-group">
							<label>Категория</label>
							<select name="opcat" class="form-control">
								<option></option>
								@if (!empty($categories))
									@foreach ($categories as $opcatId => $category)
										<option value="{{ $opcatId }}" @if ((!empty($operation) && $operation['opcat_id'] == $opcatId)) selected @endif>{{ $category }}</option>
									@endforeach
								@endif
							</select>
						</div>
						<div class="form-group">
							<label>Шаблон</label>
							<select name="template" class="form-control">
							</select>
						</div>
						<div class="form-group">
							<label>Комментарий</label>
							<textarea name="comment" rows="3" required class="form-control" placeholder="">@if (!empty($operation) && $operation['comment']){{ $operation['comment'] }}@endif</textarea>
						</div>
						<div class="form-group">
							<label>Сумма, руб</label>
							<input type="number" name="opsum" value="@if (!empty($operation) && $operation['opsum']){{ $operation['opsum'] }}@endif" required class="form-control" placeholder="">
						</div>
						<div class="form-group hidden">
							<label>Процент, %</label>
							<input type="number" name="percent" value="@if (!empty($operation) && $operation['percent']){{ $operation['percent'] }}@endif" required class="form-control" placeholder="">
						</div>
						<div class="checkbox">
							<label class="checkbox-inline" for="is_accrued">
								<input type="checkbox" id="is_accrued" name="is_accrued" value="1" @if (!empty($operation) && $operation['is_accrued']) checked @endif> Виртуально
							</label>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary js-operation-save">Сохранить</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
