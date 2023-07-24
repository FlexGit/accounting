@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-heading">
					<h1 class="panel-title text-center">Шаблоны операций</h1>
					<div class="container">
						<div class="row">
							<div class="col-sm-12 text-right">
								<a href="javascript: void(0);" class="btn btn-success btn-sm js-template-edit"><i class="far fa-plus-square"></i>&nbsp;&nbsp;Создать</a>
							</div>
						</div>
					</div>
				</div>
				<div class="js-template-content"></div>
			</div>
		</div>
	</div>
	<div class="hidden">
		<div class="modal container fade" id="template-modal" style="display: block; padding-left: 0; margin-top: 0;" aria-hidden="false" tabindex="-1"></div>
	</div>
@endsection