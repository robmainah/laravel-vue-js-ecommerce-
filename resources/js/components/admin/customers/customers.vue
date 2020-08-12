<template>
	<div class="container-fluid">
		<div class="card">
			<div class="card-header card-hd pt-2 pb-1">
				<div class="pd-title">
					<div class="row">
						<div class="col-sm-5">
							<div>
								<h4 class="float-left">Customers</h4>
							</div>

							<h5 class="text-right">
								<!-- <button type="button" class="btn btn-success px-1 py-1" @click="openAddUser">
									<i class="fa fa-plus"></i> New
								</button>-->
								<button type="button" class="btn btn-primary px-1 py-1">
									<font-awesome-icon icon="print" />Print
								</button>
								<button type="button" class="btn btn-danger px-1 py-1" @click="deleteCustomer()">
									<font-awesome-icon icon="trash" />Delete
								</button>
							</h5>
						</div>
						<div class="col-sm-7">
							<form class="form-inline">
								<label class="sr-only" for="inlineFormInputGroupUsername">Search</label>
								<div class="input-group">
									<input
										type="text"
										class="form-control"
										@input="searchInput($event)"
										:value="searchField"
										placeholder="Search"
									/>
									<div class="input-group-prepend">
										<div class="input-group-text">
											<font-awesome-icon icon="search" />
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
					<div
						class="alert alert-dismissible fade show"
						:class="displayMessage.alertClass"
						v-show="displayMessage.status"
					>
						<!-- <p ref="displayMessage" class="card-text"></p> -->
						<p>{{ displayMessage.text }}</p>
						<button type="button" class="close" aria-label="Close" @click="closeModal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</transition>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" style="width: 100%;">
						<thead class="theade-light">
							<tr>
								<th class="tb-check" style>
									<div class="form-check tb-check">
										<input
											class="form-check-input"
											id="allboxes"
											type="checkbox"
											@click="checkAllCheckboxes()"
										/>
										<label class="form-check-label" for="defaultCheck1"></label>
									</div>
								</th>
								<th class="tb-no" style>#</th>
								<th>CustomerID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Id Number</th>
								<th>Phone No</th>
								<th>Active</th>
								<th class="tb-ac"></th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(customer,index) in filteredCustomers" :key="index">
								<td>
									<div class="form-check tb-check">
										<input
											class="form-check-input"
											type="checkbox"
											:value="index"
											@click="checkboxStatus(index)"
										/>
										<label class="form-check-label" for="defaultCheck1"></label>
									</div>
								</td>
								<th class="tb-no">{{ index + 1 }}</th>
								<td class="tb-id">{{ customer.customerId }}</td>
								<td>{{ customer.name }}</td>
								<td>{{ customer.email }}</td>
								<td>{{ customer.idNumber }}</td>
								<td>{{ customer.phone_number }}</td>
								<td>{{ customer.active }}</td>
								<td class="pd-action">
									<span
										class="icon ico-view"
										data-toggle="modal"
										data-target="#view_customer"
										@click="viewCustomerModal(customer.customerId)"
									>view</span>
									<span
										class="icon ico-edit"
										data-toggle="modal"
										data-backdrop="static"
										data-keyboard="false"
										data-target="#edit_customer"
										@click="editCustomerModal(customer.customerId)"
									>edit</span>
								</td>
							</tr>
						</tbody>
					</table>
					<!-- <div id="noCustomers" class="noCustomers"></div> -->
					<div v-if="emptyCustomers" class="noCustomers">
						<div class="alert alert-danger fade show">
							<p ref="displayMessage" class="card-text"></p>
							<p>Empty Customers Database !!!!</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- <addUser v-show="newUserModal"></addUser> -->
		<view-customer v-if="viewCustomer" :selected-customer="customerIndex"></view-customer>
		<edit-customer v-if="editCustomer" :selected-customer="customerIndex"></edit-customer>
	</div>
</template>

<script>
// import addUser from "./edit_customer";
import viewCustomer from "./view_customer";
import editCustomer from "./edit_customer";

export default {
	name: "customers",
	data() {
		return {
			editCustomer: false,
			viewCustomer: false,
			// searchField: "",
			customerIndex: null,
			emptyCustomers: false
		};
	},
	mounted() {
		this.$store.dispatch("loadCustomers");
		this.$store.commit("CLEAR_CHECKBOX");
		this.$store.commit("DISPLAY_MESSAGE", { status: false });
	},
	components: { viewCustomer, editCustomer },
	methods: {
		closeModal() {
			this.$store.commit("DISPLAY_MESSAGE", { status: false });
		},
		checkAllCheckboxes() {
			const element = document.getElementById("allboxes").checked;
			let listArray = [];

			if (element) {
				this.$store.state.customers.forEach((element, key) => {
					listArray.push(key);
				});
			}

			if (listArray.length > 0) {
				this.$store.commit("DISPLAY_MESSAGE", { status: false });
			}

			return this.$store.commit("CHECK_ALL_BOXES", listArray);
		},
		checkboxStatus(index) {
			this.$store.commit("CHECK_BOXES", index);
			this.$store.commit("DISPLAY_MESSAGE", { status: false });
		},
		searchInput(event) {
			this.$store.commit("SEARCH_STRING", event.target.value);
		},
		viewCustomerModal(id) {
			let cust_index = null;
			this.$store.state.customers.forEach((customer, key) => {
				if (customer.customerId == id) {
					cust_index = key;
				}
			});

			this.customerIndex = cust_index;
			this.viewCustomer = true;
		},
		editCustomerModal(id) {
			let cust_index = null;
			this.$store.state.customers.forEach((customer, key) => {
				if (customer.customerId == id) {
					cust_index = key;
				}
			});

			this.$store.commit("SELECTED_CUSTOMER", cust_index);
			this.$store.commit("SHOW_MODAL", true);
			this.customerIndex = cust_index;
			this.editCustomer = true;
		},
		deleteCustomer() {
			if (this.$store.state.checkedBoxes.length < 1) {
				return this.$store.commit("DISPLAY_MESSAGE", {
					status: true,
					alertClass: "alert-danger",
					text: "Please select at least one field to delete !!!!"
				});
			}

			if (confirm("Are you sure you want to delete?")) {
				return this.$store.dispatch("deleteCustomer");
			}
		}
	},
	computed: {
		filteredCustomers() {
			setTimeout(() => {
				if (this.$store.getters.getCustomers.length === 0) {
					this.emptyCustomers = true;
				}
			}, 2000);

			// return this.$store.state.customers;
			return this.$store.getters.getCustomers;
		},
		displayMessage() {
			return this.$store.state.displayMessage;
		},
		searchField() {
			return this.$store.state.searchField;
		}
	}
};
</script>

<style lang="scss" scoped>
.noCustomers {
	width: 70%;
	margin: 70px auto;
}
.noCustomers p {
	font-weight: bold;
	font-size: 1.5rem;
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
