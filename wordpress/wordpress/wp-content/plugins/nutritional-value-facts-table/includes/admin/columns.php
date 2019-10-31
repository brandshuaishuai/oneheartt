<?php

function add_new_nutritional_value_columns($columns){
    $new_columns = array();
    $new_columns['cb']                      = '<input type="checkbox" />';
    $new_columns['title']                   = __('Title', 'nutritional-value-facts-table');
    $new_columns['author']                  = __('Author', 'nutritional-value-facts-table');
    $new_columns['food_categories']         = __('Food Categories', 'nutritional-value-facts-table');
    $new_columns['date']                    = __('Date', 'nutritional-value-facts-table');

    return $new_columns;

}

function manage_nutritional_value_columns($column_name, $id) {
    
    switch ($column_name) {
        case 'food_categories':
            $nvft_data = get_post_meta($id, 'nvft_data', true);
            echo $nvft_data['category'];
            break;
        default:
            break;
    }
    
}


