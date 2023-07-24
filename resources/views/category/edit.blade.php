<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">Категория операции # <span class="js-category-id"></span></h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form method="POST" id="category-form">
				<input type="hidden" name="opcat_id" value="@if (!empty($category)) {{ $category['id'] }} @endif">
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label>Наименование</label>
							<input type="text" name="name" value="@if (!empty($category) && $category['name']){{ $category['name'] }}@endif" required class="form-control" placeholder="">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary js-category-save">Сохранить</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
