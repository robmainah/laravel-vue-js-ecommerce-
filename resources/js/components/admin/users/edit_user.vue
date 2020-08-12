<template>
	<div>
		<!-- <transition name="modal-fade"> -->
		<div
			class="modal fade"
			id="edit_user"
			ref="edit_user"
			tabindex="-1"
			role="dialog"
			aria-labelledby="EditUser"
			aria-describedby="edit user"
			aria-hidden="true"
		>
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">
							Edit
							<strong>{{ editUser.title }}'s</strong>
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
										<label for="name">Name</label>
										<input
											type="text"
											class="form-control"
											:class="{'is-invalid':errors.name}"
											:value="editUser.name"
											@input="updateUser('name', $event)"
											placeholder="Enter full name"
										/>
										<small class="invalid-feedback" v-if="errors.name">{{ errors.name[0] }}</small>
									</div>
									<div class="form-group">
										<label for="name">Email</label>
										<input
											type="text"
											class="form-control"
											:class="{'is-invalid':errors.email}"
											:value="editUser.email"
											@input="updateUser('email', $event)"
											placeholder="Enter valid email"
										/>
										<small class="invalid-feedback" v-if="errors.email">{{ errors.email[0] }}</small>
									</div>
									<div class="form-group">
										<label for="name">Phone Number</label>
										<input
											type="text"
											class="form-control"
											:class="{'is-invalid':errors.phoneNumber}"
											:value="editUser.phone_number"
											@input="updateUser('phone_number', $event)"
											placeholder="0712567123"
										/>
										<small class="invalid-feedback" v-if="errors.phoneNumber">{{ errors.phoneNumber[0] }}</small>
									</div>
									<div class="form-group">
										<label for="name">Id Number</label>
										<input
											type="text"
											class="form-control"
											:class="{'is-invalid':errors.idNumber}"
											:value="editUser.idNumber"
											@input="updateUser('idNumber', $event)"
											placeholder="ID Number"
										/>
										<small class="invalid-feedback" v-if="errors.idNumber">{{ errors.idNumber[0] }}</small>
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<label for="name">Date of Birth</label>
										<input
											type="date"
											class="form-control"
											:class="{'is-invalid':errors.dateOfBirth}"
											:value="editUser.dateOfBirth"
											@input="updateUser('dateOfBirth', $event)"
											placeholder="MM/DD/YYYY"
										/>
										<small class="invalid-feedback" v-if="errors.dateOfBirth">{{ errors.dateOfBirth[0] }}</small>
									</div>
									<div class="form-group">
										<label for="name">Gender</label>
										<select
											class="custom-select mr-sm-2"
											:class="{'is-invalid':errors.gender}"
											:value="editUser.gender"
											@input="updateUser('gender', $event)"
										>
											<option disabled value>Select Gender</option>
											<option value="male">Male</option>
											<option value="female">Female</option>
											<option value="none">Choose not to pick one</option>
										</select>
										<small class="invalid-feedback" v-if="errors.gender">{{ errors.gender[0] }}</small>
									</div>
									<div class="form-group">
										<label for="Active Status">Active Status</label>
										<select
											class="custom-select mr-sm-2"
											:class="{'is-invalid':errors.active}"
											:value="editUser.active"
											@input="updateUser('active', $event)"
										>
											<option disabled value>Select Active Status</option>
											<option value="1">Active</option>
											<option value="0">Inactive</option>
										</select>
										<small class="invalid-feedback" v-if="errors.active">{{ errors.active[0] }}</small>
									</div>
									<div class="form-group">
										<label for="roles">Permission Roles</label>
										<select
											class="custom-select mr-sm-2"
											:class="{'is-invalid':errors.roles}"
											:value="editUser.roles"
											@input="updateUser('roles', $event)"
										>
											<option disabled value>Select Permission Roles</option>
											<option value="1">Super Administrator</option>
											<option value="2">Administrator</option>
											<option value="3">Finance</option>
											<option value="4">Content Developer</option>
											<option value="5">User</option>
										</select>
										<small class="invalid-feedback" v-if="errors.roles">{{ errors.roles[0] }}</small>
									</div>
								</div>
							</div>
							<!-- <div class="modal-footer">
								<button type="submit" class="btn btn-primary">Save</button>
								<button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
							</div>-->
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
export default {
	name: "edit_user",
	props: ["selectedUser"],
	data() {
		return {
			// editUser: {}
			// show_modal: this.$store.state.showModal
		};
	},
	methods: {
		update() {
			// console.log();
			this.$store.dispatch("updateUser", this.selectedUser);
			// this.$store.dispatch("updateUser", this.selectedUser);
		},
		updateUser(key, event) {
			// console.log("editing.......");
			return this.$store.commit("EDIT_USER_INPUT", [key, event.target.value]);
		},
		closeModal() {
			let element = this.$refs.edit_user;
			$(element).modal("hide");
		}
	},
	computed: {
		errors() {
			return this.$store.state.errors;
		},
		editUser() {
			const dob = this.$store.state.users[this.selectedUser].dateOfBirth;
			const year = new Date(dob).getFullYear();
			const month = ("0" + (new Date(dob).getMonth() + 1)).slice(-2);
			const date = ("0" + new Date(dob).getDate()).slice(-2);

			let userData = {
				dateOfBirth: year + "-" + date + "-" + month,
				email: this.$store.state.users[this.selectedUser].email,
				gender: this.$store.state.users[this.selectedUser].gender,
				id: this.$store.state.users[this.selectedUser].id,
				idNumber: this.$store.state.users[this.selectedUser].idNumber,
				name: this.$store.state.users[this.selectedUser].name,
				phone_number: this.$store.state.users[this.selectedUser].phone_number,
				roles: this.$store.state.users[this.selectedUser].roles,
				active: this.$store.state.users[this.selectedUser].active,
				userId: this.$store.state.users[this.selectedUser].userId
			};

			return userData;
		},
		showModal() {
			if (this.$store.state.showModal == false) {
				return this.closeModal();
			}

			return true;
		}
	}
};
</script>

<style lang="scss" scoped>
label {
	font-weight: bold;
}

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
</style>
