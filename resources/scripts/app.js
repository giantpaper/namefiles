import jqueryUI from './vendor/jquery-ui';
import {domReady} from '@roots/sage/client';

/**
 * app.main
 */
import Router from './util/Router';
import common from './routes/common';

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
