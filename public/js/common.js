$(document).ready(function() {

	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	toastr.options = {
		"positionClass": "toast-bottom-right",
	};

	//$('.phone').mask('8-000-000-00-00', {placeholder: "8-___-___-__-__"});

	/*-----------------------------------/
	/*	TOP NAVIGATION AND LAYOUT
	/*----------------------------------*/

	$('.btn-toggle-fullwidth').on('click', function() {
		if(!$('body').hasClass('layout-fullwidth')) {
			$('body').addClass('layout-fullwidth');

		} else {
			$('body').removeClass('layout-fullwidth');
			$('body').removeClass('layout-default'); // also remove default behaviour if set
		}

		$(this).find('.lnr').toggleClass('lnr-arrow-left-circle lnr-arrow-right-circle');

		if($(window).innerWidth() < 1025) {
			if(!$('body').hasClass('offcanvas-active')) {
				$('body').addClass('offcanvas-active');
			} else {
				$('body').removeClass('offcanvas-active');
			}
		}
	});

	$(window).on('load', function() {
		if($(window).innerWidth() < 1025) {
			$('.btn-toggle-fullwidth').find('.icon-arrows')
			.removeClass('icon-arrows-move-left')
			.addClass('icon-arrows-move-right');
		}

		// adjust right sidebar top position
		$('.right-sidebar').css('top', $('.navbar').innerHeight());

		// if page has content-menu, set top padding of main-content
		if($('.has-content-menu').length > 0) {
			$('.navbar + .main-content').css('padding-top', $('.navbar').innerHeight());
		}

		// for shorter main content
		if($('.main').height() < $('#sidebar-nav').height()) {
			$('.main').css('min-height', $('#sidebar-nav').height());
		}
	});


	/*-----------------------------------/
	/*	SIDEBAR NAVIGATION
	/*----------------------------------*/

	$('.sidebar a[data-toggle="collapse"]').on('click', function() {
		if($(this).hasClass('collapsed')) {
			$(this).addClass('active');
		} else {
			$(this).removeClass('active');
		}
	});

	if( $('.sidebar-scroll').length > 0 ) {
		$('.sidebar-scroll').slimScroll({
			height: '95%',
			wheelStep: 2,
		});
	}


	/*-----------------------------------/
	/*	PANEL FUNCTIONS
	/*----------------------------------*/

	// panel remove
	$('.panel .btn-remove').click(function(e){

		e.preventDefault();
		$(this).parents('.panel').fadeOut(300, function(){
			$(this).remove();
		});
	});

	// panel collapse/expand
	var affectedElement = $('.panel-body');

	$('.panel .btn-toggle-collapse').clickToggle(
		function(e) {
			e.preventDefault();

			// if has scroll
			if( $(this).parents('.panel').find('.slimScrollDiv').length > 0 ) {
				affectedElement = $('.slimScrollDiv');
			}

			$(this).parents('.panel').find(affectedElement).slideUp(300);
			$(this).find('i.lnr-chevron-up').toggleClass('lnr-chevron-down');
		},
		function(e) {
			e.preventDefault();

			// if has scroll
			if( $(this).parents('.panel').find('.slimScrollDiv').length > 0 ) {
				affectedElement = $('.slimScrollDiv');
			}

			$(this).parents('.panel').find(affectedElement).slideDown(300);
			$(this).find('i.lnr-chevron-up').toggleClass('lnr-chevron-down');
		}
	);


	/*-----------------------------------/
	/*	PANEL SCROLLING
	/*----------------------------------*/

	if( $('.panel-scrolling').length > 0) {
		$('.panel-scrolling .panel-body').slimScroll({
			height: '430px',
			wheelStep: 2,
		});
	}

	if( $('#panel-scrolling-demo').length > 0) {
		$('#panel-scrolling-demo .panel-body').slimScroll({
			height: '175px',
			wheelStep: 2,
		});
	}

	/*-----------------------------------/
	/*	TODO LIST
	/*----------------------------------*/

	$('.todo-list input').change( function() {
		if( $(this).prop('checked') ) {
			$(this).parents('li').addClass('completed');
		}else {
			$(this).parents('li').removeClass('completed');
		}
	});


	/*-----------------------------------/
	/* TOASTR NOTIFICATION
	/*----------------------------------*/

	if($('#toastr-demo').length > 0) {
		toastr.options.timeOut = "false";
		toastr.options.closeButton = true;
		toastr['info']('Hi there, this is notification demo with HTML support. So, you can add HTML elements like <a href="#">this link</a>');

		$('.btn-toastr').on('click', function() {
			$context = $(this).data('context');
			$message = $(this).data('message');
			$position = $(this).data('position');

			if($context == '') {
				$context = 'info';
			}

			if($position == '') {
				$positionClass = 'toast-left-top';
			} else {
				$positionClass = 'toast-' + $position;
			}

			toastr.remove();
			toastr[$context]($message, '' , { positionClass: $positionClass });
		});

		$('#toastr-callback1').on('click', function() {
			$message = $(this).data('message');

			toastr.options = {
				"timeOut": "300",
				"onShown": function() { alert('onShown callback'); },
				"onHidden": function() { alert('onHidden callback'); }
			}

			toastr['info']($message);
		});

		$('#toastr-callback2').on('click', function() {
			$message = $(this).data('message');

			toastr.options = {
				"timeOut": "10000",
				"onclick": function() { alert('onclick callback'); },
			}

			toastr['info']($message);

		});

		$('#toastr-callback3').on('click', function() {
			$message = $(this).data('message');

			toastr.options = {
				"timeOut": "10000",
				"closeButton": true,
				"onCloseClick": function() { alert('onCloseClick callback'); }
			}

			toastr['info']($message);
		});
	}

	// Floating label
	$("body").on("input propertychange", ".floating", function(e) {
	    $(this).toggleClass("floating-with-value", !!$(e.target).val());
	}).on("focus", ".floating", function() {
	    $(this).addClass("floating-with-focus");
	}).on("blur", ".floating", function() {
	    $(this).removeClass("floating-with-focus");
	});

	$('#filter_date_from, #filter_date_to').datetimepicker({
		locale: 'ru'
	});

	$('.rule_template_field6').on('change', function(e) {
		if($(this).is(':checked'))
			$('.fieldset_template_field7').show();
		else
			$('.fieldset_template_field7').hide();
	});

	$('.rule_show').on('change', function(e) {
		if($(this).is(':checked')){
			$(this).closest('fieldset').find('.label_rule_required').show();
		}else{
			$(this).closest('fieldset').find('.rule_required').prop('checked', false);
			$(this).closest('fieldset').find('.label_rule_required').hide();
		}
	});

	/*---------------------------------------------------------------------------------------------*/

	/* Operations */

	var $operationMonthSelector = $('.js-operation-date-selector'),
		$operationYearSelector = $('.js-operation-year-selector'),
		$operationContent = $('.js-operation-content'),
		$operationModal = $('#operation-modal');

	function initOperationList() {
		$.ajax({
			async: true,
			type: 'GET',
			url: '/operation/list/ajax',
			dataType: 'json',
			data: {
				year: $operationYearSelector.val(),
				month: $operationMonthSelector.val()
			},
			cache: false,
			global: false,
			success: function (D) {
				//console.log(D);
				if (D.status !== 'success') {
					toastr.error("", D.reason ? D.reason : 'Не удалось загрузить список операций, попробуйте позже!');
					return;
				}
				$operationContent.html(D.data);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				toastr.error("", errorThrown.length ? errorThrown : 'Возникла ошибка, попробуйте повторить операцию позже!');
			}
		});
		return false;
	}

	$operationYearSelector.on('change', function (e) {
		initOperationList();
	});

	$operationMonthSelector.on('change', function (e) {
		initOperationList();
	});

	$(document).on('click', '.js-operation-edit', function () {
		var operationId = parseInt($(this).data('operation-id'));
		$('body').modalmanager('loading');
		$operationModal.load('/operation/edit', {operationId: operationId}, function () {
			$operationModal.modal();

			$('.operation').text(operationId);

			var $optypeControl = $('input:radio[name="optype"]');
			var optypeId = $optypeControl.filter(':checked').val();
			if(operationId) {
				$optypeControl.filter('[value=' + optypeId + ']').trigger('change');
			} else {
				$optypeControl.filter('[value=2]').prop('checked', true).trigger('change');
			}
		});
		return true;
	});

	$(document).on('click', '.js-operation-save', function () {
		var $form = $(this).closest('form'),
			operationId = parseInt($form.find('input[name="operation_id"]').val()),
			optypeId = parseInt($form.find('input:radio[name="optype"]:checked').val()),
			opcatId = parseInt($form.find('select[name="opcat"]').val()),
			comment = $form.find('textarea[name="comment"]').val(),
			opsum = $form.find('input[name="opsum"]').val(),
			isAccrued = parseInt($form.find('input[name="is_accrued"]:checked').val()),
			year = $operationYearSelector.val(),
			month = $operationMonthSelector.val();

		if (!comment || !opsum) {
			toastr.error("", 'Комментарий и сумма обязательны для заполнения!');
			return;
		}

		$.ajax({
			async: true,
			type: 'POST',
			url: '/operation/save',
			dataType: 'json',
			data: {
				operationId: operationId,
				optypeId: optypeId,
				opcatId: opcatId,
				comment: comment,
				opsum: opsum,
				isAccrued: isAccrued,
				year: year,
				month: month
			},
			cache: false,
			global: false,
			success: function (D) {
				if (D.status !== 'success') {
					toastr.error("", D.reason ? D.reason : 'Не удалось сохранить операцию # ' + operationId + ', попробуйте позже!');
					return;
				}
				toastr.success("", 'Операция # ' + D.operationId + ' успешно сохранена!');
				$('#operation-modal').modal('hide');
				initOperationList();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				toastr.error("", errorThrown.length ? errorThrown : 'Возникла ошибка, попробуйте повторить операцию позже!');
			}
		});
	});

	$(document).on('click', '.js-operation-delete', function () {
		if (!confirm('Вы уверены?')) return;
		var operationId = $(this).data('operation-id');
		$.ajax({
			async: true,
			type: 'POST',
			url: '/operation/delete',
			dataType: 'json',
			data: {
				operationId: operationId
			},
			cache: false,
			global: false,
			success: function (D) {
				if (D.status !== 'success') {
					toastr.error("", D.reason ? D.reason : 'Не удалось удалить операцию # ' + operationId + ', попробуйте позже!');
					return;
				}
				toastr.success("", 'Операция # ' + operationId + ' успешно удалена!');
				initOperationList();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				toastr.error("", errorThrown.length ? errorThrown : 'Возникла ошибка, попробуйте повторить операцию позже!');
			}
		});
	});

	$(document).on('change', 'input:radio[name="optype"]', function () {
		var $templateControl = $('select[name="template"]');
		var operationId = parseInt($('input[name="operation_id"]').val());

		$templateControl.empty();
		if (!operationId) {
			$('textarea[name="comment"]').text('');
			$('input[name="opsum"]').val('');
		}
		$templateControl.append('<option></option>');
		$.ajax({
			async: true,
			type: 'GET',
			url: '/template/list-control/ajax',
			dataType: 'json',
			data: {
				optypeId: $(this).val()
			},
			cache: false,
			global: false,
			success: function (D) {
				//console.log(D);
				if (D.status !== 'success') {
					toastr.error("", D.reason ? D.reason : 'Не удалось загрузить список шаблонов, попробуйте позже!');
					return;
				}
				$.each(D.values, function(index, value) {
					$templateControl.append('<option value="' + index + '" data-default-value="' + value.default_value + '">' + value.name + '</option>');
				});
			},
			error: function (jqXHR, textStatus, errorThrown) {
				toastr.error("", errorThrown.length ? errorThrown : 'Возникла ошибка, попробуйте повторить операцию позже!');
			}
		});
	});

	$(document).on('change', 'select[name="template"]', function () {
		var $selected = $(this).children("option:selected");
		$('textarea[name="comment"]').text($selected.text());
		$('input[name="opsum"]').val($selected.data('default-value'));
	});

	initOperationList();


	/* Templates */

	var $templateContent = $('.js-template-content'),
		$templateModal = $('#template-modal');

	function initTemplateList() {
		$.ajax({
			async: true,
			type: 'GET',
			url: '/template/list/ajax',
			dataType: 'json',
			cache: false,
			global: false,
			success: function (D) {
				if (D.status !== 'success') {
					toastr.error("", D.reason ? D.reason : 'Не удалось загрузить список шаблонов операций, попробуйте позже!');
					return;
				}
				$templateContent.html(D.data);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				toastr.error("", errorThrown.length ? errorThrown : 'Возникла ошибка, попробуйте повторить операцию позже!');
			}
		});
		return false;
	}

	$(document).on('click', '.js-template-edit', function () {
		var templateId = parseInt($(this).data('template-id'));
		$('body').modalmanager('loading');
		$templateModal.load('/template/edit', {templateId: templateId}, function () {
			$templateModal.modal();
			$('.js-template-id').text(templateId);
		});
		return true;
	});

	$(document).on('click', '.js-template-save', function () {
		var $form = $(this).closest('form'),
			templateId = parseInt($form.find('input[name="template_id"]').val()),
			optypeId = parseInt($form.find('input:radio[name="optype"]:checked').val()),
			opcatId = parseInt($form.find('select[name="opcat"]').val()),
			name = $form.find('input[name="name"]').val(),
			defaultValue = $form.find('input[name="default_value"]').val();

		if (!name) {
			toastr.error("", 'Наименование обязательно для заполнения!');
			return;
		}

		$.ajax({
			async: true,
			type: 'POST',
			url: '/template/save',
			dataType: 'json',
			data: {
				templateId: templateId,
				optypeId: optypeId,
				opcatId: opcatId,
				name: name,
				defaultValue: defaultValue
			},
			cache: false,
			global: false,
			success: function (D) {
				if (D.status !== 'success') {
					toastr.error("", D.reason ? D.reason : 'Не удалось сохранить шаблон # ' + templateId + ', попробуйте позже!');
					return;
				}
				toastr.success("", 'Шаблон # ' + D.templateId + ' успешно сохранен!');
				$('#template-modal').modal('hide');
				initTemplateList();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				toastr.error("", errorThrown.length ? errorThrown : 'Возникла ошибка, попробуйте повторить операцию позже!');
			}
		});
	});

	$(document).on('click', '.js-template-delete', function () {
		if (!confirm('Вы уверены?')) return;
		var templateId = $(this).data('template-id');
		$.ajax({
			async: true,
			type: 'POST',
			url: '/template/delete',
			dataType: 'json',
			data: {
				templateId: templateId
			},
			cache: false,
			global: false,
			success: function (D) {
				if (D.status !== 'success') {
					toastr.error("", D.reason ? D.reason : 'Не удалось удалить шаблон # ' + templateId + ', попробуйте позже!');
					return;
				}
				toastr.success("", 'Шаблон # ' + templateId + ' успешно удален!');
				initTemplateList();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				toastr.error("", errorThrown.length ? errorThrown : 'Возникла ошибка, попробуйте повторить операцию позже!');
			}
		});
	});

	initTemplateList();


	/* Categories */

	var $categoryContent = $('.js-category-content'),
		$categoryModal = $('#category-modal');

	function initCategoryList() {
		$.ajax({
			async: true,
			type: 'GET',
			url: '/category/list/ajax',
			dataType: 'json',
			cache: false,
			global: false,
			success: function (D) {
				if (D.status !== 'success') {
					toastr.error("", D.reason ? D.reason : 'Не удалось загрузить список категорий операций, попробуйте позже!');
					return;
				}
				$categoryContent.html(D.data);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				toastr.error("", errorThrown.length ? errorThrown : 'Возникла ошибка, попробуйте повторить операцию позже!');
			}
		});
		return false;
	}

	$(document).on('click', '.js-category-edit', function () {
		var opcatId = parseInt($(this).data('category-id'));
		$('body').modalmanager('loading');
		$categoryModal.load('/category/edit', {opcatId: opcatId}, function () {
			$categoryModal.modal();
			$('.js-category-id').text(opcatId);
		});
		return true;
	});

	$(document).on('click', '.js-category-save', function () {
		var $form = $(this).closest('form'),
			opcatId = parseInt($form.find('input[name="opcat_id"]').val()),
			name = $form.find('input[name="name"]').val();

		if (!name) {
			toastr.error("", 'Наименование обязательно для заполнения!');
			return;
		}

		$.ajax({
			async: true,
			type: 'POST',
			url: '/category/save',
			dataType: 'json',
			data: {
				opcatId: opcatId,
				name: name
			},
			cache: false,
			global: false,
			success: function (D) {
				if (D.status !== 'success') {
					toastr.error("", D.reason ? D.reason : 'Не удалось сохранить категорию # ' + opcatId + ', попробуйте позже!');
					return;
				}
				toastr.success("", 'Категория # ' + D.opcatId + ' успешно сохранена!');
				$('#category-modal').modal('hide');
				initCategoryList();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				toastr.error("", errorThrown.length ? errorThrown : 'Возникла ошибка, попробуйте повторить операцию позже!');
			}
		});
	});

	$(document).on('click', '.js-category-delete', function () {
		if (!confirm('Вы уверены?')) return;
		var opcatId = $(this).data('category-id');
		$.ajax({
			async: true,
			type: 'POST',
			url: '/category/delete',
			dataType: 'json',
			data: {
				opcatId: opcatId
			},
			cache: false,
			global: false,
			success: function (D) {
				if (D.status !== 'success') {
					toastr.error("", D.reason ? D.reason : 'Не удалось удалить категорию # ' + opcatId + ', попробуйте позже!');
					return;
				}
				toastr.success("", 'Категория # ' + opcatId + ' успешно удалена!');
				initCategoryList();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				toastr.error("", errorThrown.length ? errorThrown : 'Возникла ошибка, попробуйте повторить операцию позже!');
			}
		});
	});

	initCategoryList();


	/* MAIN REPORT */

	var $reportContent = $('.js-report-content');

	function initMainReport() {
		$.ajax({
			async: true,
			type: 'GET',
			url: '/main/report/ajax',
			dataType: 'json',
			cache: false,
			global: false,
			success: function (D) {
				if (D.status !== 'success') {
					toastr.error("", D.reason ? D.reason : 'Не удалось загрузить отчет, попробуйте позже!');
					return;
				}
				$reportContent.html(D.data);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				toastr.error("", errorThrown.length ? errorThrown : 'Возникла ошибка, попробуйте повторить операцию позже!');
			}
		});
		return false;
	}

	initMainReport();

	$(document).on('change', 'input[name="report-type"]', function () {
		var $table = $('.js-detail-report'),
			value = $(this).val();
		if (value === 'extended') $table.removeClass('hidden');
		else $table.addClass('hidden');
	});
});

// toggle function
$.fn.clickToggle = function( f1, f2 ) {
	return this.each( function() {
		var clicked = false;
		$(this).bind('click', function() {
			if(clicked) {
				clicked = false;
				return f2.apply(this, arguments);
			}

			clicked = true;
			return f1.apply(this, arguments);
		});
	});
}
