<template>
	<div class="si-prod">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<h2 class="my-2">Product Details</h2>
					<div v-for="(product, index) in products" :key="index">
						<div class="si-st" v-if="product.productId == ProId">
							<div class="card pr-cd si-pg">
								<div class="pr-det">
									<div class="image">
										<img class="card-img" :src="'/' + image" :alt="product.imageAlt" />
									</div>
									<div class="row sin-ima">
										<div class="col-3" v-for="(icon,index) in icons" :key="index">
											<img
												class="card-img-top"
												:src="`/${icon.image}`"
												:alt="icon.alt"
												@mouseover="updateViewImage(index)"
											/>
										</div>
									</div>
								</div>
								<div class="prod-tit text-center">
									<p class="card-text">{{ product.productTitle }}</p>
								</div>
								<div class="prod-am card-body mb-3">
									<span class="price">Ksh. {{ product.productPrice | threeDigitsCoversion }}</span>
									<a
										href="javascript:;"
										class="cart btn btn-warning float-right"
										@click="add_cart(index)"
									>Add cart</a>
								</div>
							</div>
							<div class="row details" style="margin-top: 3em;">
								<div class="col-12">
									<div class="si-des">
										<dl>
											<div class="border-bottom-0">
												<dt>Description:</dt>
												<dd class="border-left">{{ product.productDescription }}</dd>
											</div>
											<div class="border-bottom-0">
												<dt class="border-right">Price (Ksh):</dt>
												<dd>{{ product.productPrice | threeDigitsCoversion }}</dd>
											</div>
											<div>
												<dt class="border-right">Color:</dt>
												<dd>{{ product.productPrice }}</dd>
											</div>
										</dl>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<style scoped>
/* .container-fluid {
	padding-right: 40px;
	padding-left: 40px;
} */
section h2 {
	padding-top: 0.5em;
	padding-bottom: 0.3em;
}
.card-img-top {
	margin-bottom: 0.5em;
}
.btn-warning {
	/* padding: 0.075rem 0.35rem; */
	color: #514a4a;
}
</style>

<script>
export default {
	name: "singleProduct",
	props: {
		products: {
			type: Array,
			required: true
		}
	},
	data() {
		return {
			imageHovered: 0
		};
	},
	mounted() {
		this.$emit("hide-cat", true);
	},
	methods: {
		add_cart(index) {
			this.$emit("add-to-cart", index);
		},
		updateViewImage(index) {
			this.imageHovered = index;
		}
	},
	computed: {
		ProId() {
			return this.products[this.$route.params.Pid].productId; // alternative is using props instead of params in routes enable props = true
		},
		icons() {
			const icons = [
				{
					image:
						"storage/" + this.products[this.$route.params.Pid].productImage,
					imageAlt: this.products[this.$route.params.Pid].productAlt
				},
				{
					image: "images/373543.jpeg",
					alt: "Front view of product"
				},
				{
					image: "images/images.jpg",
					alt: "Side view of the product"
				}
			];
			return icons;
		},
		image() {
			return this.icons[this.imageHovered].image;
		}
	}
};
</script>
<style scoped>
</style>

