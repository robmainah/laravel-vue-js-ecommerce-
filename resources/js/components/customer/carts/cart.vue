<template>
	<div>
		<div class="cotainer">
			<div class="row">
				<section class="col-md-8 col-sm-12 ca-prod offset-2">
					<div class="row checkout-top">
						<div class="col-4">
							<h2>Products in Cart</h2>
						</div>
						<div class="col-5 text-center ca-totals">
							<h2 v-show="totals > 0">
								<strong>Total</strong>
								Ksh. {{ sumTotal }}
							</h2>
						</div>
						<div class="col-3" v-if="carts.length > 0">
							<button type="button" class="btn btn-success" @click="checkout">Checkout</button>
						</div>
					</div>

					<div v-for="(product,index) in selectedProducts" :key="index">
						<div class="card">
							<div class="card-body">
								<div class="image">
									<img
										class="card-img"
										:src="'/storage/' + product.productImage"
										width="100%"
										alt="image of product"
									/>
								</div>
								<div class="content">
									<h4 class="card-title">{{ product.productTitle }}</h4>
									<p>
										<strong>Ksh.</strong>
										{{ product.productPrice | threeDigitsCoversion }}
									</p>
									<span>
										<strong>Quantity :</strong>
									</span>
									<input
										type="number"
										class="form-control"
										placeholder="-----"
										v-model.number="product.qty"
										min="1"
										v-on:change="$emit('changeqty', product.productId + `-` + $event.target.value)"
									/>
									<button
										type="button"
										class="btn btn-danger float-right"
										@click="$emit(`remove-from-cart`,product.productId)"
									>Remove</button>
								</div>
							</div>
						</div>
					</div>
					<div class="card text-center" v-if="carts.length == 0">
						<div class="card-body">
							<h1 class="card-title">Empty Cart</h1>
							<p class="card-text">
								There are no products in your cart.
								<router-link to="/">Click here to return &nbsp;</router-link>to products page and select a product.
							</p>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "cart",
	model: {
		prop: "input",
		event: "change"
	},
	props: {
		carts: {
			type: Array,
			required: true
		},
		products: {
			type: Array,
			required: true
		},
		totals: {
			type: Number,
			required: true
		}
	},
	data() {
		return {};
	},
	mounted() {
		//hides the menu toggle icons for pages other than the all products page
		this.$emit("active-category", "all");
		this.$emit("hide-cat", true);
	},
	methods: {
		// updateQuantity(value) {
		// 	this.$emit("changeqty", value);
		// },
		remove_cart(id) {
			this.$emit("remove-from-cart", id);
		},
		checkout() {
			try {
				// if (localStorage.getItem("userLogged")) {
				return this.$router.push({ name: "checkout" });
				// }

				// return this.$router.push({ name: "customer-login" });
			} catch (e) {
				localStorage.removeItem("userLogged");
				window.location.reload();
				// return this.$router.push({ name: "customer-login" });
			}
		}
	},
	computed: {
		selectedProducts() {
			let selProducts = [];

			this.products.forEach(product => {
				this.carts.forEach(cart => {
					if (product.productId == cart.id) {
						selProducts.push(product);
					}
				});
			});
			return selProducts;
		},
		sumTotal() {
			// const arrSum = arr => arr.reduce((a, b) => a + b, 0);
			return roundToTwoDecimals(this.totals).toLocaleString();
			// return this.totals.reduce((a, b) => a + b, 0);
		}
	}
};

function roundToTwoDecimals(num) {
	return +(Math.round(num + "e+2") + "e-2");
}
</script>

<style lang="scss" scoped>
</style>
