<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class gdrts_crc_addon extends gdrts_addon {
	public $prefix = 'custom-rating-calculation';

	public function __construct() {
		parent::__construct();

		/* Expand plugin Query object to handle new rating calculation */
		add_filter( 'gdrts_core_query_parts', array( $this, 'query_parts' ), 10, 2 );

		/* Add new rating calculation for the stars rating method orderby lists */
		add_filter( 'gdrts_list_stars-rating_orderby', array( $this, 'the_orderby' ) );

		/* Set the order argument for the custom rating calculation */
		add_filter( 'gdrts_core_query_sort_orderby_crcalc', array( $this, 'orderby_handler' ), 10, 3 );

		/* Add new rating calculation for the stars rating method rating value lists */
		add_filter( 'gdrts_list_stars-rating_rating_value', array( $this, 'the_rating_value' ) );

		/* Load the custom calculation rating for the single rating loop item */
		add_filter( 'gdrts_stars_rating_loop_single_calc', array( $this, 'stars_rating_loop_single_calc' ) );

		/* Load the custom calculation rating for the rating loop list item */
		add_filter( 'gdrts_stars_rating_loop_list_item_calc', array( $this, 'stars_rating_loop_list_item_calc' ) );

		/* Calculate the custom calculation rating value before saving the item after voting */
		add_filter( 'gdrts_calculate_stars_rating_item', array( $this, 'calculate_stars_rating_item' ) );

		/* Calculate the custom calculation rating value before saving the item after recalculation */
		add_filter( 'gdrts_recalculate_stars_rating_item', array( $this, 'calculate_stars_rating_item' ) );
	}

	public function load_admin() {

	}

	public function the_orderby( $orderby ) {
		$orderby['crcalc'] = __( "Custom Calculation Rating", "gd-rating-system" );

		return $orderby;
	}

	public function the_rating_value( $ratings ) {
		$ratings['crcalc'] = __( "Custom Calculation", "gd-rating-system" );

		return $ratings;
	}

	public function orderby_handler( $order, $direction, $args ) {
		if ( $args['method'] == 'stars-rating' ) {
			$order = 'crcalc ' . $direction . ', ' . $order;
		}

		return $order;
	}

	public function query_parts( $parts, $args ) {
		if ( $args['orderby'] == 'crcalc' ) {
			if ( $args['method'] == 'stars-rating' ) {
				$parts['select'] .= ', mcrccalc.`meta_value` as crcalc';
				$parts['from']   .= " INNER JOIN " . gdrts_db()->itemmeta . " mcrccalc ON mcrccalc.`item_id` = i.`item_id` AND mcrccalc.`meta_key` = 'stars-rating_crcalc'";
			}
		}

		return $parts;
	}

	public function stars_rating_loop_single_calc( $calc ) {
		$calc['crcalc'] = number_format( gdrts_single()->item()->get_method_value( 'crcalc', 0, 'stars-rating' ), gdrts()->decimals() );

		return $calc;
	}

	public function stars_rating_loop_list_item_calc( $calc ) {
		$calc['crcalc'] = number_format( gdrts_list()->item()->get_method_value( 'crcalc', 0, 'stars-rating' ), gdrts()->decimals() );

		return $calc;
	}

	public function calculate_stars_rating_item( $item ) {
		require_once( GDRTS_CRC_PATH . 'gdrts/calc.php' );

		return gdrts_crc_calculate_item_rating( $item );
	}
}
