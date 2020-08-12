<template>
	<div>
		<!-- Modal -->
		<div
			class="modal fade"
			id="view_category"
			tabindex="-1"
			role="dialog"
			aria-labelledby="modelview_category"
			aria-hidden="true"
		>
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">View category Details</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="table-responsive">
							<table class="table table-bordered">
								<tbody>
									<tr>
										<th class="tb-title">ID</th>
										<td>{{ newCategory.categoryId }}</td>
									</tr>
									<tr>
										<th class="tb-title">Name</th>
										<td>{{ newCategory.category_name }}</td>
									</tr>
									<tr>
										<th class="tb-title">Last Updated</th>
										<td>{{ newCategory.last_updated }}</td>
									</tr>
									<tr>
										<th class="tb-title">Entered By</th>
										<td>{{ newCategory.updated_by }}</td>
									</tr>
									<tr>
										<th class="tb-title">Activation Status</th>
										<td>{{ newCategory.activated }}</td>
									</tr>
									<tr>
										<th class="tb-title">Products in Category</th>
										<td>{{ newCategory.product_count }}</td>
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
	data() {
		return {
			newCategory: ""
		};
	}
};
</script>

<style lang="scss" scoped>
.tb-title {
	width: 40%;
}
</style>
