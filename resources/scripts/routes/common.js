import jQuery from 'jquery';

import nameCards from '../load/nameCards';

/*global TNF;*/

export default {
  init() {
		(function($){
		// JavaScript to be fired on the home page

		})(jQuery);
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
		(function($){
			// adjust main#main padding-bottom
			nameCards($);

			$.fn.outerHTML = function(s) {
				return s ? this.before(s).remove() : $("<p>").append(this.eq(0).clone()).html();
			};

			let getCheckboxValues = function(){
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

			$('form#filter_menu :input')
				.each(getCheckboxValues)
				.change(getCheckboxValues);

			document.querySelectorAll('h1,h2,h3,h4,h5,h6').forEach(tag => {
				let classes = Array.from(tag.classList);
				let name = tag.tagName.toLowerCase();

				if (classes.join(' ').match(/( |^)h[0-6]( |$)/) === null) {
					classes.push(name);

					tag.classList = [...new Set(classes)].join(' ');
				}
			});

		})(jQuery);
  },
};
