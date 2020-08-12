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
								<button
									type="button"
									class="btn btn-success px-1 py-1"
									data-target="#addUser"
									data-backdrop="static"
									data-toggle="modal"
									@click="openAddUser"
								>
									<i class="fa fa-plus"></i> New
								</button>
								<button type="button" class="btn btn-primary px-1 py-1">
									<font-awesome-icon icon="print" />Print
								</button>
								<button type="button" class="btn btn-danger px-1 py-1" @click="deleteUser()">
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
						:class="this.$store.state.displayMessage.alertClass"
						v-show="this.$store.state.displayMessage.status"
					>
						<!-- <p ref="displayMessage" class="card-text"></p> -->
						<p>{{ this.$store.state.displayMessage.text }}</p>
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
								<th>EmployeeID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Active</th>
								<th>Roles</th>
								<th class="tb-ac"></th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(user,index) in filteredUsers" :key="index">
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
								<td class="tb-id">{{ user.userId }}</td>
								<td>{{ user.name }}</td>
								<td>{{ user.email }}</td>
								<td>{{ user.active }}</td>
								<td>{{ user.roles }}</td>
								<td class="pd-action">
									<span
										class="icon ico-view"
										data-toggle="modal"
										data-target="#view_user"
										@close="closeModal"
										@click="viewUserModal(user.userId)"
									>view</span>
									<span
										class="icon ico-edit"
										data-target="#edit_user"
										data-toggle="modal"
										data-backdrop="static"
										@click="editUserModal(user.userId)"
									>edit</span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<addUser v-if="addUser"></addUser>
		<view-user v-if="viewUser" :selected-user="userIndex"></view-user>
		<edit-user v-if="editUser" :selected-user="userIndex"></edit-user>
	</div>
</template>

<script>
import addUser from "./add_user";
import viewUser from "./view_user";
import editUser from "./edit_user";

export default {
	name: "users",
	data() {
		return {
			addUser: false,
			editUser: false,
			viewUser: false,
			// searchField: "",
			userIndex: null,
			emptyUsers: false
		};
	},
	mounted() {
		this.$store.dispatch("loadUsers");
		this.$store.commit("CLEAR_CHECKBOX");
		this.$store.commit("DISPLAY_MESSAGE", { status: false });
	},
	components: { addUser, viewUser, editUser },
	methods: {
		openAddUser() {
			// this.$store.commit("showNewUserModal", true);
			// this.$store.commit("UPDATE_NEW_USER", index);
			this.$store.commit("SHOW_MODAL", true);
			// this.userIndex = index;
			this.addUser = true;
		},
		closeModal() {
			this.$store.commit("DISPLAY_MESSAGE", { status: false });
		},
		checkAllCheckboxes() {
			const element = document.getElementById("allboxes").checked;
			let listArray = [];

			if (element) {
				this.$store.state.users.forEach((element, key) => {
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
			// this.$store.commit("SEARCH_STRING", this.searchField);
			// console.log(event.target.value);

			this.$store.commit("SEARCH_STRING", event.target.value);
		},
		viewUserModal(id) {
			let user_index = null;
			this.$store.state.users.forEach((user, key) => {
				if (user.userId == id) {
					user_index = key;
				}
			});

			this.userIndex = user_index;
			this.viewUser = true;
		},
		editUserModal(id) {
			let user_index = null;
			this.$store.state.users.forEach((user, key) => {
				if (user.userId == id) {
					user_index = key;
				}
			});
			// this.$children[1].newProduct = this.productLists[prod_index];

			this.$store.commit("SELECTED_USER", user_index);
			this.$store.commit("SHOW_MODAL", true);
			this.userIndex = user_index;
			this.editUser = true;
		},
		deleteUser() {
			if (this.$store.state.checkedBoxes.length < 1) {
				return this.$store.commit("DISPLAY_MESSAGE", {
					status: true,
					alertClass: "alert-danger",
					text: "Please select at least one field to delete !!!!"
				});
			}

			if (confirm("Are you sure you want to delete?")) {
				return this.$store.dispatch("deleteUser");
			}
		}
	},
	computed: {
		filteredUsers() {
			setTimeout(() => {
				if (this.$store.getters.getUsers.length === 0) {
					this.emptyUsers = true;
				}
			}, 2000);

			// console.log(this.$store.getters.getUsers);
			// return this.$store.getters.getUsers.filter(user => {
			// 	return Object.keys(user).some(key => {
			// 		let string = String(user[key]);
			// 		return string.toLowerCase().match(this.searchField.toLowerCase());
			// 	});
			// });

			// return this.$store.state.users;
			return this.$store.getters.getUsers;
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
