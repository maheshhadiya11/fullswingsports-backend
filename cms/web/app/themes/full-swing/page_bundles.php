<?php /* Template Name: Bundles */ ?>
<?php
$products = include 'products-config.php';
?>


<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php
        if ( function_exists( 'wp_body_open' ) ) {
            wp_body_open();
        }
	?>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.1/dist/cdn.min.js" defer></script>
    <div class="container configurator-base xl:overflow-visible overflow-auto flex flex-col justify-center "
         x-data="{
             currentStep: 0,
			 maxSteps: 4,
             selections: {
                screensize: '',
                mounttype: '',
                gaminglaptop: '',
				net: '',
				kitstudio: 'true'
             },
             init() {
                 this.parseUrlParams();
                 let allSelectionsMade = Object.values(this.selections).every(selection => selection !== '');
				  if (this.selections.net === 'true') {
                	this.currentStep = 2;
            	}
                 if (this.currentStep === this.maxSteps || allSelectionsMade) {
                    // Reset Logic
                    this.currentStep = 0;
                    this.selections = {
                        screensize: '',
                        mounttype: '',
                        gaminglaptop: '',
                        net: '',
                        kitstudio: 'true'
                    };
                
                    this.updateURL();
                } else {
                    // Proceed with other initializations
                    this.filterProducts();
                }
                 
             },
             products: <?php echo str_replace('"', "'", json_encode($products)); ?>,
             skus: {
			   'FullSwingKitStudio_10ft_Floor_Laptop': 'PR-6790-2613-XXXX',
			   'FullSwingKitStudio_10ft_Ceiling_Laptop': 'PR-6790-2614-XXXX',
			   'FullSwingKitStudio_10ft_Ceiling_NoLaptop': 'PR-6790-2615-XXXX',
			   'FullSwingKitStudio_10ft_Floor_NoLaptop': 'PR-6790-2616-XXXX',
			   '10ft_Floor_Laptop': 'PR-6790-2617-XXXX',
			   '10ft_Ceiling_Laptop': 'PR-6790-2618-XXXX',
			   'FullSwingKitStudio_12ft_Floor_Laptop': 'PR-6790-2619-XXXX',
			   'FullSwingKitStudio_12ft_Ceiling_Laptop': 'PR-6790-2620-XXXX',
			   'FullSwingKitStudio_12ft_Ceiling_NoLaptop': 'PR-6790-2621-XXXX',
			   'FullSwingKitStudio_12ft_Floor_NoLaptop': 'PR-6790-2622-XXXX',
			   '12ft_Floor_Laptop': 'PR-6790-2623-XXXX',
			   '12ft_Ceiling_Laptop': 'PR-6790-2624-XXXX'
			},
			skusWithNet: {
			   'FullSwingKitStudio_Net_Laptop': 'PR-6790-2610-XXXX',
			   'FullSwingKitStudio_Net_NoLaptop': 'PR-6790-2611-XXXX',
			   'Net_Laptop': 'PR-6790-2612-XXXX'
			},
             addSelection(step, option) {
                 const product = this.products[step];
                 this.selections[product.name.split(' ').join('').toLowerCase()] = option;
                 this.updateURL();
                 this.currentStep++;
				 this.logSKU();
                 if(step === 0 && option === 'true') {
                     this.currentStep = 3;
                 }
                 window.scrollTo(0, 0);
                 //window.scrollTo({ top: 0, behavior: 'smooth' });

                 //this.filterProducts();
             },
             filterProducts() {
                 this.products = this.products.filter((product) => {
                     const key = product.name.split(' ').join('').toLowerCase();
                     return !(key in this.selections && this.selections[key]);
                 });
				 this.maxSteps = this.products.length;
             },
             parseUrlParams() {
                 const params = new URLSearchParams(window.location.search);
                 for (const [key, value] of params) {
                     if (key in this.selections) {
                         this.selections[key] = value;
                     }
                 }
             },
             updateURL() {
                 const params = new URLSearchParams();
                 for (const [key, value] of Object.entries(this.selections)) {
                     if (value) {
                         params.set(key, value);
                     }
                 }
                 history.pushState({}, '', `${window.location.pathname}?${params}`);
             },
             logSKU() {
	
       		let sku;
				if (this.selections.net === 'true') {
				    const kitSuffix = this.selections.kitstudio === 'true' ? 'FullSwingKitStudio_' : '';
				    const laptopKey = this.selections.gaminglaptop === 'Laptop' ? 'Laptop' : 'NoLaptop';
				    sku = this.skusWithNet[`${kitSuffix}Net_${laptopKey}`];
				} else {
				    const kitPrefix = this.selections.kitstudio === 'true' ? 'FullSwingKitStudio_' : '';
				    const screenKey = this.selections.screensize;
				    const mountKey = this.selections.mounttype; 
				    const laptopKey = this.selections.gaminglaptop === 'Laptop' ? 'Laptop' : 'NoLaptop';
				    sku = this.skus[`${kitPrefix}${screenKey}_${mountKey}_${laptopKey}`];
				}

			    if (sku && this.currentStep === this.maxSteps ) {
			        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
			            method: 'POST',
			            headers: {
			                'Content-Type': 'application/x-www-form-urlencoded',
			            },
			            body: new URLSearchParams({
			                'action': 'add_to_cart_by_sku',
			                'sku': sku,
			            })
			        })
			        .then(response => response.json())
			        .then(data => {
			            if (data.success) {
			                //console.log('Product added to cart:', data);
							 window.location.href = '/cart';
			            } else {
			                console.error('Failed to add product to cart:', data);
			            }
			        })
			        .catch(error => {
			            console.error('Error adding product to cart:', error);
			        });
			    }
			}
			 ,
         }"
         x-init="init()">
        <template x-for="(product, index) in products" :key="index">
            <div class="md:default-grid grid-container " x-show="currentStep === index">
                <h2 class="configurator-headline mt-auto" x-text="product.title"></h2>
                <div class="hidden xl:block xxl:hidden col-start-1"></div>
                <template x-if="product.type === 'variable'">
                    <template x-for="option in product.options" :key="option.name">
                        <div class="fifty-fifty-card transition-all duration-300" x-data="{ isExpanded: false }">
                            <div class="fifty-fifty-image-container">
                                <img :src="option.image_url" :alt="option.name" />
                            </div>
                            <h3 class="fifty-fifty-headline" x-text="option.title"></h3>
                            <span class="fifty-fifty-copy fifty-fifty-richtext" x-html="option.copy"></span>
                            <div class="additional-details fifty-fifty-copy" x-html="option.additional" :style="{ maxHeight: isExpanded ? '1000px' : '0' }"
                             :class="{ 'expanded-padding': isExpanded }">
                            >
                                
                            </div>
                            <div class="fifty-fifty-button-container">
                                <button class="select-variant-button" @click="addSelection(index, option.name)">
                                    <span x-text="option.price"></span>
                                </button>
                                <button x-show="!!option.additional" class="configurator-secondary-button" @click="isExpanded = !isExpanded">
									<span x-text="isExpanded ? 'Show Less' : 'Show More'"></span>
								</button>
                            </div>
                        </div>
                    </template>
                </template>
                <template x-if="product.type === 'simple'">
                    <div class="full-width-card">
                        <div class="full-width-image-container">
                            <img :src="product.image_url" :alt="product.name" />
                        </div>
                        <div class="full-width-content">
                            <h3 class="full-width-headline" x-text="'Premium ' + product.name"></h3>
                            <span class="fifty-fifty-copy full-width-richtext" x-html="product.copy"></span>
                            <div class="fifty-fifty-button-container">
                                <button class="select-variant-button" @click="addSelection(index, 'Laptop')">
                                    <span x-text="product.price"></span>
                                </button>
                                <button class="configurator-secondary-button" @click="addSelection(index, 'NoLaptop')">
                                    Continue to Checkout
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </template>
    </div>

    <?php wp_footer(); ?>
</body>
</html>
