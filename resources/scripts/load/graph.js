import config from './graph/config';
import changeTitle from './graph/changeTitle';
import getData from './graph/getData';
import update from './graph/update';

class Graph {
	constructor(ctx) {
		if ( !ctx )
			return false;
		
		this.myLine = new Chart(ctx, config.CTX);
	}
	changeTitle (startYear, endYear, name, country) {
		return `Usage of ${name} as a Given Name From ${startYear} to ${endYear} | ${country}`;
	}
	getData (years, startYear, endYear) {
		let data = {
			labels: [],
			gender: {
				f: {},
				m: {},
			},
		};
		let d = {
			f: [],
			m: [],
		};
	
		// get earliest year and peak year
		Object.keys(years).forEach(yearLabel => {
			let year = yearLabel.replace('YEAR_', '');
			let genders = years[yearLabel];
	
			if (config.earliest.f === undefined && genders.female !== undefined) {
				config.earliest.f = {
					year: year,
					num: genders.female,
				};
			}
			if (config.earliest.m === undefined && genders.male !== undefined) {
				config.earliest.m = {
					year: year,
					num: genders.male,
				};
			}
	
			if ((config.peak.f === undefined && genders.female !== undefined) || (config.peak.f && config.peak.f.num < genders.female)) {
				config.peak.f = {
					year: year,
					num: genders.female,
				}
			}
			if ((config.peak.m === undefined && genders.male !== undefined) || (config.peak.m && config.peak.m.num < genders.male)) {
				config.peak.m = {
					year: year,
					num: genders.male,
				}
			}
	
			if ( startYear <= year && year <= endYear ) {
				data.labels.push( year );	// Add year labels
	
				d.f.push(genders.female);	// female names
				d.m.push(genders.male);	// male names
			}
		});
		data.gender.f.data = d.f;
		data.gender.m.data = d.m;
	
		return {
			data: data,
			misc: {
				peak: config.peak,
				earliest: config.earliest,
			}
		};
	}
	update (years, startYear, endYear, country) {
		const raw = getData(years, startYear, endYear);
		let data = raw.data;
		let byGender = data.gender;
		config.data.datasets = [];
	
		let misc = raw.misc;
	
		console.log(config.CTX.options.title.text);
	
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
	
		console.log('test', raw);
		config.data.labels = data.labels;
		myLine.update();
	}
};

export default Graph;