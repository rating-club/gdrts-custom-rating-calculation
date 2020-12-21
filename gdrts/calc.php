<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Function to calculate Custom Rating value from the rating item, only
 * for the Stars Rating method.
 *
 * @param \gdrts_rating_item $item
 *
 * @return \gdrts_rating_item
 */
function gdrts_crc_calculate_item_rating( $item ) {
	$method = $item->get_method_data( 'stars-rating' );

	if ( $method['votes'] < 5 ) {
		/* if less then 5 votes are cast, make the custom rating same as average */
		$item->set_rating( 'crcalc', $method['rating'], 'stars-rating' );
	} else {
		/* find max and min rating recorded, and if the average is higher than 3
		 * remove the min rating values, and calculate the custom rating from the
		 * rest of the ratings. */
		$distribution = array_filter( $method['distribution'] );
		$max          = max( array_keys( $distribution ) );
		$min          = min( array_keys( $distribution ) );

		$remove = $method['rating'] > 3 ? $min : $max;

		unset( $distribution[ $remove ] );

		$total = 0;
		$sum   = 0;
		foreach ( $distribution as $value => $count ) {
			$sum   += $value * $count;
			$total += $count;
		}

		$item->set_rating( 'crcalc', number_format( $sum / $total, 2 ), 'stars-rating' );
	}

	return $item;
}
