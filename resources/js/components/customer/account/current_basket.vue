<template>
	<div>
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-12">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" style="width: 100%;">
							<thead class="theade-light">
								<tr>
									<th class="tb-no" style>#</th>
									<th>Order ID</th>
									<th>Image</th>
									<th>Product Title</th>
									<th>Price</th>
									<th>QTY</th>
									<th>Totals</th>
									<th>Status</th>
									<th>Updated On</th>
									<th class="tb-ac"></th>
								</tr>
							</thead>
							<tbody ref="tableBody">
								<tr v-for="(order,index) in listOrders" :key="index">
									<th class="tb-no">{{ index + 1 }}</th>
									<td class="tb-id">{{ order.orderNo }}</td>
									<td style="width: 100px">
										<img class="img-fluid" :src="`/storage/${order.image}`" />
									</td>
									<td>{{ order.title }}</td>
									<td>{{ order.price | threeDigitsCoversion }}</td>
									<td>{{ order.qty | threeDigitsCoversion }}</td>
									<td>{{ order.totals | threeDigitsCoversion }}</td>
									<td v-if="order.status == 'complete'" class="text-success">{{ order.status }}</td>
									<td v-else-if="order.status == 'cancelled'" class="text-danger">{{ order.status }}</td>
									<td v-else style="color: #ffc107">{{ order.status }}</td>
									<td>{{ order.updated_at | changeDateFormat }}</td>
									<td class="pd-action">
										<span class="icon ico-cancel" @click="cancelOrder(order.orderNo)">Cancel</span>
										<!-- <span class="icon ico-edit" @click="editOrder(order.orderNo)">Edit</span> -->
									</td>
								</tr>
								<tr v-if="emptyOrder">
									<td class="text-center" colspan="10">
										<h3 class="text-danger">Empty basket</h3>
										<router-link to="/">click here</router-link>to go to products page.
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "current_basket",
	data() {
		return {
			listOrders: [],
			checkedOrders: [],
			selectedOrder: []
		};
	},
	mounted() {
		this.getCurrentBasket();
	},
	methods: {
		getCurrentBasket() {
			axios
				.get("/purchases/current")
				.then(response => {
					this.listOrders = response.data.orders;
				})
				.catch(error => {
					// console.log(error)
					this.errorMessages(error);
				});
		},
		closeModal() {
			this.editOrderModal = false;
			// this.addOrder = false;
			this.$emit("modal-control", "");
			this.errors = "";
		},
		cancelOrder(id) {
			// console.log(id);

			axios
				.post("order/cancel", { order: id })
				.then(response => {
					// this.selectedOrder = response.data;
					if (response.data.cancelled) {
						window.location.reload();
					}
				})
				.catch(response => {
					this.errorMessages(error);
				});
		},
		editOrder(id) {
			let order_index = null;
			this.orderLists.forEach((order, key) => {
				if (order.orderId == id) {
					order_index = key;
				}
			});

			this.editOrderList = this.orderLists[order_index];

			this.editOrderModal = true;
			this.$emit("modal-control", "modal-open");
		},
		updateOrder(val) {
			axios
				.put("/orders/" + val.id, val)
				.then(response => {
					this.closeModal();
					this.displayMessageFunction(response.data.success, "success");
					// if (response.data.success == 1) {
					// 	this.closeModal();
					// }
				})
				.catch(error => {
					this.errorMessages(error);
					this.errors = error.response.data.errors;
				});
		},
		deleteOrder() {
			let listArray = [];

			if (this.checkedOrders === true) {
				this.orderLists.forEach(element => {
					listArray.push(element.id);
				});
			} else {
				this.checkedOrders.forEach(element => {
					listArray.push(this.orderLists[element].id);
				});
			}

			if (listArray.length < 1) {
				return this.displayMessageFunction(
					"Select at least one field to delete !!!!",
					"alert-danger"
				);
				// this.alertClass = "alert-danger";
				// this.dispMes = true;
				// return (this.displayMessage =
				// 	"Please select at least one field to delete !!!!");
			}

			if (confirm("Are you sure you want to delete?")) {
				axios
					.delete(`/orders/${listArray}`)
					.then(response => {
						if (this.checkedOrders === true) {
							this.orderLists = [];
							this.checkedOrders = [];
						} else {
							this.checkedOrders
								.sort()
								.reverse()
								.forEach(element => {
									this.orderLists.splice(element, 1);
									this.checkedOrders = [];
								});
						}

						this.displayMessageFunction(response.data.success, "alert-success");
					})
					.catch(error => {
						this.errorMessages(error);
						this.displayMessageFunction(
							error.response.data.message,
							"alert-danger"
						);
					});
			}
		},
		displayMessageFunction(message, color) {
			this.alertClass = color;
			this.$refs.displayMessage.innerText = message;
			this.dispMes = true;

			if (color !== "alert-danger") {
				setTimeout(() => {
					this.dispMes = false;
					this.$refs.displayMessage.innerText = "";
					this.alertClass = "";
				}, 1000);
			}
		},
		checkAllCheckboxes() {
			if (this.checkedOrders === true) {
				return (this.checkedOrders = []);
			}

			return (this.checkedOrders = true);
		},
		checkboxStatus(index) {
			if (this.checkedOrders === true) {
				this.checkedOrders = [];
				this.checkedOrders.push(index);
			}
		},
		errorMessages(error) {
			if (error.response.data.message == "CSRF token mismatch.") {
				return window.location.reload();
			}

			if (error.response.data.message == "Unauthenticated.") {
				localStorage.removeItem("userInfo");
				this.$emit("logged-in", false);
				// return this.$router.push({ name: "customer-login" });
				return this.setCustomPaths();
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
		emptyOrder() {
			setTimeout(() => {
				return this.listOrders.length === 0 ? true : false;
			}, 1000);
		}
	}
};
</script>
