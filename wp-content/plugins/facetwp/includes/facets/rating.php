<?php

class FacetWP_Facet_Rating extends FacetWP_Facet
{

    function __construct() {
        $this->label = __( 'Star Rating', 'fwp' );
    }


    /**
     * Load the available choices
     */
    function load_values( $params ) {
        global $wpdb;

        $facet = $params['facet'];
        $from_clause = $wpdb->prefix . 'facetwp_index f';

        // Facet in "OR" mode
        $where_clause = $this->get_where_clause( $facet );

        $output = array(
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0
        );

        $sql = "
        SELECT COUNT(*) AS `count`, FLOOR(f.facet_value) AS `rating`
        FROM $from_clause
        WHERE f.facet_name = '{$facet['name']}' AND FLOOR(f.facet_value) >= 1 $where_clause
        GROUP BY rating";

        $results = $wpdb->get_results( $sql );

        foreach ( $results as $result ) {
            $output[ $result->rating ] = $result->count;
        }

        $total = 0;

        // The lower rating should include higher rating counts
        for ( $i = 5; $i > 0; $i-- ) {
            $output[ $i ] += $total;
            $total = $output[ $i ];
        }

        return $output;
    }


    /**
     * Generate the facet HTML
     */
    function render( $params ) {

        $output = '';
        $facet = $params['facet'];
        $values = (array) $params['values'];
        $selected_values = (array) $params['selected_values'];

        $num_stars = 0;
        foreach ( $values as $star_count ) {
            if ( 0 < $star_count ) {
                $num_stars++;
            }
        }

        if ( 0 < $num_stars ) {
            $output .= '<span class="facetwp-stars">';

            for ( $i = $num_stars; $i >= 1; $i-- ) {
                $class = in_array( $i, $selected_values ) ? ' selected' : '';
                $output .= '<span class="facetwp-star' . $class . '" data-value="' . $i . '" data-counter="' . $values[ $i ] . '">★</span>';
            }

            $output .= '</span>';
            $output .= ' <span class="facetwp-star-label"></span>';
            $output .= ' <span class="facetwp-counter"></span>';
        }

        return $output;
    }


    /**
     * Filter the query based on selected values
     */
    function filter_posts( $params ) {
        global $wpdb;

        $facet = $params['facet'];
        $selected_values = $params['selected_values'];
        $selected_values = is_array( $selected_values ) ? $selected_values[0] : $selected_values;

        $sql = "
        SELECT DISTINCT post_id FROM {$wpdb->prefix}facetwp_index
        WHERE facet_name = '{$facet['name']}' AND facet_value >= '$selected_values'";
        return $wpdb->get_col( $sql );
    }
}
