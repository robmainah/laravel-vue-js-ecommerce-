<template>
	<div class="container-fluid">
		<div class="card">
			<div class="card-header card-hd pt-2 pb-1">
				<div class="pd-title">
					<div class="row">
						<div class="col-sm-5">
							<div>
								<h4 class="float-left">Users</h4>
							</div>

							<h5 class="text-right">
								<button type="button" class="btn btn-success px-1 py-1" @click="openAddUser">
									<i class="fa fa-plus"></i> New
								</button>
								<button type="button" class="btn btn-primary px-1 py-1">
									<i class="fa fa-print"></i> print
								</button>
								<button type="button" class="btn btn-danger px-1 py-1" @click="deleteUser()">
									<i class="fa fa-trash"></i>Delete
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
											<i class="fa fa-search"></i>
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
								<th class="tb-check" style>
									<div class="form-check tb-check">
										<input
											class="form-check-input"
											type="checkbox"
											@click="checkAllCheckboxes"
											v-model="checkedUsers"
										/>
										<label class="form-check-label" for="defaultCheck1"></label>
									</div>
								</th>
								<th class="tb-no" style>#</th>
								<th>EmployeeID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Active</th>
								<th>Access</th>
								<th class="tb-ac"></th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(user,index) in filteredusers" :key="index">
								<td>
									<div class="form-check tb-check">
										<input
											class="form-check-input"
											type="checkbox"
											:value="index"
											v-on:change="checkboxStatus(index)"
											v-model="checkedUsers"
										/>
										<label class="form-check-label" for="defaultCheck1"></label>
									</div>
								</td>
								<th class="tb-no">{{ index + 1 }}</th>
								<td class="tb-id">{{ user.userId }}</td>
								<td>{{ user.name }}</td>
								<td>{{ user.email }}</td>
								<td>{{ user.active }}</td>
								<td>{{ user.access }}</td>
								<td class="pd-action">
									<i
										class="fa fa-eye"
										data-toggle="modal"
										data-target="#view_category"
										@close="closeModal"
										@click="showUserModal(index)"
									></i>
									<i class="fa fa-edit" @click="editUser(index)"></i>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<!-- <addUser
			v-show="adduser"
			:errors="errors"
			:newUser="newUser"
			@new-user="saveUser"
			@close="closeModal"
		></addUser>-->
		<!-- <viewUser></viewUser>
		<editUser
			v-show="editUserModal"
			:errors="errors"
			:editUserList="editUserList"
			@upd-user="updateUser"
			@close="closeModal"
		></editUser>-->
	</div>
</template>

<script>
import addUser from "./add_user.vue";
import viewUser from "./view_user.vue";
import editUser from "./edit_user.vue";
// import { log } from "util";

export default {
	name: "users",
	data() {
		return {
			adduser: false,
			editUserModal: false,
			users: [],
			searchField: "",
			editUserList: {},
			errors: {},
			checkedUsers: [],
			dispMes: false,
			// displayMessage: "",
			alertClass: "",
			newUser: {
				name: "",
				email: "",
				phoneNumber: "",
				idNumber: "",
				gender: "",
				dateOfBirth: "",
				access: "",
				active: ""
			}
		};
	},
	components: {
		addUser
		// viewUser,
		// editUser
	},
	mounted() {
		axios
			.get("/users")
			// .then(response => console.log(response.data))
			.then(response => (this.users = response.data))
			.catch(error => console.log("failed -- " + error.data));
	},
	methods: {
		openAddUser() {
			this.errors = "";
			this.adduser = !this.adduser;
			this.$emit("modal-control", "modal-open");
		},
		closeModal() {
			this.editUserModal = false;
			this.adduser = false;
			this.$emit("modal-control", "");
			this.errors = "";
		},
		showUserModal(index) {
			this.$children[1].newUser = this.users[index];
		},
		saveUser(val) {
			axios
				.post("/users", val, {
					headers: {
						"Content-Type": "multipart/form-data"
					}
				})
				.then(response => {
					this.adduser = false;
					this.errors = "";
					this.users.push(response.data.addeduser);

					this.newUser.name = "";
					this.newUser.email = "";
					this.newUser.phoneNumber = "";
					this.newUser.idNumber = "";
					this.newUser.gender = "";
					this.newUser.access = "";
					this.newUser.active = "";

					this.displayMessageFunction(response.data.success, "alert-success");
				})
				.catch(error => {
					if (error.response.data.errors == undefined) {
						this.errors = error.response.data;

						return this.displayMessageFunction(
							error.response.data.message,
							"alert-danger"
						);
					}

					return (this.errors = error.response.data.errors);
				});
		},
		editUser(index) {
			this.editUserList = this.users[index];

			this.editUserModal = true;
			this.$emit("modal-control", "modal-open");
		},
		updateUser(val) {
			axios
				.put("/users/" + val.id, val)
				.then(response => {
					if (response.data.success == 1) {
						this.closeModal();
					}
				})
				.catch(error => (this.errors = error.response.data.errors));
		},

		deleteUser() {
			let listArray = [];

			if (this.checkedUsers === true) {
				this.users.forEach(element => {
					// console.log(element.id);

					listArray.push(element.id);
				});
			} else {
				this.checkedUsers.forEach(element => {
					listArray.push(this.users[element].id);
				});
			}

			if (listArray.length < 1) {
				this.alertClass = "alert-danger";
				this.dispMes = true;
				return (this.displayMessage =
					"Please select at least one field to delete !!!!");
			}

			if (confirm("Are you sure you want to delete?")) {
				axios
					.post(`/users/delete`, listArray)
					.then(response => {
						if (this.checkedUsers === true) {
							this.users = [];
							this.checkedUsers = [];
						} else {
							this.checkedUsers
								.sort()
								.reverse()
								.forEach(element => {
									this.users.splice(element, 1);
									this.checkedUsers = [];
								});
						}

						this.displayMessageFunction(response.data.success, "alert-success");
					})
					.catch(error => {
						this.errors = error.response.data.errors;
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
			if (this.checkedUsers === true) {
				return (this.checkedUsers = []);
			}

			return (this.checkedUsers = true);
		},
		checkboxStatus(index) {
			// console.log(this.$refs.checkInput);
			if (this.checkedUsers === true) {
				this.checkedUsers = [];
				this.checkedUsers.push(index);
			}
		}
	},
	computed: {
		filteredusers() {
			return this.users.filter(user => {
				return Object.keys(user).some(key => {
					let string = String(user[key]);
					return string.toLowerCase().match(this.searchField.toLowerCase());
				});
			});
		}
	}
};
</script>

<style lang="scss" scoped>
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
