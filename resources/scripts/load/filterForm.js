import nameCards from '../load/nameCards';

import miscFunctions from '../load/misc';

export default function($) {
	let filterTitle = 'Latest %s Names';
	let filterTitleNew;

	nameCards($);
	miscFunctions($);

	$.fn.appendCallback = function(replace, callback){
		var ret = $.fn.append.call(this, replace); // Call replaceWith
		if(typeof callback === 'function'){
			 callback.call(ret); // Call your callback
		 }
		return ret;  // For chaining
	};
	let getCheckboxValuesSimple = function(){
		let $input = $(this);
		let $fieldset = $input.closest('fieldset');
		let $label = $input.closest('label');
		let $labels = $fieldset.find('label');
		let $field = $label.find('.field');

		if ($field.hasClass('radio')) {
			$labels.removeClass('checked');
		}
		if ($input.is(':checked') || $input.prop('checked')) {
			$label.addClass('checked');
		}
	};

	let paddingBottom = function() {
		// Footer
		let windowH = $(window).height();
		let appHeight = Math.round($('#app').outerHeight());
		let $filterMenuWrapper = $('#filter_menu_wrapper');
		let filterMenuWrapperH = $filterMenuWrapper.outerHeight();
		let filterMenuWrapperOffset = $filterMenuWrapper.offset().top;
		let paddingBottom = filterMenuWrapperH;

		// if scrolled to the very bottom
		if ( $(window).innerHeight() + $(window).scrollTop() >= appHeight ) {
			paddingBottom = $('footer.content-info').outerHeight() + paddingBottom;
		}

		$('#filter_menu.show').css('height', appHeight < windowH
		? filterMenuWrapperOffset
		: windowH - paddingBottom
		);

		// $('main#main').css('padding-bottom', footerH);
	};

	let filterBtnState = function(e){
		if ( $(this).hasClass('clicked') ) {
			$(this).removeClass('clicked');
			$('#filter_menu')
				.removeClass('show')
				.addClass('hide');
			$('body')
				.removeClass('show_menu')
				.addClass('hide_menu');
		}
		else {
			if (isNaN(parseInt(e))) {
				$(this).addClass('clicked');
				$('#filter_menu')
					.removeClass('hide')
					.addClass('show');
				$('body')
					.removeClass('hide_menu')
					.addClass('show_menu');
				paddingBottom();
			}
		}
	};
	$.fn.filterFormEmpty = function () {
		return this.serializeArray().length <= 3;
	};
	let checkboxState = function () {
		let $t = $(this);
		let $label = $t.closest('label');
		let $form = $t.closest('form');
		let serialize = $form.serializeArray();

		$form.find('[type="submit"]').text(function(){
			if ( $form.filterFormEmpty() ) {
				return 'Reset';
			} else {
				return 'Filter';
			}
		});

		if ($t.is(':checked')) {
			$label.addClass('checked');
		}
		else {
			$label.removeClass('checked');
		}
	};

	let getCheckboxValues = function(e){
		let $form = $(this);
		let serialize = $form.serializeArray();
		let $inner = $('<ul class="name_cards">');
		let limit;

		let is_empty = serialize.length <= 4 && $(this).find('#s').val() === '';

		serialize.forEach(item => {
			if (item.name === 'per_page') {
				limit = item.value;
			}
		});

		$.ajax({
			url: `/wp-json/wp/v2/tnf_name`,
			data: serialize,
		})
		.done(function(data) {
			let count = data.length;

			data.forEach(name => {
				let gender;

				let editLink = TNF.urls.edit !== null ? TNF.urls.edit.replace(/%s/, name.id) : null;

				let $li = new $('<li>');

				let args = {
					title: name.title.rendered,
					edit: editLink,
					link: name.link,
				};

				if (name.gender.join(',') !== undefined && name.gender.join(',') !== '') {
					args.gender = name.gender.join(',');
				}
				if (name.acf.meaning !== undefined) {
					args.meaning = name.acf.meaning;
				}
				if (name.acf.pronunciation !== undefined) {
					args.pronunciation = name.acf.pronunciation;
				}
				$li.nameCard(args);

				$inner.append($li.outerHTML());
			});

			filterTitleNew = ( $form.filterFormEmpty() ? filterTitle : `Filtered Results (${count})` ).replace(/%s/, limit);

			if (e.type === 'submit') {
				history.pushState({}, '', TNF.urls.home);
				$('main#main').html('<div id="filter_results">');
			}

			$('#filter_results').html(`<h2 class="h2 text-center">${filterTitleNew}</h2>${$inner.outerHTML()}`);
		});

		if (isNaN(parseInt(e))) {
			$('#filter_btn').trigger('click');
			e.preventDefault();
		}
	};

	$('form#filter_menu :input')
		.each(getCheckboxValuesSimple)
		.change(getCheckboxValuesSimple);

	$('button#filter_btn')
		.each(filterBtnState)
		.click(filterBtnState);

	$('form#filter_menu fieldset input')
		.each(checkboxState)
		.click(checkboxState);

	$('form#filter_menu')
		.each(getCheckboxValues)
		.submit(getCheckboxValues);

};
