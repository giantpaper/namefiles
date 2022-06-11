export default function($){

	let filterTitle = 'Latest %s Names';
	let filterTitleNew;

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
		return this.serializeArray().length <= 4 && this.find('#s').val() === '';
	};
	$.fn.nameCard = function(){
		return this.not('.rendered').each(function(){
			let link = $(this).attr('href');
			let genderRaw = $(this).attr('data-gender');
			let meaning = $(this).attr('data-meaning');
			let pronunciation = $(this).attr('data-pronunciation');
			let title = $(this).text().trim().replace(/^[^ ]+ (.+)/, '$1');
			let gender;
			let editLink = $(this).attr('data-edit');

			let has_pronunciation = pronunciation !== undefined && pronunciation !== '';
			let has_meaning = meaning !== undefined && meaning !== '';
			let has_gender = genderRaw !== undefined && genderRaw !== '';

			if (has_gender) {
				let fm = TNF.terms.gender[ genderRaw ];
				switch (fm.slug) {
					case 'female' :	 gender = 'fa-venus'; break;
					case 'male' :		 gender = 'fa-mars'; break;
					case 'neutral' : gender = 'fa-venus-mars'; break;
				}
			}

			$(this).replaceWith([
				`<div class="name_card rendered">`,
				`	<a href="${link}" class="name-link">`,
				`		<h3 class="name_title">`,
				(has_gender ? `	<i class="fa-regular ${gender}"></i>` : ``),
				`			${title}`,
				`		</h3>`,
				(has_pronunciation ? `	<p class="name_pronunciation">${pronunciation}</p>` : ``),
				(has_meaning ? `	<p class="name_meaning"><strong>Meaning—</strong>${meaning}</p>` : ``),
				`	</a>`,
				`	<a href="${editLink}" class="edit-link">`,
				`		<i class="fa-solid fa-pencil"></i>`,
				`	</a>`,
				`</div>`,
			].join("\n"));
		});
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
			url: `/wp-json/wp/v2/name`,
			data: serialize,
		})
		.done(function(data) {
			data.forEach(name => {
				let gender;

				let editLink = TNF.urls.edit.replace(/%s/, name.id);
				let $link = $('<a class="name_card">');

				$link.text(name.title.rendered);
				$link.attr('href', name.link);
				$link.attr('data-edit', editLink);
				$link.attr('data-gender', name.gender[0]);
				if (name.acf.meaning !== undefined) {
					$link.attr('data-meaning', name.acf.meaning);
				}
				if (name.acf.pronunciation !== undefined) {
					$link.attr('data-pronunciation', name.acf.pronunciation);
				}

				$inner.append('<li>' +$link.outerHTML()+ '</li>');

				setTimeout(() => {
					$('.name_card').nameCard();
				}, 100);
			});

			if ( $form.filterFormEmpty() ) {
				filterTitleNew = filterTitle;
			} else {
				filterTitleNew = `Filtered Results`;
			}

			filterTitleNew = filterTitleNew.replace(/%s/, limit);

			$(this).find('.submit');

			$('#filter_results').html(`<h2 class="h2 text-center">${filterTitleNew}</h2>${$inner.outerHTML()}`);
		});

		if (isNaN(parseInt(e))) {
			$('#filter_btn').trigger('click');
			e.preventDefault();
		}
	};

	$('button#filter_btn')
		.each(filterBtnState)
		.click(filterBtnState);

	$('form#filter_menu fieldset input')
		.each(checkboxState)
		.click(checkboxState);

	$('form#filter_menu')
		.each(getCheckboxValues)
		.submit(getCheckboxValues);


	setTimeout(() => {
		$('.name_card').nameCard();
	}, 100);

	// $(window)
	// 	.on('load', paddingBottom)
	// 	.scroll(paddingBottom)
	// 	.resize(paddingBottom);

}
