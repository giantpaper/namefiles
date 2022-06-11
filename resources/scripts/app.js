import jQuery from 'jquery';
import jqueryUI from './vendor/jquery-ui';

// import getWrunner from './load/wrunner-jquery';

import {domReady} from '@roots/sage/client';

/**
 * app.main
 */
import Router from './util/Router';
//
import common from './routes/common';
import home from './routes/home';
// import showGraph from './routes/showGraph';

window.is_touch_enabled = () => {
	return ( 'ontouchstart' in window ) ||
				 ( navigator.maxTouchPoints > 0 ) ||
				 ( navigator.msMaxTouchPoints > 0 );
}

(function($){
	const main = async (err) => {
		if (err) {
			// handle hmr errors
			console.error(err);
		}

	// import local dependencies
		/** Populate Router instance with DOM routes */
		const routes = new Router({
			// All pages
			common,
			// Home page
			home,
			// showGraph,
		});

		// Load Events
		jQuery(document).ready(() => routes.loadEvents());

		// application code
	};

	/**
	 * Initialize
	 *
	 * @see https://webpack.js.org/api/hot-module-replacement
	 */
	domReady(main);
	import.meta.webpackHot?.accept(main);

})(jQuery);
