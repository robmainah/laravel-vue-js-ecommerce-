<template>
	<div class="container-fluid">
		<div class="card">
			<div class="card-header card-hd pt-2 pb-1">
				<div class="pd-title">
					<div class="row">
						<div class="col-sm-5">
							<div>
								<h4 class="float-left">Products</h4>
							</div>

							<h5 class="text-right">
								<button type="button" class="btn btn-success px-1 py-1" @click="openAddProd">
									<i class="fa fa-plus"></i> New
								</button>
								<button type="button" class="btn btn-primary px-1 py-1">
									<font-awesome-icon icon="print" />Print
								</button>
								<button type="button" class="btn btn-danger px-1 py-1" @click="deleteProduct()">
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
								<th class="tb-check" style>
									<div class="form-check tb-check">
										<input
											class="form-check-input"
											type="checkbox"
											@click="checkAllCheckboxes"
											v-model="checkedProducts"
										/>
										<label class="form-check-label" for="defaultCheck1"></label>
									</div>
								</th>
								<th class="tb-no" style>#</th>
								<th>Product ID</th>
								<th>Title</th>
								<th>Price</th>
								<th>In Stock</th>
								<th>Category</th>
								<th>Updated by</th>
								<th>Last Updated</th>
								<th class="tb-ac"></th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(productList,index) in filteredProductLists" :key="index">
								<td>
									<div class="form-check tb-check">
										<input
											class="form-check-input"
											type="checkbox"
											:value="index"
											v-on:change="checkboxStatus(index)"
											v-model="checkedProducts"
										/>
										<label class="form-check-label" for="defaultCheck1"></label>
									</div>
								</td>
								<th class="tb-no">{{ index + 1 }}</th>
								<td>{{ productList.productId }}</td>
								<td>{{ productList.title }}</td>
								<td>{{ productList.price | threeDigitsCoversion}}</td>
								<td>{{ productList.quantity | threeDigitsCoversion }}</td>
								<td class="tb-id">{{ productList.category_id }}</td>
								<td>{{ productList.updated_by }}</td>
								<td>{{ productList.updated_at | changeDateFormat }}</td>
								<td class="pd-action">
									<span
										class="icon ico-view"
										data-toggle="modal"
										data-target="#view_product"
										@close="closeModal"
										@click="showProductModal(productList.id)"
									>view</span>
									<span class="icon ico-edit" @click="editProduct(productList.id)">edit</span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<Addproduct
			v-show="addprod"
			:errors="errors"
			:newProduct="newProduct"
			@new-prod="saveProduct"
			@close="closeModal"
		></Addproduct>
		<Viewproduct></Viewproduct>
		<Editproduct
			v-show="editProdModal"
			:errors="errors"
			:editProdList="editProdList"
			@upd-prod="updateProduct"
			@close="closeModal"
		></Editproduct>
	</div>
</template>

<script>
import Addproduct from "./add_product.vue";
import Viewproduct from "./view_product.vue";
import Editproduct from "./edit_product.vue";
// import { log } from "util";

export default {
	name: "products",
	data() {
		return {
			addprod: false,
			editProdModal: false,
			productLists: [],
			searchField: "",
			editProdList: {},
			errors: {},
			checkedProducts: [],
			dispMes: false,
			// displayMessage: "",
			alertClass: "",
			newProduct: {
				category: "",
				title: "",
				description: "",
				price: "",
				quantity: "",
				image: ""
			}
		};
	},
	components: {
		Addproduct,
		Viewproduct,
		Editproduct
	},
	mounted() {
		this.getProducts();
	},
	methods: {
		getProducts() {
			axios
				.get("/products")
				.then(response => (this.productLists = response.data))
				.catch(error => {
					this.errorMessages(error);
				});
		},
		openAddProd() {
			this.errors = "";
			this.addprod = !this.addprod;
			this.$emit("modal-control", "modal-open");
		},
		closeModal() {
			this.editProdModal = false;
			this.addprod = false;
			this.$emit("modal-control", "");
			this.errors = "";
		},
		showProductModal(id) {
			let prod_index = null;
			this.productLists.forEach((product, key) => {
				if (product.id == id) {
					prod_index = key;
				}
			});
			this.$children[1].newProduct = this.productLists[prod_index];
		},
		editProduct(id) {
			let prod_index = null;
			this.productLists.forEach((product, key) => {
				if (product.id == id) {
					prod_index = key;
				}
			});

			this.editProdList = this.productLists[prod_index];

			this.editProdModal = true;
			this.$emit("modal-control", "modal-open");
		},
		saveProduct(val) {
			axios
				.post("/products", val, {
					headers: {
						"Content-Type": "multipart/form-data"
					}
				})
				.then(response => {
					this.addprod = false;
					this.errors = "";
					this.productLists.push(response.data.addedProduct);

					this.newProduct.category = "";
					this.newProduct.title = "";
					this.newProduct.description = "";
					this.newProduct.price = "";
					this.newProduct.quantity = "";
					this.newProduct.image = "";
					// this.newProduct.imageAlt = "";

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

					this.errorMessages(error);

					return (this.errors = error.response.data.errors);
				});
		},
		updateProduct(val) {
			axios
				.post("/products/update", val, {
					headers: {
						"Content-Type": "multipart/form-data"
					}
				})
				.then(response => {
					if (response.data.success == "Product updated successfully") {
						// this.alertClass = "alert-success";
						// this.displayMessage = "Product updated successfully.";
						// this.dispMes = true;
						this.displayMessageFunction(response.data.success, "alert-success");
						return this.closeModal();
					}
				})
				.catch(error => {
					this.errorMessages(error);
					this.errors = error.response.data.errors;
				});
		},
		deleteProduct() {
			let listArray = [];

			if (this.checkedProducts === true) {
				this.productLists.forEach(element => {
					listArray.push(element.id);
				});
			} else {
				this.checkedProducts.forEach(element => {
					listArray.push(this.productLists[element].id);
				});
			}

			if (listArray.length < 1) {
				return this.displayMessageFunction(
					"Select at least one field to delete !!!!",
					"alert-danger"
				);
			}

			if (confirm("Are you sure you want to delete?")) {
				axios
					// .delete(`/orders/${listArray}`)
					.delete(`/products/${listArray}`)
					// .post(`/products/delete`, listArray)
					.then(response => {
						if (this.checkedProducts === true) {
							this.productLists = [];
							this.checkedProducts = [];
						} else {
							this.checkedProducts
								.sort()
								.reverse()
								.forEach(element => {
									this.productLists.splice(element, 1);
									this.checkedProducts = [];
								});
						}

						this.displayMessageFunction(response.data.success, "alert-success");
					})
					.catch(error => {
						this.errorMessages(error);
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
				}, 2000);
			}
		},
		checkAllCheckboxes() {
			if (this.checkedProducts === true) {
				return (this.checkedProducts = []);
			}

			return (this.checkedProducts = true);
		},
		checkboxStatus(index) {
			if (this.checkedProducts === true) {
				this.checkedProducts = [];
				this.checkedProducts.push(index);
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
		filteredProductLists() {
			return this.productLists.filter(product => {
				return Object.keys(product).some(key => {
					let string = String(product[key]);
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
