let internal = {
	axisLabels: {
		x: 'By Year',
		y: '# of Births',
	},
};

const $range = $('.range-wrap');

export default {
	timespan: 100,
	rangeElement: $range,
	lastYear: $range.parent().find('[data-year="end"]').text(),
	min: $range.parent().find('[data-year="start"]').text(),
	max: this.lastYear,
	defaultMinYear: this.lastYear - this.timespan,
	startYear: this.defaultMinYear,
	endYear: this.lastYear,
	countries: {
		br: 'Brazil',
		ca: 'Canada',
		nz: 'New Zealand',
		uk: 'United Kingdom',
		us: 'United States',
	},
	datasets: {
		f: {
			label: 'As a feminine name',
			borderColor: 'rgb(255, 99, 132)',
			backgroundColor: 'rgb(255, 99, 132)',
			fill: false,
		},
		m: {
			label: 'As a masculine name',
			borderColor: 'rgb(54, 162, 235)',
			backgroundColor: 'rgb(54, 162, 235)',
			fill: false,
		},
	},
	// data: {
	// 	labels: [],
	// 	datasets: [],
	// },
	peak: {},
	earliest: {},
	CTX: {
		type: 'line',
		// data: {
		// 	labels: [],
		// 	datasets: [],
		// },
		data: {
			labels: [],
			datasets: [
				{
					label: 'My First Dataset',
					data: [0, 1],
					fill: false,
					borderColor: 'rgb(75, 192, 192)',
					tension: 0.2
				},
			],
		},
		options: {
			responsive: true,
			maintainAspectRatio: true,
			title: {
				display: true,
				text: 'Loading.',
			},
			tooltips: {
				mode: 'index',
				intersect: false,
			},
			hover: {
				mode: 'nearest',
				intersect: true
			},
			// scales: {
			// 	x: [{
			// 		display: true,
			// 		scaleLabel: {
			// 			display: true,
			// 			text: internal.axisLabels.x,
			// 		},
			// 	}],
			// 	y: [{
			// 		display: true,
			// 		scaleLabel: {
			// 			display: true,
			// 			text: internal.axisLabels.y,
			// 		},
			// 	}]
			// }
		},
	},
};
