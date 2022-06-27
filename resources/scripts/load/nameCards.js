export default function($){

	$.fn.nameCard = function(args){
		return this.not('.rendered').each(function(){
			if (args === undefined) {
				args = {};
			}

			let title = $(this).text().trim().replace(/^[^ ]+ (.+)/, '$1');
				title = title === '' ? args.title : title;
			let link = $(this).attr('href') ?? args.link;
			let dataGender = $(this).attr('data-gender') ?? args.gender;
			let genderRaw = dataGender === undefined ? [] : dataGender.split(',');
			let meaning = $(this).attr('data-meaning') ?? args.meaning;
			let pronunciation = $(this).attr('data-pronunciation') ?? args.pronunciation;
			let editLink = $(this).attr('data-edit') ?? args.edit;
			let gender;

			let has_pronunciation = pronunciation !== undefined && pronunciation !== '';
			let has_meaning = meaning !== undefined && meaning !== '';
			let has_gender = genderRaw.length > 0;

			if (has_gender) {
				let g = [];

				genderRaw.forEach((v, k) => {
					g.push(TNF.terms.gender[ v ].slug);
				});

				switch (g.join(',')) {
					case 'female' :	 			gender = 'fa-venus'; break;
					case 'male' :					gender = 'fa-mars'; break;
					case 'neutral' :			gender = 'fa-neuter'; break;
					case 'female,male' :	gender = 'fa-venus-mars'; break;
				}
			}

			let html = [
				`<div class="name_card rendered">`,
				`	<a href="${link}" class="name-link">`,
				`		<h3 class="name_title">`,
				(has_gender ? `	<i class="fa-regular ${gender}"></i>` : ``),
				`			${title}`,
				`		</h3>`,
				(has_pronunciation ? `	<p class="name_pronunciation">${pronunciation}</p>` : ``),
				(has_meaning ? `	<p class="name_meaning"><strong>Meaning—</strong>${meaning}</p>` : ``),
				`	</a>`,
				`	<a href="${editLink}" class="edit-link">`,
				`		<i class="fa-solid fa-pencil"></i>`,
				`	</a>`,
				`</div>`,
			].join("\n");

			if ( args !== undefined && args !== '' && Object.keys(args).length > 0) {
				$(this).html(html);
			}
			else {
				$(this).replaceWith(html);
			}
		});
	};

}
