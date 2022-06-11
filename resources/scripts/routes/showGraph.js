import { Chart, ChartConfiguration, LineController, LineElement, PointElement, LinearScale, Title, CategoryScale } from 'chart.js';

import getData from '../load/graph/getData';
import update from '../load/graph/update';
import changeTitle from '../load/graph/changeTitle';

import Graph from '../load/graph';

Chart.register(LineController, LineElement, PointElement, LinearScale, Title, CategoryScale);

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

			let country = 'us';

			const post = TNF.post;
			let slug = post.info.slug;

			const $range = $('.range-wrap');

			const lastYear = $range.parent().find('[data-year="end"]').text();
			const min = $range.parent().find('[data-year="start"]').text();
			const max = lastYear;
			const defaultMinYear = lastYear - config.timespan;
			let startYear = defaultMinYear;
			let endYear = lastYear;

			let mobileValues = {};

			// http://localhost/~giantpaper/~namesdata/json.php?slug=anna&country=us

			const file = TNF.urls.graph + '/' + TNF.endpoints.stats + '&country=' + country + '&slug=' + slug;

			// Chart.defaults.TNF.defaultFontColor = "#2E0E02";

			const $graphControl = $('.graph-controls:not(:hidden)');


			var graph = new Graph;

			let config = graph.config;

// 			$.get(file, function(json){
// 				if ( json.length <= 0 ) {
// 					$('#stats').removeClass('loading').addClass('empty');
// 					return false;
// 				}
// 				let labels = [];
//
// 				Object.keys(json).forEach(name => {
// 					if ( name === 'info')
// 						return false;
//
// 					const years = json[name];
// 					config.CTX.options.title.text = graph.changeTitle(startYear, endYear, name, config.countries[country]);
//
// 					console.log(config.CTX.options.title.text);
// 					update(years, startYear, endYear, country);
//
// 					$('.graph-is-loaded').removeClass('hidden');
// 				});
// 			});

		})(jQuery);
	},
};
