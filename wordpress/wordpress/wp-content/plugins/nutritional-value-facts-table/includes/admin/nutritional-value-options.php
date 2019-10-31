<?php

// Dit zal de metabox doen verschijnen. En dat zijn de oopties die erin moeten verschijnen.


function nvft_nutritional_value_options_mb( $post){
	
	$nvft_data = get_post_meta($post->ID, 'nvft_data', true);
	
	if(!$nvft_data){
		$nvft_data = array(
		'foodname' => '',
		'category' => '',
		'calories' => '',
		'amount' => 'Grams',
		'carbohydrates' => '',
		'sugars' => '',
		'fiber' => '',
		'protein' => '',
		'totalfat' => '',
		'saturatedfat' => '',
		'johny' => '',
		'cholesterol' => '',
		'vitamina' => '',
		'vitaminb1' => '',
		'vitaminb2' => '',
		'vitaminb6' => '',
		'vitaminb11' => '',
		'vitaminb12' => '',
		'vitaminc' => '',
		'vitamind' => '',
		'sodium' => '',
		'potassium' => '',
		'calcium' => '',
		'phosphorus' => '',
		'iron' => '',
		'magnesium' => '',
		'copper' => '',
		'zinc' => '',
		'omega3' => '',
		'omega6' => ''
		);
		
	}
?>
<div class='form-group'>
<label>Food Name</label>
<input type='text' class='form-control' name='nvft_inputFoodname' value="<?php echo $nvft_data['foodname'] ?>">
</div>

<div class='form-group'>
<label>Food Category</label>
<input type='text' class='form-control' name='nvft_inputCategory' value="<?php echo $nvft_data['category'] ?>">
</div>

<div class='form-group'>
<label>Amount</label>
    <select class='form-control' name='nvft_inputAmount'>
<option value='<?php echo "100" ?> Grams'>100 Grams</option>
<option value='Piece' <?php echo $nvft_data['amount'] == "Piece" ? 'SELECTED' : ''; ?>>Piece</option>
</select>
</div>

<div class='form-group'>
<label>Calories</label>
<input type='text' class='form-control' name='nvft_inputCalories' value="<?php echo $nvft_data['calories'] ?>">
</div>

<div class='form-group'>
<label>Carbohydrates</label>
<input type='text' class='form-control' name='nvft_inputCarbohydrates' value="<?php echo $nvft_data['carbohydrates'] ?>">
</div>

<div class='form-group'>
<label>Sugars</label>
<input type='text' class='form-control' name='nvft_inputSugars' value="<?php echo $nvft_data['sugars'] ?>">
</div>

<div class='form-group'>
<label>Fiber</label>
<input type='text' class='form-control' name='nvft_inputFiber' value="<?php echo $nvft_data['fiber'] ?>">
</div>

<div class='form-group'>
<label>Protein</label>
<input type='text' class='form-control' name='nvft_inputProtein' value="<?php echo $nvft_data['protein'] ?>">
</div>

<div class='form-group'>
<label>Total Fat</label>
<input type='text' class='form-control' name='nvft_inputTotalfat' value="<?php echo $nvft_data['totalfat'] ?>">
</div>

<div class='form-group'>
<label>Saturated Fat</label>
<input type='text' class='form-control' name='nvft_inputSaturatedfat' value="<?php echo $nvft_data['saturatedfat'] ?>">
</div>

<div class='form-group'>
<label>Unsaturated Fat</label>
<input type='text' class='form-control' name='nvft_inputJohny' value="<?php echo $nvft_data['johny'] ?>">
</div>

<div class='form-group'>
<label>Omega 3</label>
<input type='text' class='form-control' name='nvft_inputOmega3' value="<?php echo $nvft_data['omega3'] ?>">
</div>

<div class='form-group'>
<label>Omega 6</label>
<input type='text' class='form-control' name='nvft_inputOmega6' value="<?php echo $nvft_data['omega6'] ?>">
</div>

<div class='form-group'>
<label>Cholesterol </label>
<input type='text' class='form-control' name='nvft_inputCholesterol' value="<?php echo $nvft_data['cholesterol'] ?>">
</div>

<div class='form-group'>
<label>Vitamin A </label>
<input type='text' class='form-control' name='nvft_inputVitamina' value="<?php echo $nvft_data['vitamina'] ?>">
</div>

<div class='form-group'>
<label>Vitamin B1 </label>
<input type='text' class='form-control' name='nvft_inputVitaminb1' value="<?php echo $nvft_data['vitaminb1'] ?>">
</div>

<div class='form-group'>
<label>Vitamin B2 </label>
<input type='text' class='form-control' name='nvft_inputVitaminb2' value="<?php echo $nvft_data['vitaminb2'] ?>">
</div>

<div class='form-group'>
<label>Vitamin B6 </label>
<input type='text' class='form-control' name='nvft_inputVitaminb6' value="<?php echo $nvft_data['vitaminb6'] ?>">
</div>

<div class='form-group'>
<label>Vitamin B11</label>
<input type='text' class='form-control' name='nvft_inputVitaminb11' value="<?php echo $nvft_data['vitaminb11'] ?>">
</div>

<div class='form-group'>
<label>Vitamin B12</label>
<input type='text' class='form-control' name='nvft_inputVitaminb12' value="<?php echo $nvft_data['vitaminb12'] ?>">
</div>

<div class='form-group'>
<label>Vitamin C</label>
<input type='text' class='form-control' name='nvft_inputVitaminc' value="<?php echo $nvft_data['vitaminc'] ?>">
</div>

<div class='form-group'>
<label>Vitamin D</label>
<input type='text' class='form-control' name='nvft_inputVitamind' value="<?php echo $nvft_data['vitamind'] ?>">
</div>

<div class='form-group'>
<label>Sodium</label>
<input type='text' class='form-control' name='nvft_inputSodium' value="<?php echo $nvft_data['sodium'] ?>">
</div>

<div class='form-group'>
<label>Potassium</label>
<input type='text' class='form-control' name='nvft_inputPotassium' value="<?php echo $nvft_data['potassium'] ?>">
</div>

<div class='form-group'>
<label>Calcium </label>
<input type='text' class='form-control' name='nvft_inputCalcium' value="<?php echo $nvft_data['calcium'] ?>">
</div>

<div class='form-group'>
<label>Phosphorus </label>
<input type='text' class='form-control' name='nvft_inputPhosphorus' value="<?php echo $nvft_data['phosphorus'] ?>">
</div>

<div class='form-group'>
<label>Iron </label>
<input type='text' class='form-control' name='nvft_inputIron' value="<?php echo $nvft_data['iron'] ?>">
</div>
<div class='form-group'>
<label>Magnesium</label>
<input type='text' class='form-control' name='nvft_inputMagnesium' value="<?php echo $nvft_data['magnesium'] ?>">
</div>

<div class='form-group'>
<label>Copper</label>
<input type='text' class='form-control' name='nvft_inputCopper' value="<?php echo $nvft_data['copper'] ?>">
</div>

<div class='form-group'>
<label>Zinc</label>
<input type='text' class='form-control' name='nvft_inputZinc' value="<?php echo $nvft_data['zinc'] ?>">
</div>



<?php	
}

?>