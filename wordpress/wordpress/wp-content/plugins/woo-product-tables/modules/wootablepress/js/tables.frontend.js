(function ($, app) {

	function WtbpFrontendPage() {
		this.$obj = this;
		return this.$obj;
	}

	WtbpFrontendPage.prototype.init = (function () {
		var _thisObj = this.$obj;
		_thisObj.initializeTable();
		_thisObj.eventsFrontend();
	});

	WtbpFrontendPage.prototype.initializeTable = (function () {
		var _thisObj = this.$obj;

		$('.wtbpTableWrapper').each(function( ) {
			var tableWrapper = $(this);
			app.initializeTable(tableWrapper, function(){
				lightbox.option({
					'resizeDuration': 200,
					'wrapAround': true
				});

				setTimeout(function() {
					tableWrapper.css({'visibility':'visible'});
					tableWrapper.find('.wtbpLoader').addClass('wtbpHidden');
					//tableWrapper.find('.product_button_mpc .product_mpc').html('Add to cart');
				}, 200);
			});
		});

		$('.wtbpTableWrapper').on( 'change', '.quantity .qty', function() {
			var qtyInput = $( this );
			var wrapper = qtyInput.closest('.wtbpAddToCartWrapper');
			var row = qtyInput.closest('tr');
			if(row.hasClass('child')){
				row = row.prev();
				var wrapperMain = row.find('td.add_to_cart');
				wrapperMain.find('.add_to_cart_button ').attr( 'data-quantity', qtyInput.val());
				wrapperMain.find('.qty').val(qtyInput.val());
				wrapperMain.find('.wtbpAddMulty').attr( 'data-quantity', qtyInput.val());
			}
			wrapper.find('.wtbpAddToCartButWrapp .wtbpAddToCart').attr( 'data-quantity', qtyInput.val());
			wrapper.find('.wtbpAddMulty').attr( 'data-quantity', qtyInput.val());
			wrapper.find('.add_to_cart_button').attr( 'data-quantity', qtyInput.val());
			wrapper.find('.add_to_cart_button').data( 'quantity', qtyInput.val());
		});

		//Set Ajax function for MPC add_to_cart button
		jQuery('.wtbpTableWrapper').on('click', '.add_to_cart_button.product_mpc', function(e) {

			e.preventDefault();

			var form = jQuery(this).closest('form'),
				button = jQuery(this),
				value = jQuery(this).attr('data-product_id'),
				addtocart = '';

			//Add product_id input to form for ?wc-ajax=add_to_cart
			if (form.find('.product_id').length == 0) {
				form.append('<input type="hidden" class="product_id" name="product_id" value="'+value+'">');
			}

			//Prepare URL and check MPC required field
			var url = '/?wc-ajax=add_to_cart',
			 	formSerialize = form.serialize(),
			 	amountInput = jQuery(this).closest('form').find('.amount_needed'),
				amountInputVal = amountInput.val();

			//If MPC required field not empty
			if (amountInputVal !== '') {
				button.attr('disabled',true).prop('disabled',true).addClass('loading');
				amountInput.attr('style', '');
				jQuery.ajax({
				  url: url,
				  type: "POST",
				  data: formSerialize,
				  success: function (response) {
						if (response) {
							button.attr('disabled',false).prop('disabled',false).removeClass('loading');
							$( document.body ).trigger( 'wc_fragment_refresh' );
							$( document.body ).trigger( 'wc_cart_button_updated', [ button ] );
							$.sNotify({
								'icon': 'fa fa-check',
								'content': '<span>Product added to cart</span>',
								'delay' : 1500
							});
						}
				   },
				});
			} else {
				amountInput.attr('style', 'border:1px solid red');
				return false;
			}

		});

		$('.wtbpTableWrapper').on('click', '.wtbpAddToCartButWrapp .wtbpAddToCart', function(e) {
			e.preventDefault();
			var button = jQuery(this);
			if(button.closest('.wtbpAddToCartWrapper').hasClass('wtbpDisabledLink')) return false;
			var selectedProduct = [];
			var pushObj = {};

			pushObj.id = button.attr('data-product_id');
			pushObj.varId = button.attr('data-variation_id');
			pushObj.quantity = button.attr('data-quantity');
			selectedProduct.push(pushObj);
			jQuery.sendFormWtbp({
				data: {
					mod: 'wootablepress',
					action: 'multyProductAddToCart',
					selectedProduct: selectedProduct,
				},
				onSuccess: function(res) {
					var message = res.messages;

					$( document.body ).trigger( 'wc_fragment_refresh' );
					button.closest('.wtbpAddToCartWrapper').find('.quantity .qty').val('1').trigger('change');
					button.closest('.wtbpAddToCartWrapper').find('.added_to_cart').removeClass('wtbpHidden');
					$( document.body ).trigger( 'wc_cart_button_updated', [ button ] );
					$.sNotify({
						'icon': 'fa fa-check',
						'content': '<span>'+message+'</span>',
						'delay' : 1500
					});
				}
			});
		});

	});

	WtbpFrontendPage.prototype.eventsFrontend = (function () {
		//var _thisObj = this.$obj;
	});

	$(document).ready(function () {
		var wtbpFrontendPage = new WtbpFrontendPage();
		wtbpFrontendPage.init();
	});


}(window.jQuery, window.supsystic.WooTablepress));
