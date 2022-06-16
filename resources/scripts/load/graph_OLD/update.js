
import config from './config';
import getData from './getData';
import $ from 'jquery';
import changeTitle from './changeTitle';

export default function update (years, startYear, endYear, country) {
	const raw = getData(years, startYear, endYear);
	let data = raw.data;
	let byGender = data.gender;
	config.data.datasets = [];

	let misc = raw.misc;

	$('#stats')
		.removeClass('loading')
		.find('.loader').hide();

	// fill in stats
	if ( misc.earliest.f !== undefined && misc.earliest.f.num > 0 ) {
		$('[data-id="earliest-f-num"]').text(misc.earliest.f.num);
		$('[data-id="earliest-f-year"]').text(misc.earliest.f.year);
	}
	else {
		$('[data-id="earliest-f-num"],[data-id="earliest-f-year"]').parent().hide();
	}
	if ( misc.earliest.m !== undefined && misc.earliest.m.num > 0 ) {
		$('[data-id="earliest-m-num"]').text(misc.earliest.m.num);
		$('[data-id="earliest-m-year"]').text(misc.earliest.m.year);
	}
	else {
		$('[data-id="earliest-m-num"],[data-id="earliest-m-year"]').parent().hide();
	}

	if ( misc.peak.f !== undefined ) {
		$('[data-id="peak-f-num"]').text(misc.peak.f.num);
		$('[data-id="peak-f-year"]').text(misc.peak.f.year);
	}
	else {
		$('[data-id="peak-f-num"],[data-id="peak-f-year"]').parent().hide();
	}
	if ( misc.peak.m !== undefined ) {
		$('[data-id="peak-m-num"]').text(misc.peak.m.num);
		$('[data-id="peak-m-year"]').text(misc.peak.m.year);
	}
	else {
		$('[data-id="peak-m-num"],[data-id="peak-m-year"]').parent().hide();
	}
	// end stats

	Object.keys( byGender ).forEach(k => {
		// let array = $.extend(data.gender[k], config.datasets[k]);

		console.log('test', k);
		config.CTX.data.datasets[k].data = byGender[k];
		// myLine.data.datasets.push(config.data.datasets[k]);
		config.CTX.options.title.text = changeTitle(startYear, endYear, name, config.countries[country]);
	});

	config.data.labels = data.labels;
	myLine.update();
};
