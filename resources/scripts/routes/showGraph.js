import jQuery from 'jquery';
import Graph from '../load/graph/main';
import 'tw-elements';

import { slider } from 'jquery-ui-bundle';

export default {
	init() {
		// JavaScript to be fired on the home page
	},
	finalize() {
		// JavaScript to be fired on the home page, after the init JS
		(function($){
			if (!TNF.nameData) {
				return false;
			}

			var graph = new Graph('graph');

			if (graph !== undefined) {
				graph.getData({
					start: $('#mobileMinYear').val(),
					end: $('#mobileMaxYear').val(),
				}, function(thisGraph){
					$('[data-year="start"]').text( thisGraph.firstYear );
					$('[data-year="end"]').text( thisGraph.lastYear );

					$range.slider({
						range: true,
						min: Number(parseInt( thisGraph.firstYear )),
						max: Number(parseInt( thisGraph.lastYear )),
						values: [ thisGraph.startYear, thisGraph.lastYear ],
						create: function( event, ui ) {
							let start = $('#mobileMinYear').val();
							let end = $('#mobileMaxYear').val();
							$('#refineGraph h4 span').text(` — From ${start} to ${end}`);
						},
						slide: function( event, ui ) {
							let start = ui.values[0];
							let end = ui.values[1];
							$('#refineGraph h4 span').text(` — From ${start} to ${end}`);
						},
						change: function( event, ui ) {
							let start = ui.values[0];
							let end = ui.values[1];
							// ui = {
							// 	values: []	-- 2 values
							// }
							$('#stats').addClass('loading');
							graph.getData({
								start: start,
								end: end,
							});
							// $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
						},
					});

				});
			}

			$('.graph-is-loaded').removeClass('hidden');

			$('#stats')
				.removeClass('loading')
				.find('.loader').hide();

			let $range = $( ".range-wrap" );

			$('#mobileMinYear, #mobileMaxYear').on('change', function(){
				graph.getData({
					start: $('#mobileMinYear').val(),
					end: $('#mobileMaxYear').val(),
				});
			});

		})(jQuery);
	}
}
