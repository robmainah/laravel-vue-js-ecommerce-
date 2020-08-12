<template>
	<div>
		<!-- Modal -->
		<div
			class="modal fade"
			id="view_customer"
			tabindex="-1"
			role="dialog"
			aria-labelledby="modalview_customer"
			aria-hidden="true"
		>
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Users' Details {{ viewCustomer.name }}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="table-responsive">
							<table class="table table-bordered">
								<tbody>
									<tr>
										<th class="tb-title">Image</th>
										<td style="height: 122px;">
											<img :src="'/storage/'" alt style="height: 100%;" />
										</td>
									</tr>
									<tr>
										<th class="tb-title">Customer ID</th>
										<td>{{ viewCustomer.customerId }}</td>
									</tr>
									<tr>
										<th class="tb-title">Name</th>
										<td>{{ viewCustomer.name }}</td>
									</tr>
									<tr>
										<th class="tb-title">Email</th>
										<td>{{ viewCustomer.email }}</td>
									</tr>
									<tr>
										<th class="tb-title">Phone Number</th>
										<td>{{ viewCustomer.phone_number }}</td>
									</tr>
									<tr>
										<th class="tb-title">ID Number</th>
										<td>{{ viewCustomer.idNumber }}</td>
									</tr>
									<tr>
										<th class="tb-title">Address</th>
										<td>{{ viewCustomer.address }}</td>
									</tr>
									<tr>
										<th class="tb-title">Gender</th>
										<td>{{ viewCustomer.gender }}</td>
									</tr>
									<tr>
										<th class="tb-title">Active Status</th>
										<td>{{ viewCustomer.active }}</td>
									</tr>
									<tr>
										<th class="tb-title">Last Update</th>
										<td>{{ viewCustomer.updated_at }}</td>
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
	props: ["selectedCustomer"],
	data() {
		return {
			// viewCustomer: ""
		};
	},
	computed: {
		viewCustomer() {
			// console.log("dd " + this.$store.state.customers[this.selectedCustomer]);
			return this.$store.state.customers[this.selectedCustomer];
		}
	}
};
</script>

<style lang="scss" scoped>
.tb-title {
	width: 40%;
}
</style>
