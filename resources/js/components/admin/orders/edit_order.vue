<template>
	<div>
		<transition name="modal-fade">
			<div class="modal" role="dialog" aria-labelledby="editOrder" aria-describedby="editOrder">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">
								Edit
								<strong>{{ editOrderList.orderId }}'s Order</strong>
							</h5>
							<button type="button" class="close" @click="$emit('close')" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<div class="modal-body">
							<form @submit.prevent="update">
								<div class="form-group">
									<label for="id">ID</label>
									<input type="text" class="form-control" disabled v-model="editOrderList.orderId" />
								</div>
								<div class="form-group">
									<label for="name">Totals</label>
									<input
										type="text"
										class="form-control"
										disabled
										:value="editOrderList.totals | threeDigitsCoversion"
									/>
								</div>
								<div class="form-group">
									<label for="name">Delivery</label>
									<select
										class="custom-select mr-sm-2"
										:class="{'is-invalid':errors.status}"
										v-model="editOrderList.status"
									>
										<option disabled value>Delivery Status</option>
										<option value="pending">pending</option>
										<option value="incomplete">incomplete</option>
										<option value="complete">complete</option>
									</select>
									<small class="invalid-feedback" v-if="errors.status">{{ errors.order_status[0] }}</small>
								</div>
								<div class="form-group">
									<label for="name">Shpping Date</label>
									<input
										type="date"
										class="form-control"
										:class="{'is-invalid':errors.shippingDate}"
										v-model="editOrderList.shippingDate"
									/>
									<small class="invalid-feedback" v-if="errors.shippingDate">{{ errors.shippingDate[0] }}</small>
								</div>
								<div class="form-group">
									<label for="name">comments</label>
									<textarea
										class="form-control"
										:class="{'is-invalid':errors.comments}"
										v-model="editOrderList.comments"
										rows="5"
									></textarea>
									<small class="invalid-feedback" v-if="errors.comments">{{ errors.comments[0] }}</small>
								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary">Update</button>
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
	name: "edit_order",
	props: ["errors", "editOrderList"],
	data() {
		return {
			// editOrderList: {}
		};
	},
	methods: {
		update() {
			this.$emit("upd-order", this.editOrderList);
		}
	}
};
</script>

<style lang="scss" scoped>
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
	transition: opacity 0.3s ease;
}
</style>
