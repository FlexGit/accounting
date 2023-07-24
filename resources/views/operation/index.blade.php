@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-heading">
					<h1 class="panel-title text-center">Операции</h1>
					<div class="container">
						<div class="row">
							<form>
								<div class="col-sm-2">
									<div class="form-group">
										<label for="year">Год:</label>
										<select id="year" name="year" class="form-control js-operation-year-selector">
											@foreach ($years as $year)
												<option value="{{ $year }}" @if($year == date("Y")) selected @endif>{{ $year }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<label for="month">Месяц:</label>
										<select id="month" name="month" class="form-control js-operation-date-selector">
											@foreach ($months as $k => $month)
												<option value="{{ $k }}" @if($k == date("n")) selected @endif>{{ $month }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</form>
							<div class="col-sm-8 text-right">
								<a href="javascript: void(0);" class="btn btn-success btn-sm js-operation-edit"><i class="far fa-plus-square"></i>&nbsp;&nbsp;Создать</a>
							</div>
						</div>
					</div>
				</div>
				<div class="js-operation-content"></div>
			</div>
		</div>
	</div>
	<div class="hidden">
		<div class="modal container fade" id="operation-modal" style="display: block; padding-left: 0; margin-top: 0;" aria-hidden="false" tabindex="-1"></div>
	</div>
@endsection