<?php

defined('ABSPATH') or die("Jog on!");


/**
 * Get data from get_bloginfo()
 *
 * Class SV_SC_SITE_TITLE
 */
class SV_SC_BLOG_INFO extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		$key = ( false === empty( $args['_sh_cd_func'] ) ) ? $args['_sh_cd_func'] : 'name';

		return get_bloginfo( $key );
	}
}

/**
 * Get data from $_SERVER
 *
 * Class SV_SC_SERVER_INFO
 */
class SV_SC_SERVER_INFO extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		return ( false === empty( $_SERVER[ $args['field'] ] ) ) ? $_SERVER[ $args['field'] ] : '';
	}
}

/**
 * Get a unique ID
 *
 * Class SV_SC_UNIQUE_ID
 */
class SV_SC_UNIQUE_ID extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		$prefix = ( false === empty( $args['prefix'] ) ) ? $args['prefix'] : '';

		return uniqid ( $prefix, true );
	}
}

/**
 * Get timestamp
 *
 * Class SV_SC_TIMESTAMP
 */
class SV_SC_TIMESTAMP extends SV_Preset {

	protected function unsanitised() {
		return time();
	}
}

/**
 * Display PHP INFO
 *
 * Class SV_SC_PHP_INFO
 */
class SV_SC_PHP_INFO extends SV_Preset {

	protected function unsanitised() {
		return phpinfo();
	}
}

/**
 * Current URL
 *
 * Class SV_SC_CURRENT_URL
 */
class SV_SC_CURRENT_URL extends SV_Preset {

	protected function unsanitised() {

		$protocol = (
			( isset($_SERVER['HTTPS'] ) && 'on' == $_SERVER['HTTPS'] ) ||
			( isset($_SERVER['SERVER_PORT'] ) && 443 == $_SERVER['SERVER_PORT'] )
		) ? 'https://' : 'http://';

		return $protocol . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
	}
}

/**
 * Register URL
 *
 * Class SV_SC_REGISTER_URL
 */
class SV_SC_REGISTER_URL extends SV_Preset {

	protected function unsanitised() {
		return wp_registration_url();
	}
}

/**
 * Random number
 *
 * Class SV_SC_RAND_NUMBER
 */
class SV_SC_RAND_NUMBER extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		$min = ( false === empty( $args['min'] ) ) ? (int) $args['min'] : 0;

		$max = ( false === empty( $args['max'] ) ) ? (int) $args['max'] : getrandmax();

		return rand( $min, $max );
	}
}

/**
 * Avatar URL
 *
 * Class SV_SC_AVATAR
 */
class SV_SC_AVATAR extends SV_Preset {

	public function init() {

		$this->escape_method = false;
	}

	protected function unsanitised() {

		$args 		= $this->get_arguments();
		$user_id 	= get_current_user_id();

//		if ( true === empty( $user_id ) ) {
//			return '';
//		}

		$width 			= ( false === empty( $args['width'] ) ) ? (int) $args['width'] : 96;
		$profile_url 	= get_avatar_url( $user_id, [ 'size' => $width ] );

		if ( true === empty( $profile_url ) ){
			return '';
		}

		return sprintf( '<img src="%1$s" />', esc_url( $profile_url ) );
	}
}

/**
 * Random string
 *
 * Based upon: https://stackoverflow.com/questions/4356289/php-random-string-generator
 *
 * Class SV_SC_RAND_STRING
 */
class SV_SC_RAND_STRING extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		$length = ( false === empty( $args['length'] ) ) ? (int) $args['length'] : 10;

		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$no_characters = strlen( $characters );
		$random_string = '';

		for ($i = 0; $i < $length; $i++) {
			$random_string .= $characters[ rand( 0, $no_characters - 1 ) ];
		}

		return $random_string;
	}
}

/**
 * Fetch an item from the $_POST array
 *
 * Class SV_SC_POST_VALUE
 */
class SV_SC_POST_VALUE extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		$post_value = ( false === empty( $_POST[ $args['key'] ] ) ) ? $_POST[ $args['key'] ] : NULL;

		if ( null !== $post_value ) {
			return $post_value;
		}

		// Do we have a fall back default?
		return ( false === empty( $args['default'] ) ) ? $args['default'] : '';

	}
}

/**
 * Fetch an item from the $_GET array
 *
 * Class SV_SC_GET_VALUE
 */
class SV_SC_GET_VALUE extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		$post_value = ( false === empty( $_GET[ $args['key'] ] ) ) ? $_GET[ $args['key'] ] : NULL;

		if ( null !== $post_value ) {
			return $post_value;
		}

		// Do we have a fall back default?
		return ( false === empty( $args['default'] ) ) ? $args['default'] : '';

	}
}

/**
 * Display current Post ID
 *
 * Class SV_SC_POST_ID
 */
class SV_SC_POST_ID extends SV_Preset {

	protected function unsanitised() {
		return get_the_ID();
	}
}

/**
 * Display author of current post
 *
 * Class SV_SC_POST_AUTHOR
 */
class SV_SC_POST_AUTHOR extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		switch ( $args['field'] ) {
			case 'id':
					return get_the_author_meta( 'ID' );
				break;
			default:
				return get_the_author();
		}
	}
}

/**
 * Display post counts
 *
 * Class SV_SC_POST_COUNTS
 */
class SV_SC_POST_COUNTS extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		$counts = wp_count_posts();

		switch ( $args['status'] ) {
			case 'future':
					return $counts->future;
				break;
			case 'draft':
				return $counts->draft;
				break;
			case 'pending':
				return $counts->pending;
				break;
			case 'private':
				return $counts->private;
				break;
			default:
				return $counts->publish;
		}
	}
}

/**
 * Get a User counts
 *
 * Class SV_SC_USER_COUNTS
 */
class SV_SC_USER_COUNTS extends SV_Preset {

    protected function unsanitised() {

        $args = $this->get_arguments();

        $role = ( false === empty( $args['role'] ) ) ? $args['role'] : NULL;

        $users = count_users();

        if ( false === empty( $role ) && true === isset( $users['avail_roles'][ $role ] ) ) {
            return $users['avail_roles'][ $role ];
        } if ( true === isset( $users['total_users'] ) ) {
            return $users['total_users'];
        }

        return '';
    }
}

/**
 * Display a date and also support date arithmetic
 *
 * Class SV_SC_DATE
 */
class SV_SC_DATE extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		$todays_date = date_create();

		// Do we have an interval?
		if ( false === empty( $args['interval'] ) ) {

			$interval = date_interval_create_from_date_string( $args['interval'] );

			if ( $interval !== false ) {
				$todays_date = date_add( $todays_date, $interval );
			}

		}

		$date_format = ( false === empty( $args['format'] ) ) ? $args['format'] : 'd/m/Y';

		return date_format( $todays_date, $date_format );
	}
}

/**
 * Fetch a column from a MySQL database by ID
 *
 * Min example:
 *
 * [sv slug="sc-db-value-by-id" table="users" column="user_login" column-to-search="id" key="3"]
 *
 * Full example:
 *
 * [sv slug="sc-db-value-by-id" table="wp_users" column="user_login" column-to-search="id" key="3" key-format="%d" message-not-found="User not found" cache=false cache-duration=3600 ]
 * 
 * Another example is to fetch the key we're searching for from the query string:
 * 
 * e.g. https://[url]/?user-id=3
 *
 * [sv slug="sc-db-value-by-id" table="wp_users" column="user_login" column-to-search="id" key-query-string="user-id" key-format="%d" message-not-found="User not found" cache=false cache-duration=3600 ]
 * 
 * SC_DB_VALUE_BY_ID
 */
class SV_SC_DB_VALUE_BY_ID extends SV_Preset {

	protected function unsanitised() {

		$args = wp_parse_args( $this->get_arguments(), [ 'key-format' => '%d', 'key-query-string' => NULL, 'message-not-found' => '', 'cache' => true, 'cache-duration' => 1 * HOUR_IN_SECONDS ] );

		if ( $validation_error = $this->validate_arguments( $args ) ) {
			return $validation_error;
		}

		$cache_key = md5( print_r( $args, true ) );

		if( true === sh_cd_to_bool( $args[ 'cache'] )
		        && $cache = sh_cd_cache_get( $cache_key ) ) {
			return $cache;
		}

		global $wpdb;

		// Load key to look for from querystring?
		$key = ( false === empty( $args['key-query-string'] ) ) ?
					$_GET[ $args['key-query-string'] ] : $args['key'];

		$sql = sprintf( 'Select %s from %s where %s = %s',
								$args['column'],
								$args['table'],
								$args['column-to-search'],
								$args['key-format']
		);

		$sql    = $wpdb->prepare( $sql, $key );
		$value  = $wpdb->get_var( $sql );

		if ( true === empty( $value )) {
			$value = $args['message-not-found'] ;
		}

		sh_cd_cache_set( $cache_key, $value, (int) $args[ 'cache-duration'] );

		return $value;
	}

	protected function validate_arguments( $args = [] ) {

        if ( false === sh_cd_is_shortcode_db_value_by_id_enabled() ) {
            return 'This shortcode has been disabled by admin. See "WP Admin" > "Snippet Shortcodes" > "Settings" to enable.';
        }

		if ( true === empty( $args['table'] ) ) {
			return 'No MySQL table specified (i.e. "table" argument is missing).';
		}

		if ( true === empty( $args['column'] ) ) {
			return 'No MySQL column specified (i.e. "column" argument is missing).';
		}

		if ( true === empty( $args['column-to-search'] ) ) {
			return 'The MySQL column to search for given key has not been specified (i.e. "column-to-search" argument is missing).';
		}

		if ( false === empty( $args['key-query-string'] ) ) {
			if( true === empty( $_GET[ $args['key-query-string'] ] ) ) {
				return sprintf('A querystring key ( "%1$s" ) has been specified but no value was been passed within the URL? (e.g. https://[website-address]/?%1$s=some-value).', esc_html( $args['key-query-string'] ) );
			}
		} elseif ( true === empty( $args['key'] ) ) {
			return 'No key has been specified (i.e. the "key" and "key-query-string" arguments are both missing).';
		}

		if ( true === empty( $args['key-format'] ) ) {
			return 'No key format has been specified (i.e. "key-format" argument is missing). If the "key" field is numeric, then use %d otherwise use %s.';
		}

		if ( false === in_array( $args['key-format'], [ '%s', '%d' ] ) ) {
			return 'The key format is invalid. If the "key" field is numeric, then use %d otherwise use %s.';
		}

	}
}

/**
 * User Info
 *
 * Class SV_USER_INFO
 */
class SV_SC_USER_META extends SV_Preset {

	protected function unsanitised() {
		
		$user_id = get_current_user_id();

		// Not logged in?
		if ( true === empty( $user_id ) ) {
			return '';
		}

		$args 	= wp_parse_args( $this->get_arguments(), [ 'field' => NULL, 'message-not-found' => '' ] );

		if ( true === empty( $args[ 'field' ] ) ) {
			return 'Field not specified';
		}

		$value 	= get_user_meta( $user_id, $args[ 'field' ], true );

		return !empty( $value ) ? $value : $args[ 'message-not-found' ];
	}
}
