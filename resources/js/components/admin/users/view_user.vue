<template>
	<div>
		<!-- Modal -->
		<div
			class="modal fade"
			id="view_user"
			tabindex="-1"
			role="dialog"
			aria-labelledby="modelview_user"
			aria-hidden="true"
		>
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">User's Details</h5>
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
										<td style="height: 122px">
											<img :src="'/storage/' + viewUser.image" alt style="height: 100%;" />
										</td>
									</tr>
									<tr>
										<th class="tb-title">Employee ID</th>
										<td>{{ viewUser.userId }}</td>
									</tr>
									<tr>
										<th class="tb-title">Name</th>
										<td>{{ viewUser.name }}</td>
									</tr>
									<tr>
										<th class="tb-title">Email</th>
										<td>{{ viewUser.email }}</td>
									</tr>
									<tr>
										<th class="tb-title">Phone Number</th>
										<td>{{ viewUser.phone_number }}</td>
									</tr>
									<tr>
										<th class="tb-title">Gender</th>
										<td>{{ viewUser.gender }}</td>
									</tr>
									<tr>
										<th class="tb-title">ID Number</th>
										<td>{{ viewUser.idNumber }}</td>
									</tr>
									<tr>
										<th class="tb-title">Age</th>
										<td>{{ employeeAge }}</td>
									</tr>
									<tr>
										<th class="tb-title">Active</th>
										<td>{{ viewUser.active }}</td>
									</tr>
									<tr>
										<th class="tb-title">Roles</th>
										<td>{{ viewUser.roles }}</td>
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
	name: "view_user",
	props: ["selectedUser"],
	data() {
		return {
			// viewUser: ""
		};
	},
	computed: {
		viewUser() {
			// console.log("dd " + this.$store.state.customers[this.selectedUser]);
			return this.$store.state.users[this.selectedUser];
		},
		employeeAge() {
			let dob = this.$store.state.users[this.selectedUser].dateOfBirth;
			// dob = new Date(dob.replace(/-/g, "/"));
			dob = new Date(dob);
			const today = new Date();
			let age = today.getFullYear() - dob.getFullYear();
			const m = today.getMonth() - dob.getMonth();
			if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
				return (age -= 1);
			}

			return age;
		}
	}
};
</script>

<style lang="scss" scoped>
.tb-title {
	width: 40%;
}
</style>
