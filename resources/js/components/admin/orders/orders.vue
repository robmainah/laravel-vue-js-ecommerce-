<template>
	<div class="container-fluid">
		<div class="card">
			<div class="card-header card-hd pt-2 pb-1">
				<div class="pd-title">
					<div class="row">
						<div class="col-sm-5">
							<div>
								<h4 class="float-left">Orders</h4>
							</div>

							<h5 class="text-right">
								<!-- <button type="button" class="btn btn-success px-1 py-1" @click="openAddOrder">
									<i class="fa fa-plus"></i> New
								</button>-->
								<button type="button" class="btn btn-primary px-1 py-1">
									<font-awesome-icon icon="print" />Print
								</button>
								<button type="button" class="btn btn-danger px-1 py-1" @click="deleteOrder()">
									<font-awesome-icon icon="trash" />Delete
								</button>
							</h5>
						</div>
						<div class="col-sm-7">
							<form class="form-inline">
								<label class="sr-only" for="inlineFormInputGroupUsername">Search</label>
								<div class="input-group">
									<input type="text" class="form-control" v-model="searchField" placeholder="Search" />
									<div class="input-group-prepend">
										<div class="input-group-text">
											<!-- <a class="btn btn-primary" href="javascript:;"> -->
											<font-awesome-icon icon="search" />
											<!-- </a> -->
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body">
				<transition name="moveOut">
					<div class="alert alert-dismissible fade show" :class="alertClass" v-show="dispMes">
						<!-- <p ref="displayMessage" class="card-text"></p> -->
						<p ref="displayMessage"></p>
						<button type="button" class="close" aria-label="Close" @click="dispMes = !dispMes">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</transition>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" style="width: 100%;">
						<thead class="theade-light">
							<tr>
								<th class="tb-check">
									<div class="form-check tb-check">
										<input
											class="form-check-input"
											type="checkbox"
											@click="checkAllCheckboxes"
											v-model="checkedOrders"
										/>
										<label class="form-check-label" for="defaultCheck1"></label>
									</div>
								</th>
								<th class="tb-no" style>#</th>
								<th>Order ID</th>
								<!-- <th>Product Title</th> -->
								<!-- <th>prices</th> -->
								<!-- <th>quantity</th> -->
								<th>Totals</th>
								<!-- <th>Quantity</th> -->
								<th>Status</th>
								<th>Entered by</th>
								<th>comments</th>
								<th>last Updated</th>
								<th class="tb-ac"></th>
							</tr>
						</thead>
						<tbody ref="tableBody">
							<tr v-for="(orderList,index) in filteredOrderLists" :key="index">
								<td>
									<div class="form-check tb-check">
										<input
											class="form-check-input"
											type="checkbox"
											:value="index"
											v-on:change="checkboxStatus(index)"
											v-model="checkedOrders"
										/>
										<label class="form-check-label" for="defaultCheck1"></label>
									</div>
								</td>
								<th class="tb-no">{{ index + 1 }}</th>
								<td class="tb-id">{{ orderList.orderId }}</td>
								<!-- <td class="tb-id">{{ orderList.productTitle }}</td> -->
								<!-- <td>{{ orderList.price | threeDigitsCoversion}}</td> -->
								<!-- <td>{{ orderList.quantity }}</td> -->
								<td>{{ orderList.totals | threeDigitsCoversion }}</td>
								<!-- <td>{{ orderList.quantity }}</td> -->
								<td v-if="orderList.status == 'complete'" class="text-success">{{ orderList.status }}</td>
								<td v-else-if="orderList.status == 'incomplete'" class="text-danger">{{ orderList.status }}</td>
								<td v-else style="color: #ffc107">{{ orderList.status }}</td>
								<td>{{ orderList.user_name }}</td>

								<!-- <td v-if="orderList.comments == null">--------</td> -->
								<td :title="orderList.comments">{{ orderList.comments | stringLengthShorten }}</td>

								<td>{{ orderList.updated_at | changeDateFormat }}</td>
								<td class="pd-action">
									<span
										class="icon ico-view"
										data-toggle="modal"
										data-target="#view_order"
										@close="closeModal"
										@click="showOrderModal(orderList.orderId)"
									>view</span>
									<span class="icon ico-edit" @click="editOrder(orderList.orderId)">edit</span>
									<!-- <i class="fa fa-edit" @click="editOrder(index)">edit</i> -->
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<!-- <Addorder
			v-show="addOrder"
			:errors="errors"
			:newOrder="newOrder"
			@new-order="saveOrder"
			@close="closeModal"
		></Addorder>-->
		<Vieworder :selectedOrder="selectedOrder"></Vieworder>
		<Editorder
			v-show="editOrderModal"
			:errors="errors"
			:editOrderList="editOrderList"
			@upd-order="updateOrder"
			@close="closeModal"
		></Editorder>
	</div>
</template>

<script>
// import Addorder from "./add_order.vue";
import Vieworder from "./view_order.vue";
import Editorder from "./edit_order.vue";
// import siteMixins from "../../mixins/mixins";
import { log } from "util";

export default {
	name: "orders",
	data() {
		return {
			editOrderModal: false,
			orderLists: [],
			searchField: "",
			editOrderList: {},
			errors: {},
			checkedOrders: [],
			dispMes: false,
			alertClass: "",
			selectedOrder: []
		};
	},
	components: {
		// Addorder,
		Vieworder,
		Editorder
	},
	mounted() {
		this.getOrders();
	},
	// mixins: [siteMixins],
	methods: {
		getOrders() {
			axios
				.get("/orders")
				.then(response => {
					this.orderLists = response.data;
				})
				.catch(error => {
					// this.unAuthenticatedError();
					this.errorMessages(error);
					// if (error.message == "Request failed with status code 401") {
					// 	return window.location.reload();
					// }
				});
		},
		closeModal() {
			this.editOrderModal = false;
			// this.addOrder = false;
			this.$emit("modal-control", "");
			this.errors = "";
		},
		showOrderModal(id) {
			// this.selectedOrder = this.orderLists[index].orderId;
			// let order_index = null;
			// this.editOrderList.forEach((order, key) => {
			// 	if (order.orderId == id) {
			// 		order_index = key;
			// 	}
			// });

			axios
				.post(`/orders/${id}`)
				.then(response => {
					this.selectedOrder = response.data;
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
				// return this.$router.push({ name: "admin-login" });
				this.setCustomPaths();
				window.location.href = "/admin-login";
				return;
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
		}
	},
	computed: {
		filteredOrderLists() {
			/* let orderItems = {
				id: this.orderLists.id,
				orderId: this.orderLists.orderId,
				order_status: this.orderLists.order_status,
				price: this.orderLists.price,
				productTitle: this.orderLists.productTitle,
				shippingDate: this.orderLists.shippingDate,
				status: this.orderLists.status,
				totals: this.orderLists.totals,
				updated_at: this.orderLists.updated_at,
				user_name: this.orderLists.user_name
			}; */

			return this.orderLists.filter(element => {
				return Object.keys(element).some(key => {
					let string = String(element[key]);

					return string.toLowerCase().match(this.searchField.toLowerCase());
				});
			});
		}
	}
};
</script>

<style lang="scss" scoped>
.moveOut-enter-active,
.moveOut-leave-active {
	animation: fadeIn 0.7s ease-in;
}
.moveOut-enter, .moveOut-leave-to /* .fade-leave-active below version 2.1.8 */ {
	animation: fadeIn 0s ease-in-out;
}
.input-group-text {
	// padding: 0rem;
	color: #fff;
	background-color: #3490dc;
	border-color: #3490dc;
	// border: 0rem;
}
.tb-check {
	width: 0.3%;
}
.tb-no {
	width: 0.7%;
}
.tb-ac {
	width: 8%;
}
.tb-pr {
	width: 5%;
}
.pd-action {
	width: 13%;
}
@media (max-width: 816px) {
	// .pd-action {
	// 	width: 15%;
	// }
}
@media (max-width: 752px) {
	.pd-action {
		min-width: 7rem;
	}
	.tb-no {
		display: none;
	}
	.tb-ac {
		display: none;
	}
	.tb-id {
		display: none;
	}
}
</style>
