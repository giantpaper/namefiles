import config from './config';
import changeTitle from './changeTitle';

// format data function
export default function getData (years, startYear, endYear) {
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
};
