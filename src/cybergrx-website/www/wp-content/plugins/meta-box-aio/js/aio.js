( function ( document ) {
	var data = {
		'mb-admin-columns'                 : ['premium',                    'ui', 'admin'                                   ],
		'mb-comment-meta'                  : [                      'data',                          , 'free'               ],
		'mb-custom-post-type'              : [           'popular', 'data', 'ui', 'admin',           , 'free'               ],
		'mb-custom-table'                  : ['premium',            'data'                                                  ],
		'mb-frontend-submission'           : ['premium', 'popular',         'ui',          'frontend'                       ],
		'mb-relationships'                 : [           'popular', 'data',                          , 'free'               ],
		'mb-rest-api'                      : [                      'data',                          , 'free'               ],
		'mb-revision'                      : ['premium',            'data',       'admin'                                   ],
		'mb-settings-page'                 : ['premium', 'popular', 'data',       'admin'                                   ],
		'mb-term-meta'                     : ['premium', 'popular', 'data'                                                  ],
		'mb-user-meta'                     : ['premium', 'popular', 'data'                                                  ],
		'mb-user-profile'                  : ['premium',            'data', 'ui',          'frontend'                       ],
		'meta-box-beaver-themer-integrator': [                              'ui',          'frontend', 'free', 'integration'],
		'mb-elementor-integrator'          : [                              'ui',          'frontend', 'free', 'integration'],
		'meta-box-facetwp-integrator'      : [                              'ui',          'frontend', 'free', 'integration'],
		'meta-box-builder'                 : ['premium', 'popular',         'ui', 'admin'                                   ],
		'meta-box-columns'                 : ['premium',                    'ui',                                           ],
		'meta-box-conditional-logic'       : ['premium', 'popular',         'ui'                                            ],
		'meta-box-geolocation'             : ['premium',            'data'                                                  ],
		'meta-box-group'                   : ['premium', 'popular', 'data', 'ui'                                            ],
		'meta-box-include-exclude'         : ['premium', 'popular',         'ui'                                            ],
		'meta-box-show-hide'               : ['premium',                    'ui'                                            ],
		'meta-box-tabs'                    : ['premium',                    'ui'                                            ],
		'meta-box-template'                : ['premium',            'data', 'ui', 'admin'                                   ],
		'meta-box-text-limiter'            : [                              'ui',                    , 'free'               ],
		'meta-box-tooltip'                 : ['premium',                    'ui'                                            ],
		'meta-box-updater'                 : ['premium',                          'admin'                                   ],
		'meta-box-yoast-seo'               : [                                    'admin',           , 'free', 'integration'],
	};
	var items = Array.prototype.slice.call( document.querySelectorAll( '.extension-list li' ) ),
		filters = document.querySelector( '.filters' );

	function show( item ) {
		item.classList.remove( 'hidden' );
	}

	function hide( item ) {
		item.classList.add( 'hidden' );
	}

	function filter( event ) {
		event.preventDefault();
		items.map( show );

		var filter = event.target.dataset.filter;
		if ( ! filter ) {
			return;
		}
		items.filter( function( item ) {
			var extension = item.querySelector( 'input' ).value;

			return ! data.hasOwnProperty( extension ) || -1 === data[extension].indexOf( filter );
		} ).map( hide );
	}

	filters.addEventListener( 'click', filter, false );
} )( document );
