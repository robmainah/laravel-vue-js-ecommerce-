<template>
	<div>
		<!-- <transition name="modal-fade"> -->
		<div
			class="modal fade show"
			role="dialog"
			id="edit_customer"
			ref="edit_customer"
			aria-labelledby="modaleditCustomer"
			aria-describedby="edit Customer"
			tabindex="-1"
			aria-hidden="true"
		>
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">
							<strong>Update customers Details</strong>
						</h5>
						<button type="button" class="close" @click="closeModal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<form @submit.prevent="update">
						<div class="modal-body">
							<div class="row">
								<div class="col-6">
									<div class="form-group">
										<label for="name">Image</label>
										<div style="height: 122px;">
											<img
												class="img-responsive img-circle img-fluid"
												:src="'/storage/' + editCustomer.image"
												style="height: 100%;"
											/>
											<!-- <input type="file" class="label-control" :class="{'is-invalid':errors.image}" /> -->
											<!-- <small class="invalid-feedback" v-if="errors.image">{{ errors.image[0] }}</small> -->
										</div>
									</div>
									<div class="form-group">
										<label for="id">Customer ID</label>
										<input type="text" class="form-control" disabled :value="editCustomer.customerId" />
									</div>
									<div class="form-group">
										<label for="email">Name</label>
										<input
											type="text"
											class="form-control"
											:class="{'is-invalid':errors.name}"
											:value="editCustomer.name"
											@input="updateCust('name', $event)"
										/>
										<small class="invalid-feedback" v-if="errors.name">{{ errors.name[0] }}</small>
									</div>
									<div class="form-group">
										<label for="email">Email</label>
										<input
											type="text"
											class="form-control"
											:class="{'is-invalid':errors.email}"
											:value="editCustomer.email"
											@input="updateCust('email', $event)"
										/>
										<small class="invalid-feedback" v-if="errors.email">{{ errors.email[0] }}</small>
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<label for="email">ID Number</label>
										<input
											type="text"
											class="form-control"
											:class="{'is-invalid':errors.idNumber}"
											:value="editCustomer.idNumber"
											@input="updateCust('idNumber', $event)"
										/>
										<small class="invalid-feedback" v-if="errors.idNumber">{{ errors.idNumber[0] }}</small>
									</div>
									<div class="form-group">
										<label for="name">Phone Number</label>
										<input
											type="text"
											class="form-control"
											:class="{'is-invalid':errors.phone_number}"
											:value="editCustomer.phone_number"
											@input="updateCust('phone_number', $event)"
										/>
										<small class="invalid-feedback" v-if="errors.phone_number">{{ errors.phone_number[0] }}</small>
									</div>
									<div class="form-group">
										<label for="email">Address</label>
										<input
											type="text"
											class="form-control"
											:class="{'is-invalid':errors.address}"
											:value="editCustomer.address"
											@input="updateCust('address', $event)"
										/>
										<small class="invalid-feedback" v-if="errors.address">{{ errors.address[0] }}</small>
									</div>
									<div class="form-group">
										<label for="name">Gender</label>
										<select
											class="custom-select mr-sm-2"
											:class="{'is-invalid':errors.gender}"
											:value="editCustomer.gender"
											@input="updateCust('gender', $event)"
										>
											<option disabled value>Select Category</option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
										</select>
										<small class="invalid-feedback" v-if="errors.gender">{{ errors.gender[0] }}</small>
									</div>
									<div class="form-group">
										<label for="name">Active Status</label>
										<select
											class="custom-select mr-sm-2"
											:class="{'is-invalid':errors.active}"
											:value="editCustomer.active"
											@input="updateCust('active', $event)"
										>
											<option disabled value>Select Active Status</option>
											<option value="Yes">Yes</option>
											<option value="No">No</option>
										</select>
										<small class="invalid-feedback" v-if="errors.active">{{ errors.active[0] }}</small>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Update</button>
							<button type="button" class="btn btn-secondary" v-if="showModal" @click="closeModal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- </transition> -->
	</div>
</template>

<script>
import { log } from "util";
// import { get } from "https";
export default {
	name: "edit_customer",
	props: ["selectedCustomer"],
	data() {
		return {
			// editCustomer: {}
			// show_modal: this.$store.state.showModal
		};
	},
	methods: {
		update() {
			this.$store.dispatch("updateCustomer", this.selectedCustomer);
		},
		updateCust(key, event) {
			return this.$store.commit("EDIT_CUSTOMER_INPUT", [
				key,
				event.target.value
			]);
		},
		closeModal() {
			let element = this.$refs.edit_customer;
			$(element).modal("hide");
		}
	},
	computed: {
		editCustomer() {
			// console.log(this.$store.state.customers[this.selectedCustomer].name);
			// get() {
			// const show = this.$store.state.showModal;

			// if (show) {
			// 	let element = this.$refs.edit_customer;
			// 	$(element).modal("hide");
			// }
			// console.log(show);

			return this.$store.state.customers[this.selectedCustomer];
			// return this.$store.state.newCustomer;
			// console.log(this.selectedCustomer.name);

			// return this.selectedCustomer;re
			// },
			// set(value) {
			// 	return this.$store.commit("updateCustomer", [this.selectedCustomer, value]);
			// }
		},
		showModal() {
			// console.log(this.$store.state.showModal);

			if (this.$store.state.showModal == false) {
				return this.closeModal();
			}

			return true;
		},
		errors() {
			return [];
		}
	}
};
</script>

<style lang="scss" scoped>
label {
	font-weight: bold;
}
// .modal-backdrop {
// 	position: fixed;
// 	top: 0;
// 	bottom: 0;
// 	left: 0;
// 	right: 0;
// 	background-color: rgba(0, 0, 0, 0.3);
// 	display: flex;
// 	justify-content: center;
// 	align-items: center;
// }

// .modal {
// 	background: #ffffff;
// 	box-shadow: 2px 2px 20px 1px;
// 	overflow-x: auto;
// 	display: flex;
// 	flex-direction: column;
// }
// .modal {
// 	position: fixed;
// 	z-index: 9998;
// 	top: 0;
// 	left: 0;
// 	width: 100%;
// 	height: 100%;
// 	background-color: rgba(0, 0, 0, 0.5);
// 	display: block;
// 	overflow-y: auto !important;
// 	// overflow: hidden;
// 	transition: opacity 0.3s ease;
// }

// .modal-dialong {
// 	display: table-cell;
// 	vertical-align: middle;
// }

// .modal-content {
// 	// width: 300px;
// 	margin: 0px auto;
// 	padding: 20px 30px;
// 	background-color: #fff;
// 	border-radius: 2px;
// 	box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
// 	transition: all 0.3s ease;
// 	font-family: Helvetica, Arial, sans-serif;
// }
</style>
