<template>
	<div>
		<transition name="modal-fade">
			<div class="modal" role="dialog" aria-labelledby="editProduct" aria-describedby="editProduct">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Edit Product's Details</h5>
							<button type="button" class="close" @click="$emit('close')" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<div class="modal-body">
							<form>
								<div class="row">
									<div class="col-6">
										<div class="form-group">
											<label for="id">Product ID</label>
											<input type="text" class="form-control" disabled v-model="editProdList.productId" />
										</div>
										<div class="form-group">
											<label for="name">Category</label>
											<select
												class="custom-select mr-sm-2"
												:class="{'is-invalid':errors.category}"
												v-model="editProdList.category_id"
											>
												<option disabled value>Select Category</option>
												<option
													v-for="(category, index) in categories"
													:key="index"
													:value="category.category_name"
												>{{ category.category_name }}</option>
											</select>
											<small class="invalid-feedback" v-if="errors.category">{{ errors.category[0] }}</small>
										</div>
										<div class="form-group" style="dispslay:none">
											<!-- <p class="help-block"></p> -->
										</div>
										<div class="form-group">
											<label for="name">Image</label>
											<div>
												<img id="newImagePreview" style="display: none;" src alt width="150px" height="150px" />
												<img id="previewImage" :src="'/storage/' + editProdList.image" style="height: 150px;" />
											</div>

											<input
												type="file"
												id="imageEdit"
												class="label-control"
												:class="{'is-invalid':errors.image}"
												@change="handleFileUpload"
												enctype="multipart/form-data"
											/>
											<small class="invalid-feedback" v-if="errors.image">{{ errors.image[0] }}</small>
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="name">Title</label>
											<input
												type="text"
												class="form-control"
												:class="{'is-invalid':errors.title}"
												v-model="editProdList.title"
											/>
											<small class="invalid-feedback" v-if="errors.title">{{ errors.title[0] }}</small>
										</div>
										<div class="form-group">
											<label for="name">Description</label>
											<textarea
												class="form-control"
												:class="{'is-invalid':errors.description}"
												v-model="editProdList.description"
												rows="5"
											></textarea>
											<small class="invalid-feedback" v-if="errors.description">{{ errors.description[0] }}</small>
										</div>
										<div class="form-group">
											<label for="name">Price</label>
											<input
												type="text"
												class="form-control"
												:class="{'is-invalid':errors.price}"
												v-model="editProdList.price"
											/>
											<small class="invalid-feedback" v-if="errors.price">{{ errors.price[0] }}</small>
										</div>
										<div class="form-group">
											<label for="name">Quantity</label>
											<input
												type="text"
												class="form-control"
												:class="{'is-invalid':errors.quantity}"
												v-model="editProdList.quantity"
											/>
											<small class="invalid-feedback" v-if="errors.quantity">{{ errors.quantity[0] }}</small>
										</div>
									</div>
								</div>
							</form>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-primary" @click="update">Update</button>
							<button type="button" class="btn btn-secondary" @click="$emit('close')">Close</button>
						</div>
					</div>
				</div>
			</div>
		</transition>
	</div>
</template>

<script>
export default {
	name: "edit_product",
	props: ["errors", "editProdList"],
	data() {
		return {
			categories: []
			// editProdList: {}
		};
	},
	mounted() {
		axios
			.get("/categories/get")
			.then(response => {
				this.categories = response.data;
				// console.log(this.categories);
			})
			.catch(response => console.log(response.data));
	},
	methods: {
		update() {
			// const image = this.$refs.imageEdit.files[0];
			// const imgName = image.substr(image.lastIndexOf("/") + 1);
			// const imgName = image.split("/")[1];
			// const formData = {
			// 	category: this.editProdList.category_id,
			// 	description: this.editProdList.description,
			// 	id: this.editProdList.id,
			// 	image: document.getElementById("imageEdit").files[0],
			// 	price: this.editProdList.price,
			// 	quantity: this.editProdList.quantity,
			// 	title: this.editProdList.title
			// };

			let formData = new FormData();
			formData.append("category", this.editProdList.category_id);
			formData.append("title", this.editProdList.title);
			formData.append("description", this.editProdList.description);
			formData.append("price", this.editProdList.price);
			formData.append("quantity", this.editProdList.quantity);
			formData.append("id", this.editProdList.id);

			if (document.getElementById("imageEdit").files[0] !== undefined) {
				formData.append("image", this.editProdList.image);
			}
			// console.log(
			// 	"document " + document.getElementById("imageEdit").files[0].name
			// );
			// console.log("edit " + this.editProdList.image);

			this.$emit("upd-prod", formData);
		},
		handleFileUpload(event) {
			const imgPreview = document.getElementById("newImagePreview");
			// const newImagePreview = document.getElementById("newImagePreview");
			// const imgRef = this.$refs.imageEdit.files[0];
			const imgRef = document.getElementById("imageEdit").files[0];
			imgPreview.src = URL.createObjectURL(imgRef);
			// imgPreview2.src = window.URL.createObjectURL(imgRef);
			document.getElementById("previewImage").style.display = "none";
			imgPreview.style.display = "block";

			// console.log(imgRef.name.substr(0, imgRef.name.lastIndexOf(".")));

			this.editProdList.image = imgRef;
			// this.newProduct.image = imageInput;
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
