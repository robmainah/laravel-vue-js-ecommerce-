<template>
	<div>
		<transition name="modal-fade">
			<div class="modal" role="dialog" aria-labelledby="editCategory" aria-describedby="editCategory">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">
								Edit
								<strong>{{ newOrder.title }}'s</strong>
							</h5>
							<button type="button" class="close" @click="$emit('close')" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<div class="modal-body">
							<form enctype="multipart/form-data">
								<div class="row">
									<div class="col-6">
										<div class="form-group">
											<label for="image">Image</label>
											<!-- <input type="file" :class="{'is-invalid':errors.image}" value="newOrder.image"> -->
											<div class="custom-file">
												<input
													type="file"
													class="form-control custom-file-input"
													id="image"
													ref="image"
													v-on:change="handleFileUpload()"
													:class="{'is-invalid':errors.image}"
												>
												<!-- <input
													type="text"
													class="form-control"
													:class="{'is-invalid':errors.image}"
													v-model="newOrder.image"
												>-->

												<small class="invalid-feedback" v-if="errors.image">{{ errors.image[0] }}</small>
												<label class="custom-file-label" for="customFile">Choose file</label>
											</div>
										</div>
										<div class="form-group">
											<label for="name">Image Alternative</label>
											<input
												type="text"
												class="form-control"
												:class="{'is-invalid':errors.imageAlt}"
												v-model="newOrder.imageAlt"
											>
											<small class="invalid-feedback" v-if="errors.imageAlt">{{ errors.imageAlt[0] }}</small>
										</div>
										<div class="form-group">
											<label for="name">Title</label>
											<input
												type="text"
												class="form-control"
												:class="{'is-invalid':errors.title}"
												v-model="newOrder.title"
											>
											<small class="invalid-feedback" v-if="errors.title">{{ errors.title[0] }}</small>
										</div>
										<div class="form-group">
											<label for="name">Price</label>
											<input
												type="text"
												class="form-control"
												:class="{'is-invalid':errors.price}"
												v-model="newOrder.price"
											>
											<small class="invalid-feedback" v-if="errors.price">{{ errors.price[0] }}</small>
										</div>
										<div class="form-group">
											<label for="name">Quanity</label>
											<input
												type="text"
												class="form-control"
												:class="{'is-invalid':errors.quantity}"
												v-model="newOrder.quantity"
											>
											<small class="invalid-feedback" v-if="errors.quantity">{{ errors.quantity[0] }}</small>
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="name">Description</label>
											<textarea
												class="form-control"
												:class="{'is-invalid':errors.description}"
												v-model="newOrder.description"
												rows="5"
												style="background-size: 1.5rem;"
											></textarea>
											<small class="invalid-feedback" v-if="errors.description">{{ errors.description[0] }}</small>
										</div>
										<div class="form-group">
											<label for="name">Category</label>
											<select
												class="custom-select mr-sm-2"
												:class="{'is-invalid':errors.category}"
												v-model="newOrder.category"
											>
												<option disabled value>Select Category</option>
												<option value="8">Yes</option>
												<option value="10">No</option>
											</select>
											<small class="invalid-feedback" v-if="errors.category">{{ errors.category[0] }}</small>
										</div>
									</div>
								</div>
							</form>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-primary" @click="save">Save</button>
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
	name: "add_category",
	props: ["errors", "newOrder"],
	data() {
		return {
			// newOrder: {
			// 	category: "",
			// 	title: "",
			// 	description: "",
			// 	price: "",
			// 	quantity: "",
			// 	image: "",
			// 	imageAlt: ""
			// }
		};
	},
	methods: {
		save() {
			let formData = new FormData();
			formData.append("category", this.newOrder.category);
			formData.append("title", this.newOrder.title);
			formData.append("title", this.newOrder.title);
			formData.append("description", this.newOrder.description);
			formData.append("price", this.newOrder.price);
			formData.append("quantity", this.newOrder.quantity);
			formData.append("image", this.newOrder.image);
			formData.append("imageAlt", this.newOrder.imageAlt);

			this.$emit("new-order", formData);
		},
		handleFileUpload() {
			// console.log(this.$refs.image.files[0]);

			this.newOrder.image = this.$refs.image.files[0];
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
