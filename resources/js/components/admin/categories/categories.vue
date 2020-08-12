<template>
	<div class="container-fluid">
		<div class="card">
			<div class="card-header card-hd pt-2 pb-1">
				<div class="pd-title">
					<div class="row">
						<div class="col-sm-5">
							<div>
								<h4 class="float-left">Categories</h4>
							</div>

							<h5 class="text-right">
								<button
									type="button"
									class="btn btn-success px-1 py-1"
									data-toggle="modal"
									data-target="#newCategory"
									@click="openAddcat"
								>
									<i class="fa fa-plus"></i> New
								</button>
								<button type="button" class="btn btn-primary px-1 py-1">
									<font-awesome-icon icon="print" />Print
								</button>
								<button type="button" class="btn btn-danger px-1 py-1" @click="deleteCategory()">
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
				<div class="message addCategory alert alert-success" :class="{'d-none':addcat}">
					<form @submit.prevent="saveCategory">
						<button type="button" class="close" @click="addcat = true">
							<i aria-hidden="true">&times;</i>
						</button>
						<div class="row">
							<div class="col-lg col-md col-sm">
								<div class="form-group">
									<label for="inputEmail4">
										<strong>Category Name</strong>
									</label>
									<input
										type="text"
										class="form-control"
										:class="{'is-invalid':errors.category_name}"
										placeholder="Category name"
										v-model.lazy.trim="newCategory.category_name"
									/>
									<small v-if="errors.category_name" class="invalid-feedback">{{ errors.category_name[0] }}</small>
								</div>
							</div>
							<div class="col-md col-sm">
								<div class="form-group">
									<label for="educationLevel">
										<strong>Activated</strong>
									</label>
									<select
										class="custom-select custom-control mr-sm-2"
										:class="{'is-invalid':errors.activated}"
										id="category"
										v-model.lazy.trim="newCategory.activated"
									>
										<option disabled value>Select Activation Status</option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
									<small class="invalid-feedback" v-if="errors.activated">{{ errors.activated[0] }}</small>
								</div>
							</div>
							<div class="col-auto">
								<div class="cat-action-btn">
									<button type="submit" class="btn btn-primary">Save</button>
									<button type="reset" class="btn alert-danger">Reset</button>
								</div>
							</div>
						</div>
					</form>
				</div>
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
											v-model="checkedCategories"
										/>
										<label class="form-check-label" for="defaultCheck1"></label>
									</div>
								</th>
								<th class="tb-no" style>#</th>
								<th class="tb-id">ID</th>
								<th>Category Name</th>
								<th class="tb-ac" style>Active</th>
								<th class="tb-pr" style>Products</th>
								<th>Updated by</th>
								<th>Last Updated</th>
								<th style></th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(categoryList,index) in filteredCategoryLists" :key="index">
								<td>
									<div class="form-check tb-check">
										<input
											class="form-check-input"
											type="checkbox"
											:value="index"
											v-on:change="checkboxStatus(index)"
											v-model="checkedCategories"
										/>
										<label class="form-check-label" for="defaultCheck1"></label>
									</div>
								</td>
								<th class="tb-no">{{ index + 1 }}</th>
								<td class="tb-id">{{ categoryList.categoryId }}</td>
								<td>{{ categoryList.category_name}}</td>
								<td class="tb-ac">{{ categoryList.activated }}</td>
								<td>{{ categoryList.product_count }}</td>
								<td>{{ categoryList.updated_by }}</td>
								<td>{{ categoryList.last_updated }}</td>
								<td class="pd-action">
									<span
										class="icon ico-view"
										data-toggle="modal"
										data-target="#view_category"
										@close="closeModal"
										@click="showCategoryModal(categoryList.categoryId)"
									>view</span>
									<span class="icon ico-edit" @click="editCategory(categoryList.categoryId)">edit</span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<Viewcategory></Viewcategory>
		<Editcategory
			v-show="editCatModal"
			:errors="errors"
			:editCatlList="editCatlList"
			@current_user="updateCategory"
			@close="closeModal"
		></Editcategory>
	</div>
</template>

<script>
import Viewcategory from "./view_category.vue";
import Editcategory from "./edit_category.vue";
import { log } from "util";

export default {
	name: "categories",
	data() {
		return {
			addcat: true,
			editCatModal: false,
			categoryLists: [],
			searchField: "",
			newCategory: {
				id: "",
				category_name: "",
				updated_at: "",
				activated: "",
				products: "",
				user: ""
			},
			editCatlList: {},
			errors: {},
			checkedCategories: [],
			dispMes: false,
			// displayMessage: "",
			alertClass: ""
		};
	},
	components: {
		Viewcategory,
		Editcategory
	},
	mounted() {
		this.getCategories();
	},
	methods: {
		getCategories() {
			axios
				.get("/categories/get")
				.then(response => (this.categoryLists = response.data))
				.catch(error => {
					this.errorMessages(error);
				});
		},
		openAddcat() {
			this.errors = "";
			this.addcat = !this.addcat;
			// this.addcat = true;
		},
		closeModal() {
			this.editCatModal = false;
			this.$emit("modal-control", "");
			this.errors = "";
		},
		showCategoryModal(id) {
			let cat_index = null;
			this.categoryLists.forEach((category, key) => {
				if (category.categoryId == id) {
					cat_index = key;
				}
			});

			this.$children[0].newCategory = this.categoryLists[cat_index];
		},
		editCategory(id) {
			let cat_index = null;
			this.categoryLists.forEach((category, key) => {
				if (category.categoryId == id) {
					cat_index = key;
				}
			});
			this.editCatlList = this.categoryLists[cat_index];
			// document.getElementsByTagName("modal-header").addClass("modal-open");
			this.editCatModal = true;
			this.$emit("modal-control", "modal-open");
		},
		saveCategory() {
			axios
				.post("/categories", this.$data.newCategory)
				.then(response => {
					this.addcat = true;
					this.categoryLists.push(response.data.addedCategory);
					this.errors = "";
					this.newCategory.activated = "";
					this.newCategory.category_name = "";

					if (response.data.errors) {
						return this.displayMessageFunction(
							response.data.errors,
							"alert-danger"
						);
					}

					this.displayMessageFunction(response.data.success, "alert-success");
				})
				.catch(error => {
					if (error.response.data.errors == undefined) {
						this.errors = "";
						return this.displayMessageFunction(
							error.response.data.message,
							"alert-danger"
						);
					}

					this.errorMessages(error);

					return (this.errors = error.response.data.errors);
				});
		},
		updateCategory(val) {
			axios
				.put("/categories/" + val.id, val)
				.then(response => {
					this.closeModal();
					this.errors = "";
					this.newCategory.activated = "";
					this.newCategory.category_name = "";

					if (response.data.errors) {
						return this.displayMessageFunction(
							response.data.errors,
							"alert-danger"
						);
					}

					this.displayMessageFunction(response.data.success, "alert-success");
				})
				.catch(error => {
					if (error.response.data.errors == undefined) {
						this.errors = "";
						return this.displayMessageFunction(
							error.response.data.message,
							"alert-danger"
						);
					}

					this.errorMessages(error);

					return (this.errors = error.response.data.errors);
				});
		},
		deleteCategory() {
			let listArray = [];

			if (this.checkedCategories === true) {
				this.categoryLists.forEach(element => {
					listArray.push(element.id);
				});
			} else {
				this.checkedCategories.forEach(element => {
					listArray.push(this.categoryLists[element].id);
				});
			}

			if (listArray.length < 1) {
				this.alertClass = "alert-danger";
				this.dispMes = true;

				return this.displayMessageFunction(
					"Please select at least one field to delete !!!!",
					"alert-danger"
				);
			}

			if (confirm("Are you sure you want to delete?")) {
				axios
					.post(`/categories/delete`, listArray)
					.then(response => {
						if (this.checkedCategories === true) {
							this.categoryLists = [];
							this.checkedCategories = [];
						} else {
							this.checkedCategories
								.sort()
								.reverse()
								.forEach(element => {
									this.categoryLists.splice(element, 1);
									this.checkedCategories = [];
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
			if (this.checkedCategories === true) {
				return (this.checkedCategories = []);
			}

			return (this.checkedCategories = true);
		},
		checkboxStatus(index) {
			if (this.checkedCategories === true) {
				this.checkedCategories = [];
				this.checkedCategories.push(index);
			}
		},
		errorMessages(error) {
			if (error.response.data.message == "CSRF token mismatch.") {
				return window.location.reload();
			}

			if (error.response.data.message == "Unauthenticated.") {
				localStorage.removeItem("userInfo");
				this.$emit("logged-in", false);

				return this.$router.push({ name: "admin-login" });
			}
			// window.location.href = "/admin-login";
			return this.setCustomPaths();
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
		filteredCategoryLists() {
			return this.categoryLists.filter(category => {
				return Object.keys(category).some(key => {
					let string = String(category[key]);
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
.addCategory .close {
	opacity: 1;
	line-height: 0.5;
	font-size: 1.75rem;
}
.addCategory .close:hover {
	color: red;
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
	.pd-action {
		widtsh: 15%;
	}
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
