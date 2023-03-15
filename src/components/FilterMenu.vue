<template>
	<div id="filter_menu_wrapper" class="hidden">
		<form id="filter_menu" class="hidden">
			<ul>
				<li></li>
			</ul>
		</form>
		<button id="filter_btn">
			<i>Filter</i>
		</button>
	</div>
</template>
<style lang="scss" scoped>
	#filter_menu {
		background: transparentize(white,0.15);
		bottom: 0;
		bottom: 100%;
		color: #555;
		display: flex;
		backdrop-filter: blur(10px);
		flex-direction: column;
		height: calc(30px + 1rem);
		left: 0;
		overflow: hidden;
		position: absolute;
		right: 0;
		transition: height .2s;
		will-change: transform;
	}
	button {
		&#filter_btn {
			aspect-ratio: 1/1;
			background: #fff;
			border-radius: 10px;
			box-shadow: 0 5px 10px rgba(0,0,0,.15);
			display: block;
			left: 50%;
			margin: -30px 0 0 -30px;
			position: absolute;
			width: 60px;
			z-index: 10;
			i,
			&:after,
			&:before {
				background: #747474;
				border-radius: 10px;
				content: "";
				display: block;
				height: 4px;
				left: 50%;
				position: absolute;
				transform: translate(-50%,-50%);
				transition: transform .2s,width .2s;
			}
			&:before {
				top: calc(50% - 10px);
				width: 28px;
			}
			i {
				overflow: hidden;
				text-indent: -1000px;
				top: 50%;
				width: 20px;
			}
			&:after {
				top: calc(50% + 10px);
				width: 8px;
			}
			&.clicked {
				&:before {
					transform: translate(-50%,10px) rotate(45deg);
				}
				i {
					opacity: 0;
					width: 0;
				}
				&:after {
					transform: translate(-50%,-10px) rotate(-45deg);
					width: 28px;
				}
			}
		}
	}
</style>
<script setup>
import WP from '../assets/_wordpress'

(async function(){
	const paddingBottom = () => {
		let app = document.querySelector('#app')
		let footer = document.querySelector('#bottom')
		let filterBtn = document.querySelector('#filter_btn')
		// Footer
		let window__height = window.outerHeight
		let app__height = Math.round(app.offsetHeight)
		let filterMenuWrapper = document.querySelector('#filter_menu_wrapper')
		let filterMenuWrapper__height = filterMenuWrapper.offsetHeight
		let filterMenuWrapper__offset = footer.offsetTop
		let paddingBottom = filterMenuWrapper__height

		// if scrolled to the very bottom
		if ( window.innerHeight + window.scrollY >= app__height ) {
			paddingBottom = document.querySelector('#copyright').offsetHeight + paddingBottom;
		}

		let filterMenu__height = app__height < window__height ? filterMenuWrapper__offset : window__height - paddingBottom

		document.querySelector('#filter_menu:not(.hide)').setAttribute('style', `height: ${filterMenu__height}px`)
	};

	let wordpress = new WP

	let json = await wordpress.json({
		order: 'desc',
		perPage: 20,
	})

	let run = function(e){
		let event = 'click'
		if (e === undefined) {
			event = 'load'
		}
		let filterBtn = document.querySelector('#filter_btn')
		let filterMenu = document.querySelector('#filter_menu')
		let body = document.querySelector('body')
		let target = event === 'load' ? filterBtn : e.target

		let filterBtn__clicked = target.id === 'filter_btn'
		let filterBtnInner__clicked = !filterBtn__clicked && (target.closest('#filter_btn') !== null && target.closest('#filter_btn').id === 'filter_btn')

		if ( filterBtn__clicked || filterBtnInner__clicked ) {
			switch(target.classList.contains('clicked')) {
				case true:
					filterBtn.classList.remove('clicked')
					filterMenu.classList.add('hide')
					body.classList.add('hide_menu')
					document.querySelector('#filter_menu').setAttribute('style', ``)
					break
				case false:
				default:
					filterBtn.classList.add('clicked')
					filterMenu.classList.remove('hide')
					body.classList.remove('hide_menu')
					paddingBottom()
					console.log(json)
					break
			}
		}
	}

	document.addEventListener('click', run)
	document.querySelector('#filter_menu_wrapper').classList.remove('hidden')
})()
</script>
