<template>
	<div>
		<!-- Modal -->
		<div
			class="modal fade"
			id="view_product"
			tabindex="-1"
			role="dialog"
			aria-labelledby="modelview_product"
			aria-hidden="true"
		>
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">{{ newProduct.title }}</h5>
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
										<td style="height: 175px">
											<img :src="'/storage/' + newProduct.image" alt style="height: 100%;" />
										</td>
									</tr>
									<!-- <tr>
										<th class="tb-title">Image Alternative</th>
										<td>
											{{ newProduct.imageAlt }}
											<small>This text appears if the image does not appear.</small>
										</td>
									</tr>-->
									<tr>
										<th class="tb-title">Product ID</th>
										<td>{{ newProduct.productId }}</td>
									</tr>
									<tr>
										<th class="tb-title">Category Name</th>
										<td>{{ newProduct.category_id }}</td>
									</tr>
									<tr>
										<th class="tb-title">Title</th>
										<td>{{ newProduct.title }}</td>
									</tr>
									<tr>
										<th class="tb-title">Description</th>
										<td>{{ newProduct.description }}</td>
									</tr>
									<tr>
										<th class="tb-title">Price (KSh.)</th>
										<td>{{ newProduct.price | threeDigitsCoversion }}</td>
									</tr>
									<tr>
										<th class="tb-title">Quantity</th>
										<td>{{ newProduct.quantity | threeDigitsCoversion }}</td>
									</tr>
									<tr>
										<th class="tb-title">Last Update</th>
										<td>{{ newProduct.updated_at }}</td>
									</tr>
									<tr>
										<th class="tb-title">Entered By</th>
										<td>{{ newProduct.updated_by }}</td>
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
	name: "view_product",
	data() {
		return {
			newProduct: ""
		};
	}
};
</script>

<style lang="scss" scoped>
.tb-title {
	width: 40%;
}
</style>
