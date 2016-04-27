(function($) {
	
	'use strict';
	
	// Extend core script
	$.extend($.nmTheme, {
		
		/**
		 *	Initialize single product scripts
		 */
		singleProduct_init: function() {
			var self = this;
									
			self.singleProductVariationsInit();
			self.shopInitQuantity($('#nm-product-summary'));
			self.singleProductGalleryInit();
			
			/* Star-rating: bind click event */
			var $ratingWrap = $('#nm-comment-form-rating');
			$ratingWrap.on('click.nmAddParentClass', '.stars a', function() {
				$ratingWrap.children('.stars').addClass('has-active');
            });
									
			/* Load related product images (init Unveil) */
			var $upsellsImages = $('#nm-upsells').find('.nm-shop-loop-thumbnail .unveil-image'),
				$relatedImages = $('#nm-related').find('.nm-shop-loop-thumbnail .unveil-image'),
				$images = $.merge($upsellsImages, $relatedImages);
			
			self.$window.load(function() {
				if ($images.length) {
					$images.unveil(1, function() {
						$(this).parents('li').first().addClass('image-loaded');
					});
				}
			});
		},
		
		
		/**
		 *	Single product: Variations
		 */
		singleProductVariationsInit: function() {
			var self = this;
			
			
			/* Variations: Elements */
			self.$variationsForm = $('#nm-variations-form');
			self.$variationsWrap = self.$variationsForm.children('.variations');
			
				
			/* Variations: Select boxes */
			self.$variationsWrap.find('select').selectOrDie(self.shopSelectConfig);
			
			
			/* Variation details: Init */
			self.shopToggleVariationDetails(); // Init
			self.$variationsForm.on('found_variation', function() { // Bind: WooCommerce "found_variation" event
				self.shopToggleVariationDetails();
			});
			
			
			/* Variations/Slider: Go to first slide when variation select changes */
			self.$variationsForm.on('woocommerce_variation_select_change', function() {
				if (self.$productImageSlider.length) {
					self.$productImageSlider.slick('slickGoTo', 0, false); // Args: (event, slideIndex, skipAnimation)
				}
			});
		},
		
		
		/**
		 *	Single product: Initialize gallery
		 */
		singleProductGalleryInit: function() {
			var self = this;
			
			/* Product gallery/slider */
			if ($('#nm-page-includes').hasClass('product-gallery')) {
				
				/* Slider: Elements */
				self.$productImageSlider = $('#nm-product-images-slider');
				
				var $productImages = self.$productImageSlider.children('div'),
					$productThumbSlider = $('#nm-product-thumbnails-slider'),
					$productThumbs = $productThumbSlider.children('div'),
					$activeThumb = $productThumbs.first(),
					numThumbs = $productThumbs.length,
					maxThumbs = 6,
					thumbsToShow = (numThumbs > maxThumbs) ? maxThumbs : numThumbs,
					animSpeed = 300,
					isThumbClick = false;
							
				/* Slider: Events */
				self.$productImageSlider.on('init', function() {
					/* Bind: Product image wraps click event */
					$productImages.bind('click', function(e) {
						if (self.$productImageSlider.hasClass('animating')) { return; }
						e.preventDefault();
						_openPhotoSwipe(this);
					});
				});

				self.$productImageSlider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
					// Only trigger thumbnail click if navigating the slider directly
					if (!isThumbClick) {
						//console.log('NM: Trigger - Thumb click');
						$productThumbSlider.find('.slick-slide').eq(nextSlide).trigger('click');
					}
					
					isThumbClick = false;
					
					self.$productImageSlider.addClass('animating');
				});
				self.$productImageSlider.on('afterChange', function() {
					self.$productImageSlider.removeClass('animating');
				});
				
				/* Slider: Init */
				self.$productImageSlider.slick({
					adaptiveHeight: true,
					slidesToShow: 1,
					slidesToScroll: 1,
					prevArrow: '<a class="slick-prev"><i class="nm-font nm-font-play flip"></i></a>',
					nextArrow: '<a class="slick-next"><i class="nm-font nm-font-play"></i></a>',
					dots: true,
					fade: true,
					cssEase: 'linear',
					infinite: false,
					speed: animSpeed
				});
				
				
				
				/* Thumbnails slider: Events */
				$productThumbSlider.on('init', function() {
					$productThumbs.bind('click', function() {
						var $this = $(this);
						
						if (self.$productImageSlider.hasClass('animating') || $this.hasClass('current')) {
							return;
						}
						
						//console.log('NM: Thumb click');
						
						isThumbClick = true;
						
						// Set active class
						$activeThumb.removeClass('current');
						$this.addClass('current');
						$activeThumb = $this;
						
						// Show prev/next thumbnail
						if (!$this.next().hasClass('slick-active')) {
							$productThumbSlider.slick('slickNext');
						} else if (!$this.prev().hasClass('slick-active')) {
							$productThumbSlider.slick('slickPrev');
						}
						
						// Change main image
						self.$productImageSlider.slick('slickGoTo', $this.index(), false); // (event, slideIndex, skipAnimation)
					});
				});
				
				/* Thumbnails slider: Init */
				$productThumbSlider.slick({
					slidesToShow: thumbsToShow,
					slidesToScroll: 1,
					arrows: false,
					infinite: false,
					focusOnSelect: false,
					vertical: true,
					draggable: false,
					speed: animSpeed,
					swipe: false,
					touchMove: false
				});
				
				
							
				/* Product fullscreen gallery (PhotoSwipe) */
				var _openPhotoSwipe = function(imageWrap) {
					var index = $(imageWrap).index(); // Clicked image-container index
					
					// Create gallery images array
					var $this, $a, $img, items = [], size, item;
					$productImages.each(function() {
						$this = $(this);
						$a = $this.children('a');
						$img = $a.children('img');
						size = $a.data('size').split('x');
						
						// Create slide object
						item = {
							src: $a.attr('href'),
							w: parseInt(size[0], 10),
							h: parseInt(size[1], 10),
							msrc: $img.attr('src'),
							el: $a[0] // Save image link for use in 'getThumbBoundsFn()' below
						};
						items.push(item);
					});
					
					// Gallery options
					var options = {
						index: index,
						showHideOpacity: true,
						bgOpacity: 0.86,
						loop: false,
						mainClass: 'pswp--minimal--dark',
						// PhotoSwipeUI_Default:
						barsSize: { top: 0, bottom: 0 },
						captionEl: false,
						fullscreenEl: false,
						zoomEl: false,
						shareE1: false,
						counterEl: false,
						tapToClose: true,
						tapToToggleControls: false
					};
					
					var pswpElement = $('#pswp')[0];
					
					// Initialize and open gallery (PhotoSwipe)
					var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
					gallery.init();
					
					// Event: Opening zoom animation
					gallery.listen('initialZoomIn', function() {
						$productThumbSlider.slick('slickSetOption', 'speed', 0);
					});
					// Event: Before slides change
					var slide = index;
					gallery.listen('beforeChange', function(dirVal) {
						slide = slide + dirVal;
						self.$productImageSlider.slick('slickGoTo', slide, true); // Change active image in slider (event, slideIndex, skipAnimation)
					});
					// Event: Gallery starts closing
					gallery.listen('close', function() {
						$productThumbSlider.slick('slickSetOption', 'speed', animSpeed);
					});
				}
				
			}
		}
		
	});
	
	// Add extension so it can be called from $.nmThemeExtensions
	$.nmThemeExtensions.singleProduct = $.nmTheme.singleProduct_init;
	
})(jQuery);
