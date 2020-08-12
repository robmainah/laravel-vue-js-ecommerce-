<template>
	<div>
		<transition name="modal-fade">
			<div class="modal" role="dialog" aria-labelledby="editCategory" aria-describedby="editCategory">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">
								<strong>Add New Product</strong>
							</h5>
							<button type="button" class="close" @click="$emit('close')" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p class="alert alert-danger" v-if="errors.message">{{ errors.message }}</p>
							<form @submit.prevent="save" enctype="multipart/form-data">
								<div class="row">
									<div class="col-6">
										<div class="form-group" id="selectedImage" style="display:none">
											<img src alt width="150px" height="150px" />
											<!-- <p class="help-block"></p> -->
										</div>
										<div class="form-group">
											<label for="image">Image</label>
											<div class="custom-file">
												<input
													type="file"
													class="form-control custom-file-input"
													id="image"
													ref="image"
													v-on:change="handleFileUpload()"
													:class="{'is-invalid':errors.image}"
												/>
												<small class="invalid-feedback" v-if="errors.image">{{ errors.image[0] }}</small>
												<label class="custom-file-label" for="customFile">Choose file</label>
											</div>
										</div>
										<div class="form-group">
											<label for="name">Title</label>
											<input
												type="text"
												class="form-control"
												:class="{'is-invalid':errors.title}"
												v-model="newProduct.title"
												placeholder="Enter the title of the product"
											/>
											<small class="invalid-feedback" v-if="errors.title">{{ errors.title[0] }}</small>
										</div>
										<div class="form-group">
											<label for="name">Price</label>
											<input
												type="text"
												class="form-control"
												:class="{'is-invalid':errors.price}"
												v-model="newProduct.price"
												placeholder="Price of the product E.g. 100"
											/>
											<small class="invalid-feedback" v-if="errors.price">{{ errors.price[0] }}</small>
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="name">Description</label>
											<textarea
												class="form-control"
												:class="{'is-invalid':errors.description}"
												v-model="newProduct.description"
												rows="5"
												style="background-size: 1.5rem;"
												placeholder="Description of the product"
											></textarea>
											<small class="invalid-feedback" v-if="errors.description">{{ errors.description[0] }}</small>
										</div>
										<div class="form-group">
											<label for="name">Quantity</label>
											<input
												type="text"
												class="form-control"
												:class="{'is-invalid':errors.quantity}"
												v-model="newProduct.quantity"
												placeholder="Quantity in stock for the product E.g. 200"
											/>
											<small class="invalid-feedback" v-if="errors.quantity">{{ errors.quantity[0] }}</small>
										</div>
										<div class="form-group">
											<label for="name">Category</label>
											<select
												class="custom-select mr-sm-2"
												:class="{'is-invalid':errors.category}"
												v-model="newProduct.category"
											>
												<option disabled value>Select Category</option>
												<option
													v-for="(category, index) in categories"
													:key="index"
													:value="category.id"
												>{{ category.category_name }}</option>
											</select>
											<small class="invalid-feedback" v-if="errors.category">{{ errors.category[0] }}</small>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary">Save</button>
									<button type="button" class="btn btn-secondary" @click="$emit('close')">Close</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</transition>
	</div>
</template>

<script>
export default {
	name: "add_product",
	props: ["errors", "newProduct"],
	data() {
		return {
			categories: []
		};
	},
	mounted() {
		this.getCategories();
	},
	methods: {
		getCategories() {
			axios
				.get("/categories/get")
				.then(response => {
					this.categories = response.data;
				})
				.catch(error => {
					// console.log(response.data)
					this.errorMessages(error);
				});
		},
		save() {
			let formData = new FormData();
			formData.append("category", this.newProduct.category);
			formData.append("title", this.newProduct.title);
			formData.append("description", this.newProduct.description);
			formData.append("price", this.newProduct.price);
			formData.append("quantity", this.newProduct.quantity);
			formData.append("image", this.newProduct.image);

			this.$emit("new-prod", formData);
		},
		handleFileUpload() {
			// console.log(this.$refs.image.files[0]);
			const imgPreview = document.getElementById("selectedImage");
			const imgRef = this.$refs.image.files[0];
			imgPreview.firstChild.src = window.URL.createObjectURL(imgRef);
			imgPreview.style.display = "block";
			// const imgName = imgRef.name.substr(0, imgRef.name.lastIndexOf("."));
			// img.lastChild.innerHTML = imgName;
			// console.log(imgRef.name.substr(0, imgRef.name.lastIndexOf(".")));

			this.newProduct.image = imgRef;
		},
		errorMessages(error) {
			if (error.response.data.message == "CSRF token mismatch.") {
				return window.location.reload();
			}

			if (error.response.data.message == "Unauthenticated.") {
				localStorage.removeItem("userInfo");
				return this.$router.push({ name: "admin-login" });
			}
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

.modal {
	position: fixed;
	z-index: 9998;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background-color: rgba(0, 0, 0, 0.5);
	display: block;
	overflow-y: auto !important;
	// overflow: hidden;
	transition: opacity 0.3s ease;
}
</style>
