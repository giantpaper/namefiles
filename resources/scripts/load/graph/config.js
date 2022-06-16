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
	country: 'us',
	countries: {
		br: 'Brazil',
		ca: 'Canada',
		nz: 'New Zealand',
		uk: 'United Kingdom',
		us: 'United States',
	},
	datasets: {
		female: {
			label: 'As a feminine name',
			borderColor: 'rgb(255, 99, 132)',
			backgroundColor: 'rgb(255, 99, 132)',
			fill: false,
		},
		male: {
			label: 'As a masculine name',
			borderColor: 'rgb(54, 162, 235)',
			backgroundColor: 'rgb(54, 162, 235)',
			fill: false,
		},
	},
	peak: {},
	earliest: {},
	CTX: {
		type: 'line',
		data: {
			// x axis
			labels: [],
			datasets: []
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				title: {
					display: true,
					text: 'Loading...',
				},
				subtitle: {
					display: true,
					text: 'Loading...',
				},
				tooltips: {
					mode: 'index',
					intersect: false,
					enabled: true,
				},
				legend: {
					display: true,
					labels: {
						padding: 20,
					}
				}
			},
			hover: {
				mode: 'nearest',
				intersect: true,
			},
			scales: {
				x: {
					display: true,
					title: {
						display: true,
						text: internal.axisLabels.x,
					},
				},
				y: {
					display: true,
					title: {
						display: true,
						text: internal.axisLabels.y,
					},
				}
			}
		},
	},
};
