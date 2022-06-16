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

			graph.getData({
				start: $('#mobileMinYear').val(),
				end: $('#mobileMaxYear').val(),
			}, function(thisGraph){
				$('[data-year="start"]').text(thisGraph.firstYear);
				$('[data-year="end"]').text(thisGraph.lastYear);

				$('#mobileMinYear').val(thisGraph.firstYear).attr('min', thisGraph.firstYear).attr('max', thisGraph.lastYear);
				$('#mobileMaxYear').val(thisGraph.lastYear).attr('min', thisGraph.firstYear).attr('max', thisGraph.lastYear);

				$range.slider({
					range: true,
					min: Number(parseInt( thisGraph.firstYear )),
					max: Number(parseInt( thisGraph.lastYear )),
					values: [ $range.attr('data-min'), $range.attr('data-max') ],
					change: function( event, ui ) {
						let start = ui.values[0];
						let end = ui.values[1];
						$('#refineGraph h4 span').text(` — From ${start} to ${end}`);
						// ui = {
						// 	values: []	-- 2 values
						// }
						graph.getData({
							start: start,
							end: end,
						});
						// $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
					}
				});
			});

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
