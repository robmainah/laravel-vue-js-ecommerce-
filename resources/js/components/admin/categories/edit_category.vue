<template>
	<div>
		<transition name="modal-fade">
			<div class="modal" role="dialog" aria-labelledby="editCategory" aria-describedby="editCategory">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">
								Edit
								<strong>{{ editCatlList.category }}'s</strong> Category
							</h5>
							<button type="button" class="close" @click="$emit('close')" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<div class="modal-body">
							<form>
								<div class="form-group">
									<label for="id">ID</label>
									<input type="text" class="form-control" disabled v-model="editCatlList.categoryId" />
								</div>
								<div class="form-group">
									<label for="name">Category Name</label>
									<input
										type="text"
										class="form-control"
										:class="{'is-invalid':errors.category_name}"
										v-model="editCatlList.category_name"
									/>
									<small class="invalid-feedback" v-if="errors.category_name">{{ errors.category_name[0] }}</small>
								</div>
								<div class="form-group">
									<label for="name">Active</label>
									<select
										class="custom-select mr-sm-2"
										:class="{'is-invalid':errors.activated}"
										v-model="editCatlList.activated"
									>
										<option disabled value>Select Status</option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
									<small class="invalid-feedback" v-if="errors.activated">{{ errors.activated[0] }}</small>
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
	name: "edit_category",
	props: ["errors", "editCatlList"],
	data() {
		return {
			// editCatlList: {}
		};
	},
	methods: {
		update() {
			this.$emit("current_user", this.editCatlList);
		}
	}
};
</script>

<style lang="scss" scoped>
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
