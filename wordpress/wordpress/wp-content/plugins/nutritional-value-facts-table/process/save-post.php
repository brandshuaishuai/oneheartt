<?php
function nvft_save_post_admin($post_id, $post, $update) { // Daar komt die 3 van bij index.php
	if(!$update){
		return;
	} 
	$nvft_data                    = array();
	$nvft_data ['foodname']         = sanitize_text_field( $_POST[ 'nvft_inputFoodname' ]);
	$nvft_data ['category']         = sanitize_text_field( $_POST[ 'nvft_inputCategory' ]);
	$nvft_data ['amount']         = sanitize_text_field( $_POST[ 'nvft_inputAmount' ]);
	$nvft_data ['carbohydrates']         = sanitize_text_field( $_POST[ 'nvft_inputCarbohydrates' ]);
    	$nvft_data ['calories']         = sanitize_text_field( $_POST[ 'nvft_inputCalories' ]);
	$nvft_data ['sugars']         = sanitize_text_field( $_POST[ 'nvft_inputSugars' ]);
    	$nvft_data ['fiber']         = sanitize_text_field( $_POST[ 'nvft_inputFiber' ]);
	$nvft_data ['protein']         = sanitize_text_field( $_POST[ 'nvft_inputProtein' ]);
	$nvft_data ['totalfat']         = sanitize_text_field( $_POST[ 'nvft_inputTotalfat' ]);
	$nvft_data ['saturatedfat']         = sanitize_text_field( $_POST[ 'nvft_inputSaturatedfat' ]);
	$nvft_data ['johny']         = sanitize_text_field( $_POST[ 'nvft_inputJohny' ]);
    	$nvft_data ['omega3']         = sanitize_text_field( $_POST[ 'nvft_inputOmega3' ]);
	$nvft_data ['omega6']         = sanitize_text_field( $_POST[ 'nvft_inputOmega6' ]);
	$nvft_data ['cholesterol']         = sanitize_text_field( $_POST[ 'nvft_inputCholesterol' ]);
	$nvft_data ['vitamina']         = sanitize_text_field( $_POST[ 'nvft_inputVitamina' ]);
	$nvft_data ['vitaminb1']         = sanitize_text_field( $_POST[ 'nvft_inputVitaminb1' ]);
    	$nvft_data ['vitaminb2']         = sanitize_text_field( $_POST[ 'nvft_inputVitaminb2' ]);
	$nvft_data ['vitaminb6']         = sanitize_text_field( $_POST[ 'nvft_inputVitaminb6' ]);
	$nvft_data ['vitaminb11']         = sanitize_text_field( $_POST[ 'nvft_inputVitaminb11' ]);
	$nvft_data ['vitaminb12']         = sanitize_text_field( $_POST[ 'nvft_inputVitaminb12' ]);
	$nvft_data ['vitaminc']         = sanitize_text_field( $_POST[ 'nvft_inputVitaminc' ]);
    	$nvft_data ['vitamind']         = sanitize_text_field( $_POST[ 'nvft_inputVitamind' ]);
	$nvft_data ['sodium']         = sanitize_text_field( $_POST[ 'nvft_inputSodium' ]);
	$nvft_data ['potassium']         = sanitize_text_field( $_POST[ 'nvft_inputPotassium' ]);
	$nvft_data ['calcium']         = sanitize_text_field( $_POST[ 'nvft_inputCalcium' ]);
	$nvft_data ['phosphorus']         = sanitize_text_field( $_POST[ 'nvft_inputPhosphorus' ]);
    	$nvft_data ['iron']         = sanitize_text_field( $_POST[ 'nvft_inputIron' ]);
	$nvft_data ['magnesium']         = sanitize_text_field( $_POST[ 'nvft_inputMagnesium' ]);
	$nvft_data ['copper']         = sanitize_text_field( $_POST[ 'nvft_inputCopper' ]);
	$nvft_data ['zinc']         = sanitize_text_field( $_POST[ 'nvft_inputZinc' ]);
    
	update_post_meta( $post_id, 'nvft_data', $nvft_data); // Dat is om te kijken of de data al bestaat
}


