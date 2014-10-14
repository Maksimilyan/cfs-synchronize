<?php

/**
 * Get all CFS field groups
 */
function cfs_get_field_groups() {

    $query = new WP_Query( array(
        'post_type' => 'cfs',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'fields' => 'ids'
    ) );

    $field_groups = array();

    foreach ( $query->posts as $post_id ) {
        $fields = array();
        $temp = get_post_meta( $post_id, 'cfs_fields', true );
        foreach ( $temp as $field ) {
            $fields[ $field['name'] ] = $field;
        }

        $field_groups[ $post_id ] = $fields;
    }

    return $field_groups;
}


/**
 * Map postmeta to CFS fields
 */
function cfs_map_values() {
    global $wpdb;

    // CFS field groups
    $field_groups = cfs_get_field_groups();

    $query = new WP_Query( array(
        'post_type' => 'any',
        'posts_per_page' => 5,
        'post_status' => 'publish',
        'fields' => 'ids',
    ) );

    foreach ( $query->posts as $post_id ) {
        $matching_groups = CFS()->api->get_matching_groups( $post_id );
        if ( ! empty( $matching_groups ) ) {

            // Get all postmeta values for this post ID
            $postmeta = get_post_meta( $post_id );
            $field_data = array();

            // See which fields are already in the cfs_values table for this post ID
            $existing_field_ids = $wpdb->get_col( "
                SELECT DISTINCT field_id
                FROM {$wpdb->prefix}cfs_values
                WHERE post_id IN ('$post_id')"
            );

            // Loop through field groups
            foreach ( $matching_groups as $group_id => $group_name ) {
                // Loop through fields within this group
                foreach ( $field_groups[ $group_id ] as $field ) {
                    // Skip if CFS values already exist
                    if ( in_array( $field['id'], $existing_field_ids ) ) {
                        continue;
                    }

                    if ( ! empty( $postmeta[ $field['name'] ] ) ) {
                        $field_data[ $field['name'] ] = $postmeta[ $field['name'] ];
                    }
                }
            }

            // Save the values
            if ( ! empty( $field_data ) ) {
                CFS()->save( $field_data, array( 'ID' => $post_id ) );
            }
        }
    }
}
