<template>
	<div>
		<!-- <transition name="modal-fade"> -->
		<div
			class="modal fade"
			id="addUser"
			ref="add_user"
			tabindex="-1"
			role="dialog"
			aria-labelledby="addUser"
			aria-describedby="addUser"
			aria-hidden="true"
		>
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">
							<strong>Add New User</strong>
						</h5>
						<button type="button" class="close" @click="closeModal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p class="alert alert-danger" v-if="errors.message">{{ errors.message }}</p>
						<form enctype="multipart/form-data" @submit.prevent="save">
							<div class="row">
								<div class="col-6">
									<div class="form-group">
										<label for="name">Name</label>
										<input
											type="text"
											class="form-control"
											:class="{'is-invalid':errors.name}"
											v-model="newUser.name"
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
											v-model="newUser.email"
											placeholder="Enter valid email"
										/>
										<small class="invalid-feedback" v-if="errors.email">{{ errors.email[0] }}</small>
									</div>
									<div class="form-group">
										<label for="name">Phone Number</label>
										<input
											type="text"
											class="form-control"
											:class="{'is-invalid':errors.phone_number}"
											v-model="newUser.phone_number"
											placeholder="0712567123"
										/>
										<small class="invalid-feedback" v-if="errors.phone_number">{{ errors.phone_number[0] }}</small>
									</div>
									<div class="form-group">
										<label for="name">Id Number</label>
										<input
											type="text"
											class="form-control"
											:class="{'is-invalid':errors.idNumber}"
											v-model="newUser.idNumber"
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
											v-model="newUser.dateOfBirth"
											placeholder="MM/DD/YYYY"
										/>
										<small class="invalid-feedback" v-if="errors.dateOfBirth">{{ errors.dateOfBirth[0] }}</small>
									</div>
									<div class="form-group">
										<label for="name">Gender</label>
										<select
											class="custom-select mr-sm-2"
											:class="{'is-invalid':errors.gender}"
											v-model="newUser.gender"
										>
											<option disabled value>Select Gender</option>
											<option value="male">Male</option>
											<option value="female">Female</option>
											<option value="none">Choose not to pick one</option>
										</select>
										<small class="invalid-feedback" v-if="errors.gender">{{ errors.gender[0] }}</small>
									</div>
									<div class="form-group">
										<label for="name">Active Status</label>
										<select
											class="custom-select mr-sm-2"
											:class="{'is-invalid':errors.active}"
											v-model="newUser.active"
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
											v-model="newUser.roles"
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
							<div class="modal-footer">
								<button type="submit" class="btn btn-primary">Save</button>
								<button type="button" class="btn btn-secondary" v-if="showModal" @click="closeModal">Close</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- </transition> -->
	</div>
</template>

<script>
export default {
	name: "add_user",
	// props: ["errors", "newUser"],
	data() {
		return {
			//
		};
	},
	methods: {
		save() {
			let formData = new FormData();
			// formData.append("profilePic", this.newUser.profilePic);
			formData.append("name", this.newUser.name);
			formData.append("email", this.newUser.email);
			formData.append("phone_number", this.newUser.phone_number);
			formData.append("idNumber", this.newUser.idNumber);
			formData.append("gender", this.newUser.gender);
			formData.append("roles", this.newUser.roles);
			formData.append("active", this.newUser.active);
			formData.append("dateOfBirth", this.newUser.dateOfBirth);

			// console.log(this.newUser);
			this.$store.dispatch("addNewUser", formData);
			// this.$emit("new-prod", formData);
		},
		closeModal() {
			// this.editUserModal = false;
			// this.showModal = false;
			// this.$store.commit("showNewUserModal", false);
			// this.$store.commit("CLEAR_ERRORS");
			// this.$emit("modal-control", "");
			// this.errors = "";
			let element = this.$refs.add_user;
			$(element).modal("hide");
		}
		// handleFileUpload() {
		// 	// console.log(this.$refs.image.files[0]);
		// 	this.newUser.image = this.$refs.image.files[0];
		// }
	},
	computed: {
		errors() {
			return this.$store.state.errors;
		},
		newUser() {
			return this.$store.getters.newUser;
		},
		showModal() {
			// console.log(this.$store.state.showModal);

			if (this.$store.state.showModal == false) {
				return this.closeModal();
			}

			return true;
		}
	}
};
</script>

<style lang="scss" scoped>
// .addProduct .close {
// 	opacity: 1;
// 	line-height: 0.5;
// 	font-size: 1.75rem;
// }
// .addProduct .close:hover {
// 	color: red;
// }
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
