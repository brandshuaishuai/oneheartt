<?php
function nvft_create_metaboxes() {
	add_meta_box( 'nvft_nutritional_value_options_mb', __('Nutritional Value Options', 'nutritional-value-facts-table' ), 'nvft_nutritional_value_options_mb', 'nutritional_value', 'normal', 'high'
	
	);
}
/*function foodtype_nvft_create_metaboxes() {
	add_meta_box( 'nvft_food_category_options_mb', __('Food Category', 'nutritional-value-facts-table' ), 'nvft_food_category_options_mb', 'nutritional_value', 'side', 'core'
	
	);
} */
// DIT MAAKT DE METABOX AAN. De eerste is de naam van de functie, de tweede (Recipe Options is de naam.) 'recipe' is het post type waar de metabox moet in voorkomen. 'normal' betekent dat we dit langsonder willen hebben. 'side' zal in de sidebar komen. 'advanced' komt bovenaan. 'high' staat voor de prioriteit. We kunnen high, core, low en default gebruiken. High betekent natuurlijk dat dit de hoogste prioriteit krijgt.

//  
?>