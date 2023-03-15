<template>
	<button id="search_btn">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M368 208A160 160 0 1 0 48 208a160 160 0 1 0 320 0zM337.1 371.1C301.7 399.2 256.8 416 208 416C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208c0 48.8-16.8 93.7-44.9 129.1l124 124 17 17L478.1 512l-17-17-124-124z"/></svg>
	</button>
	<form action="#" method="get" id="search_form" class="hidden">
		<input type="search" value="" />
		<button type="submit" class="sr-only">Search</button>
	</form>
</template>
<style lang="scss" scoped>
	svg {
		fill: currentcolor;
		width: 1.5rem;
	}
	#search_form {
		width: 0;
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		transform: width 0.4s;
		&.shown {
			width: 100%;
		}
		input {

		}
	}
</style>
<script setup>
	let search__btn = document.querySelector('#search_btn')

	if (search__btn !== null) {
		search__btn.addEventListener('click', function(){
			let search__form = document.querySelector('#search_form')
			console.log(search__form)
			search__form.classList.remove('hidden')
		})
	}
</script>
