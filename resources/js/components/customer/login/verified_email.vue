<template>
	<div>
		<div class="container" style="padding-top: 5rem;">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card">
						<div class="alert alert-success fade show text-center">
							<p>Email Verification Success</p>
							<div class="card-body">
								<p>You have Successfully verified your email. Your account is now active.
								<router-link to="/customer-login">click here</router-link>to login.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	name: "verified_email"
};
</script>
