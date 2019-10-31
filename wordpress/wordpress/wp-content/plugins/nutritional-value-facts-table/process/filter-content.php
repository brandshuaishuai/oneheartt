<?php
// De functie om de receptinformatie toe te voegen.
function nvft_filter_nutrition_value_content($content){ 
	if( !is_singular( 'nutritional_value' )) { // Om te kijken of dit gaat om een single post. En niet om een excerpt
	return $content;
	}
	
	global $post;
	$nvft_data = get_post_meta ( $post->ID, 'nvft_data', true);
	$nvft_html = file_get_contents('nutrition-value-template.php', true); 
	$nvft_html = str_replace( "FOODNAME_PH", $nvft_data['foodname'], $nvft_html);
	$nvft_html = str_replace( "CATEGORY_PH", $nvft_data['category'], $nvft_html);
	$nvft_html = str_replace( "CALORIES_PH", $nvft_data['calories'], $nvft_html);
	$nvft_html = str_replace( "AMOUNT_PH", $nvft_data['amount'], $nvft_html);
	$nvft_html = str_replace( "CARBOHYDRATES_PH", $nvft_data['carbohydrates'], $nvft_html);
    $nvft_html = str_replace( "SUGARS_PH", $nvft_data['sugars'], $nvft_html);
	$nvft_html = str_replace( "FIBER_PH", $nvft_data['fiber'], $nvft_html);
	$nvft_html = str_replace( "PROTEIN_PH", $nvft_data['protein'], $nvft_html);
	$nvft_html = str_replace( "TOTALFAT_PH", $nvft_data['totalfat'], $nvft_html);
	$nvft_html = str_replace( "SATURATEDFAT_PH", $nvft_data['saturatedfat'], $nvft_html);
    $nvft_html = str_replace( "JOHNY_PH", $nvft_data['johny'], $nvft_html);
	$nvft_html = str_replace( "OMEGA3_PH", $nvft_data['omega3'], $nvft_html);
	$nvft_html = str_replace( "OMEGA6_PH", $nvft_data['omega6'], $nvft_html);
	$nvft_html = str_replace( "CHOLESTEROL_PH", $nvft_data['cholesterol'], $nvft_html);
	$nvft_html = str_replace( "VITAMINA_PH", $nvft_data['vitamina'], $nvft_html);
    $nvft_html = str_replace( "VITAMINB1_PH", $nvft_data['vitaminb1'], $nvft_html);
	$nvft_html = str_replace( "VITAMINB2_PH", $nvft_data['vitaminb2'], $nvft_html);
	$nvft_html = str_replace( "VITAMINB6_PH", $nvft_data['vitaminb6'], $nvft_html);
	$nvft_html = str_replace( "VITAMINB11_PH", $nvft_data['vitaminb11'], $nvft_html);
	$nvft_html = str_replace( "VITAMINB12_PH", $nvft_data['vitaminb12'], $nvft_html);
    $nvft_html = str_replace( "VITAMINC_PH", $nvft_data['vitaminc'], $nvft_html);
	$nvft_html = str_replace( "VITAMIND_PH", $nvft_data['vitamind'], $nvft_html);
	$nvft_html = str_replace( "SODIUM_PH", $nvft_data['sodium'], $nvft_html);
	$nvft_html = str_replace( "POTASSIUM_PH", $nvft_data['potassium'], $nvft_html);
	$nvft_html = str_replace( "CALCIUM_PH", $nvft_data['calcium'], $nvft_html);
    $nvft_html = str_replace( "PHOSPHORUS_PH", $nvft_data['phosphorus'], $nvft_html);
    $nvft_html = str_replace( "IRON_PH", $nvft_data['iron'], $nvft_html);
	$nvft_html = str_replace( "MAGNESIUM_PH", $nvft_data['magnesium'], $nvft_html);
	$nvft_html = str_replace( "COPPER_PH", $nvft_data['copper'], $nvft_html);
	$nvft_html = str_replace( "ZINC_PH", $nvft_data['zinc'], $nvft_html);
    $nvft_html = str_replace( "FOODNAME_I18N", __('Foodname', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "CATEGORY_I18N", __('Category', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "CALORIES_I18N", __('Calories', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "AMOUNT_I18N", __('Amount', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "CARBOHYDRATES_I18N", __('Carbohydrates', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "SUGARS_I18N", __('Sugars', 'nutrition_value'), $nvft_html);
    $nvft_html = str_replace( "FIBER_I18N", __('Fiber', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "PROTEIN_I18N", __('Protein', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "TOTALFAT_I18N", __('Total Fat', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "SATURATEDFAT_I18N", __('Saturated Fat', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "JOHNY_I18N", __('Unsaturated Fat', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "OMEGA3_I18N", __('Omega 3', 'nutrition_value'), $nvft_html);
    $nvft_html = str_replace( "OMEGA6_I18N", __('Omega 6', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "CHOLESTEROL_I18N", __('Cholesterol', 'nutrition_value'), $nvft_html);
    
	$nvft_html = str_replace( "VITAMINA_I18N", __('Vitamin A', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "VITAMINB1_I18N", __('Vitamin B1', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "VITAMINB2_I18N", __('Vitamin B2', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "VITAMINB6_I18N", __('Vitamin B6', 'nutrition_value'), $nvft_html);
    $nvft_html = str_replace( "VITAMINB11_I18N", __('Vitamin B11', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "VITAMINB12_I18N", __('Vitamin B12', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "VITAMINC_I18N", __('Vitamin C', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "VITAMIND_I18N", __('Vitamin D', 'nutrition_value'), $nvft_html);
    $nvft_html = str_replace( "SODIUM_I18N", __('Sodium', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "POTASSIUM_I18N", __('Potassium', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "CALCIUM_I18N", __('Calcium', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "PHOSPHORUS_I18N", __('Phosphorus', 'nutrition_value'), $nvft_html);
    $nvft_html = str_replace( "IRON_I18N", __('Iron', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "MAGNESIUM_I18N", __('Magnesium', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "COPPER_I18N", __('Copper', 'nutrition_value'), $nvft_html);
	$nvft_html = str_replace( "ZINC_I18N", __('Zinc', 'nutrition_value'), $nvft_html);
	return $nvft_html . $content;
}
	