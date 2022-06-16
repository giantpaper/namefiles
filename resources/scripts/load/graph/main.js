import { Chart, ChartConfiguration, LineController, LineElement, PointElement, LinearScale, Title, CategoryScale, Tooltip, SubTitle, Legend } from 'chart.js';

Chart.register(LineController, LineElement, PointElement, LinearScale, Title, CategoryScale, Tooltip, SubTitle, Legend);

import config from './config';

const changeTitle = function(startYear, endYear, name, country) {
	return `Usage of ${name} as a Given Name`;
}
const changeSubtitle = function(startYear, endYear, name, country) {
	return `From ${startYear} to ${endYear} | ${config.countries[country]}`;
}

export default class Graph {
	constructor(ctx) {
		if ( !ctx )
			return false;

		let graph = document.getElementById(ctx).getContext('2d');
		this.graph = new Chart(graph, config.CTX);
		this.firstYear;
		this.lastYear;
	}
	getData(args, callback) {
		args = args ?? {};
		let post = TNF.post;
		let slug = post.info.slug;
		let graph = this.graph;
		const file = TNF.urls.graph + '/' + TNF.endpoints.stats + '&country=' + config.country + '&slug=' + slug;

		$.get(file, function(json){
			if ( json.length <= 0 ) {
				$('#stats').removeClass('loading').addClass('empty');
				return false;
			}

			let $range = config.rangeElement;
			const lastYear = $range.parent().find('[data-year="end"]').text();
			const min = $range.parent().find('[data-year="start"]').text();
			const max = lastYear;
			const defaultMinYear = lastYear - config.timespan;
			let startYear = args.start ?? defaultMinYear;
			let endYear = args.end ?? lastYear;
			const years = json[name];

			let peakYears = {
				years: [],
				num: [],
			};

			Object.keys(json).forEach(name => {
				if ( name === 'info')
					return false;

				let list = json[name];
				let dataset = {};

				config.CTX.data.labels = [];
				config.CTX.data.datasets = [];

				Object.keys(list).forEach(year => {

					if ( startYear <= year && year <= endYear ) {
						let byGender = list[year];
						config.CTX.data.labels.push(year);

						Object.keys(config.datasets).forEach(gender => {
							let stat = byGender[gender];

							if (byGender[gender] === undefined) {
								stat = 0;
							}
							if (dataset[gender] === undefined) {
								dataset[gender] = [];
							}
							dataset[gender].push(stat);
							// Fill in stats
							// - Earliest occurrance
							if ($(`[data-id="earliest-${gender}-num"]`).text() === '' && stat > 0) {
								$(`[data-id="earliest-${gender}-year"]`).text(year);
								$(`[data-id="earliest-${gender}-num"]`).text(parseInt(stat).toLocaleString('en'));
							}
							// - Peak years
							// 	 - for males
							if (peakYears.years[gender] === undefined) {
								peakYears[gender] = 0;
							}
							if (peakYears.num[gender] === undefined) {
								peakYears.num[gender] = 0;
							}
							if (peakYears.num[gender] < stat) {
								peakYears.years[gender] = year;
								peakYears.num[gender] = stat;
							}
						});
					}
				});

				Object.keys(config.datasets).forEach(gender => {
					let datasettings = config.datasets[gender];
					config.CTX.data.datasets.push({
						label: datasettings.label,
						data: dataset[gender],
						borderColor: datasettings.borderColor,
						backgroundColor: datasettings.backgroundColor,
					});

					$(`[data-id="peak-${gender}-year"]`).text(peakYears.years[gender]);
					$(`[data-id="peak-${gender}-num"]`).text(parseInt(peakYears.num[gender]).toLocaleString('en'));

					$(`[data-id="peak-${gender}-num"]`).each(function(){
						if ($(this).text() === '' || $(this).text() <= 0) {
							$(this).parent().hide();
							$(this).closest('dl').find(`.peak-${gender}`).hide();
						}
					});
					$(`[data-id="earliest-${gender}-num"]`).each(function(){
						if ($(this).text() === '' || $(this).text() <= 0) {
							$(this).parent().hide();
							$(this).closest('dl').find(`.earliest-${gender}`).hide();
						}
					});
				});

				let yearList = config.CTX.data.labels;
				this.firstYear = yearList[0];
				this.lastYear = yearList[yearList.length - 1];

				config.CTX.options.plugins.title.text = changeTitle(startYear, endYear, name, config.country);
				config.CTX.options.plugins.subtitle.text = changeSubtitle(startYear, endYear, name, config.country);
			});

			graph.update();

			$('.graph-is-loaded').removeClass('hidden');

			if (typeof callback === 'function') {
				callback(this);
			}
		});
	}
}
