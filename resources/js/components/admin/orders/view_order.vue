<template>
	<div>
		<!-- Modal -->
		<div
			class="modal fade"
			id="view_order"
			tabindex="-1"
			role="dialog"
			aria-labelledby="modelview_order"
			aria-hidden="true"
		>
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Products in Order</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" style="width: 100%;">
								<thead class="theade-light">
									<tr>
										<th class="tb-no" style>#</th>
										<!-- <th>Order ID</th> -->
										<th>Product Title</th>
										<th>prices</th>
										<th>quantity</th>
										<th>Totals</th>
										<th>Delivery</th>
										<th>Entered by</th>
										<th>last Updated</th>
									</tr>
								</thead>
								<tbody ref="tableBody">
									<tr v-for="(orderProducts,index) in selectedOrder" :key="index">
										<th class="tb-no">{{ index + 1 }}</th>
										<!-- <td class="tb-id">{{ orderProducts.orderId }}</td> -->
										<td class="tb-id">{{ orderProducts.productTitle }}</td>
										<td>{{ orderProducts.price | threeDigitsCoversion}}</td>
										<td>{{ orderProducts.quantity }}</td>
										<td>{{ orderProducts.totals | threeDigitsCoversion }}</td>
										<!-- <td style="color: #ffc107">{{ orderProducts.order_status }}</td> -->
										<td
											v-if="orderProducts.order_status == 'complete'"
											class="text-success"
										>{{ orderProducts.order_status }}</td>
										<td
											v-else-if="orderProducts.order_status == 'incomplete'"
											class="text-danger"
										>{{ orderProducts.order_status }}</td>
										<td v-else style="color: #ffc107">{{ orderProducts.order_status }}</td>
										<td>{{ orderProducts.user_name }}</td>
										<td>{{ orderProducts.updated_at | changeDateFormat }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: ["selectedOrder"],
	data() {
		return {
			// selectedOrder: null,
			// productsInOrder: [],
			// checkedOrders: []
		};
	},
	computed: {
		// orderProductsLists() {
		// console.log(this.selectedOrder);
		// }
	}
};
</script>

<style lang="scss" scoped>
.tb-title {
	width: 40%;
}
</style>
