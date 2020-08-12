<template>
	<div class="chk-ma">
		<div class="row">
			<div class="col-md-8 offset-2">
				<div class="card ch-space">
					<div class="card-body">
						<h3>
							<strong>Products Summary</strong>
							<span class="float-right" v-show="!emptyCart">
								<router-link to="cart">Edit</router-link>
							</span>
						</h3>
						<div class="card border-0">
							<section class="ca-prod" v-for="(product,index) in selectedProducts" :key="index">
								<div class="card-body">
									<div class="image card-img">
										<img
											class="card-img"
											:src="'/storage/' + product.productImage"
											width="100%"
											alt="image of product"
										/>
									</div>
									<div class="chk content">
										<h4 class="card-title">{{ product.productTitle }}</h4>
										<p>
											<strong>Ksh.</strong>
											{{ product.productPrice | threeDigitsCoversion }}
										</p>
										<p>
											<strong>Quantity :</strong>
											<span>{{ product.qty }}</span>
										</p>
										<p>
											<strong>Total :</strong>
											<span>
												<strong>Ksh.</strong>
												{{ Number(product.qty) * Number(product.productPrice) | threeDigitsCoversion }}
											</span>
										</p>
									</div>
								</div>
							</section>
							<section class="mt-5 my-5 text-center" v-show="emptyCart">
								<h2 class="card-title" style="color: rgba(225, 10, 10, 0.7)">Empty Cart</h2>
								<p class="card-text">
									There are no products in your cart.
									<router-link to="/">Click here to select &nbsp;</router-link>products page and select a product.
								</p>
							</section>
						</div>
						<h2 class="totals text-center" v-show="totals > 0">
							<strong>Total:</strong>
							<span>Ksh.{{ totals | threeDigitsCoversion }}</span>
						</h2>
					</div>
				</div>
				<div class="card ch-space">
					<div class="card-body">
						<h3 class="mb-3">
							<strong>Shipping details</strong>
						</h3>
						<section>
							<dl>
								<dt>Name:</dt>
								<dd>{{ customerData.name }}</dd>
								<dt>Email:</dt>
								<dd>{{ customerData.email }}</dd>
								<dt>Phone Number:</dt>
								<dd>{{ customerData.phone_number }}</dd>
								<dt>Address:</dt>
								<dd>{{ customerData.address }}</dd>
							</dl>
						</section>
					</div>
				</div>
				<div class="card ch-space">
					<div class="card-body">
						<section>
							<h3 class="mb-3">
								<strong>Payment details</strong>
							</h3>
							<!-- <div class="custom-control custom-radio">
								<input type="radio" id="mpesa" name="payment" class="custom-control-input" />
								<label class="custom-control-label" for="mpesa">M-pesa</label>
								<blockquote>
									<p>Payment can be made using this method and accepts using Eazzy, Airtel money and M-pesa.</p>
								</blockquote>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" id="paypal" name="payment" class="custom-control-input" />
								<label class="custom-control-label" for="paypal">Paypal</label>
								<blockquote>
									<p>You can make payment online using paypal which accepts visa or mastercard payments.</p>
								</blockquote>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" id="cash" name="payment" class="custom-control-input" />
								<label class="custom-control-label" for="cash">Cash on delivery</label>
								<blockquote>
									<p>Payment can be made when you receive the package. However, you should have the full amount without expecting change as our personnel does not carry money.</p>
								</blockquote>
							</div>-->
							<ul class="nav nav-tabs nav-pills" id="payment" role="tablist">
								<li class="nav-item">
									<a
										class="nav-link"
										id="mpesa-tab"
										data-toggle="tab"
										href="#mpesa"
										role="tab"
										aria-controls="mpesa"
										aria-selected="false"
									>M-Pesa</a>
									<!-- <a class="nav-link active" href="/login">Login</a> -->
								</li>
								<li class="nav-item">
									<a
										class="nav-link"
										id="paypal-tab"
										data-toggle="tab"
										href="#paypal"
										role="tab"
										aria-controls="paypal"
										aria-selected="false"
									>PayPal</a>
									<!-- <a class="nav-link" href="register">Register</a> -->
								</li>
								<li
									class="nav-link"
									id="home-tab"
									data-toggle="tab"
									href="#home-tab"
									role="tab"
									aria-controls="home"
									aria-selected="false"
									style="visibility: hidden"
								></li>
							</ul>
							<div class="card-body tab-content" id="paymentContent">
								<div class="tab-pane fade" id="mpesa" role="tabpanel" aria-labelledby="mpesa-tab">
									<form v-on:submit.prevent="mpesaPayment">
										<div class="form-group">
											<input class="form-control" type="text" ref="phoneNumber" placeholder="0700123456" />
											<small id="helpId" class="text-muted">The phone number paying for the purchases</small>
										</div>
										<div class="form-group">
											<button
												class="btn float-right"
												type="submit"
												:class="[ mpesaBtn ? 'btn-success' : 'btn-primary' ]"
												:disabled="paymentBtnDisabled"
												ref="mpesaProcessBtn"
												title="Click to start payment processing"
											>
												<span>
													Continue
													<i class="fa fa-arrow-right"></i>
												</span>
											</button>
										</div>
									</form>
								</div>
								<div class="tab-pane fade" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
									<form v-on:submit.prevent="paypalPayment">
										<div class="form-group">
											<p>Use your paypal account to perform the purchase. If you don't have a paypal account you can create one.</p>
											<button
												class="btn float-right"
												type="submit"
												:class="[ paypalBtn ? 'btn-success' : 'btn-primary' ]"
												:disabled="paymentBtnDisabled"
												ref="paypalProcessBtn"
												title="Click to start payment processing"
											>
												<span>
													Continue
													<i class="fa fa-arrow-right"></i>
												</span>
											</button>
										</div>
									</form>
								</div>
								<div
									class="tab-pane fade show active"
									id="home-tab"
									role="tabpanel"
									aria-labelledby="home-tab"
								>
									<p>Select your preferred mode of payment.</p>
								</div>
							</div>
						</section>
					</div>
					<div class="card-footer">
						<button
							type="button"
							class="btn float-right"
							:class="compOrderBtn"
							:style="[ !transactionComplete ? btnStyles : '' ]"
							:disabled="!transactionComplete"
							@click="confirmOrder"
							ref="completeOrder"
							title="Click to complete the order"
						>
							Complete
							<i class="fa fa-arrow-right"></i>
						</button>
					</div>
				</div>
				<br />
				<transition name="moveOut">
					<div class="alert alert-dismissible fade show" :class="alertClass" v-show="dispMes">
						<!-- <p ref="displayMessage" class="card-text"></p> -->
						<p ref="displayMessage"></p>
						<button type="button" class="close" aria-label="Close" @click="dispMes = !dispMes">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</transition>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "checkout",
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
		return {
			// clientData: "",
			emptyCart: false,
			paypalBtn: false,
			mpesaBtn: false,
			compOrderBtn: "btn-warning",
			paymentBtnDisabled: false,
			transactionComplete: true,
			dispMes: false,
			alertClass: "alert-danger",
			// btnStyles: "active"
			btnStyles: {
				color: "rgba(19, 59, 230, 0.26)",
				backgroundColor: "rgba(255, 237, 74, 0.34)"
			}
		};
	},
	methods: {
		confirmOrder() {
			this.$refs.completeOrder.innerHTML =
				"<span>Processing... <i class='fa fa-spinner fa-pulse' style='font-size: 1.5rem;'></i></span>";
			this.compOrderBtn = true;
			this.$refs.completeOrder.title = "Processing please wait......";

			let orderList = [];
			this.carts.forEach(element => {
				//add items in cart to an array that sends them to server for processing
				let items = {
					prodId: element.id,
					qty: element.qty
					// user: localStorage.getItem("userLogged")
				};

				orderList.push(items);
			});

			//send the array to the server
			axios
				.post("complete_order", orderList)
				.then(response => {
					if (response.data.success === "success") {
						this.compOrderBtn = "btn-success";
						this.$refs.mpesaProcessBtn.innerHTML =
							"<span>Success <i class='fa fa-check'></i></span>";
						this.$emit("cart-empty");
						this.$router.push({ name: "customer_account" });
						// this.$router.push({ name: "order_confirmation" });
						// console.log(response)
					}

					if (response.data.fewStock) {
						let message =
							"There is not enough stock for the product(s). Change your cart quantity and try again.";
						message += "<ul>";

						let stocksList = "";
						for (const stock in response.data.fewStock) {
							stocksList +=
								response.data.fewStock[stock]["title"] +
								" - remove (" +
								response.data.fewStock[stock]["qty"] +
								") items ,";
						}

						stocksList = stocksList.slice(0, -1).split(",");

						for (const item of stocksList) {
							message += `<li>${item}</li>`;
						}
						message += "</ul>";

						return this.displayMessageFunction(message, "alert-danger");
					}
				})
				.catch(error => {
					this.errorMessages(error);

					this.$refs.completeOrder.innerHTML =
						"<span>Failed <i class='fa fa-times'></i></span>";
					this.compOrderBtn = "btn-danger";
					this.$refs.completeOrder.title =
						"Failed...Refresh the page and Try again.";
				});
		},
		mpesaPayment() {
			this.$refs.mpesaProcessBtn.innerHTML =
				"<span>Processing... <i class='fa fa-spinner fa-pulse' style='font-size: 1.5rem;'></i></span>";
			this.paymentBtnDisabled = true;
			this.$refs.mpesaProcessBtn.title = "Processing please wait......";
			// console.log(this.$refs.mpesaProcessBtn);

			axios
				.post("mpesa-create")
				.then(response => {
					this.$refs.mpesaProcessBtn.innerHTML =
						"<span>Success <i class='fa fa-check'></i></span>";
					this.paymentBtnDisabled = false;
					this.$refs.mpesaProcessBtn.title = "Mpesa payment success";
					this.mpesaBtn = true;
					let token = { token: "123456" };
					localStorage.setItem("spacex_orderToken", JSON.stringify(token));

					// console.log(content);
				})
				.catch(error => console.log(error));
		},
		paypalPayment() {
			this.$refs.paypalProcessBtn.innerHTML =
				"<span>Processing... <i class='fa fa-spinner fa-pulse' style='font-size: 1.5rem;'></i></span>";
			this.paymentBtnDisabled = true;
			this.$refs.paypalProcessBtn.title = "Processing please wait......";

			axios
				.post("paypal-create")
				.then(response => {
					console.log(response);
					this.$refs.paypalProcessBtn.innerHTML =
						"<span>Success <i class='fa fa-check'></i></span>";
					this.paymentBtnDisabled = false;
					this.$refs.paypalProcessBtn.title = "Mpesa payment success";
					this.paypalBtn = true;
					let token = { token: "123456" };
					localStorage.setItem("spacex_orderToken", JSON.stringify(token));
				})
				.catch(error => {
					console.log(error);
				});
		},
		displayMessageFunction(message, color) {
			this.alertClass = color;
			this.$refs.displayMessage.innerHTML = message;
			this.dispMes = true;

			if (color !== "alert-danger") {
				setTimeout(() => {
					this.dispMes = false;
					this.$refs.displayMessage.innerHTML = "";
					this.alertClass = "";
				}, 2000);
			}
		},
		errorMessages(error) {
			// console.log(error);

			if (error.response.data.message == "CSRF token mismatch.") {
				return window.location.reload();
			}

			if (error.response.data.message == "Unauthenticated.") {
				localStorage.removeItem("userInfo");
				this.$emit("logged-in", false);
				// return this.$router.push({ name: "customer-login" });
				this.setCustomPaths();
			}
		},
		setCustomPaths() {
			// const currentPath = this.$route.path;
			const currentPaths = {
				pathFrom: this.$route.path,
				next: this.$route.path
			};

			const setPaths = JSON.stringify([currentPaths]);
			localStorage.setItem("redirectPathsName", setPaths);

			return (window.location.href = "/customer-login");
		}
	},
	computed: {
		selectedProducts() {
			let selProducts = [];

			this.products.forEach(product => {
				this.carts.forEach(cart => {
					if (product.productId == cart.id) {
						let item = {
							productId: product.productId,
							productTitle: product.productTitle,
							productImage: product.productImage,
							productAlt: product.productAlt,
							productDescription: product.productDescription,
							productCategory: product.productCategory,
							productPrice: product.productPrice,
							qty: cart.qty
						};
						selProducts.push(item);
					}
				});
			});

			return selProducts;
		},
		customerData() {
			try {
				const info = JSON.parse(localStorage.getItem("userInfo"));
				if (info == null) {
					return [];
				}

				return info;
			} catch (e) {
				localStorage.removeItem("userInfo");
				this.$emit("logged-in", false);
				this.$router.push({ name: "customer_login" });
			}
		}
	}
};
</script>

<style lang="scss" scoped>
#home-tab,
#paypal {
	font-family: Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
	font-size: 1.2rem;
}
.ch-space section {
	font-family: Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
	font-size: 1rem;
}
.ch-space > .card-body > h3 > span {
	margin-right: 1em;
	text-decoration: underline;
	font-size: 1.3rem;
}
.totals {
	padding-top: 1em;
}
.ca-prod {
	border-bottom: 1px solid #dddddd;
}
h3 {
	font-family: Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
	text-decoration: underline;
	color: royalblue;
}
.btn-warning {
	color: #133be6;
	font-weight: bold;
}
.btn-warning:hover {
	background: #38c172;
	border-color: #38c172;
	color: #ffffff;
}
.btn-primary:hover {
	background: #1e1d1dba;
	border-color: #1e1d1dba;
	// background: #38c172;
	// border-color: #38c172;
	color: #ffffff;
}
.ch-space {
	margin-top: 1em;
}
// .custom-control-input:checked ~ .custom-control-label::before {
// 	border-color: #f7de05;
// 	background-color: #f7de05;
// }

// .custom-control-input:focus:not(:checked) ~ .custom-control-label::before {
// 	border-color: #f7de05;
// }
.nav-pills .nav-link.active,
.nav-pills .show > .nav-link {
	color: #4d4a4a;
	background-color: #f7de05;
}
</style>
