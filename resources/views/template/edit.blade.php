<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">Шаблон операции # <span class="js-template-id"></span></h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form method="POST" id="template-form">
				<input type="hidden" name="template_id" value="@if (!empty($template)) {{ $template['id'] }} @endif">
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label>Тип операции:</label>&nbsp;&nbsp;&nbsp;
							<label class="radio-inline">
								<input type="radio" name="optype" value="1" @if (!empty($template) && $template['optype_id'] == 1) checked @endif required>
								Доходы
							</label>
							<label class="radio-inline">
								<input type="radio" name="optype" value="2" @if ((!empty($template) && $template['optype_id'] == 2) || empty($template))  checked @endif required>
								Расходы
							</label>
						</div>
						<div class="form-group">
							<label>Категория</label>
							<select name="opcat" class="form-control">
								<option></option>
								@if (!empty($categories))
									@foreach ($categories as $opcatId => $category)
										<option value="{{ $opcatId }}" @if ((!empty($template) && $template['opcat_id'] == $opcatId)) selected @endif>{{ $category }}</option>
									@endforeach
								@endif
							</select>
						</div>
						<div class="form-group">
							<label>Наименование</label>
							<input type="text" name="name" value="@if (!empty($template) && $template['name']){{ $template['name'] }}@endif" required class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<label>Сумма по умолчанию, руб</label>
							<input type="number" name="default_value" value="@if (!empty($template) && $template['default_value']){{ $template['default_value'] }}@endif" class="form-control" placeholder="">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary js-template-save">Сохранить</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
