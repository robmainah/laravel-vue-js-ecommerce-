<template>
	<div>
		<div class="container" style="padding-top: 5rem;">
			<div class="row justify-content-center">
				<div class="col-md-8">
                    <div class="alert alert-success fade show text-center">
                        <h3>Verify Your Email Address</h3>
                        <p>Check your email for a verification link to activate your account.
                            <router-link to="/customer-login">click here</router-link> to login.</p>
                        </p>
                    </div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	name: "verify_email"
};
</script>
