<template>
	<footer id="bottom">
		<FilterMenu />
		<div id="copyright">
			© {{ year }} The Name Files
		</div>
	</footer>
</template>
<style lang="scss" scoped>
	#bottom {
		background: #222;
		top: calc(100% - (30px + 10px));
		box-sizing: content-box;
		height: calc(30px + 1rem);
		position: sticky;
		color: var(--vt-c-white);
	}
	#copyright {
		background: inherit;
		padding: calc(30px + 1rem) 1rem 1rem;
		text-align: center;
	}
</style>
<script setup>
	import FilterMenu from './FilterMenu.vue'
	let date = new Date()
	let year = date.getFullYear()
</script>