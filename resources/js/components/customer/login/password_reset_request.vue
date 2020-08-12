<template>
	<div>
		<div class="container" style="padding-top: 5rem;">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<transition name="moveOut">
						<div class="alert alert-dismissible fade show" :class="alertClass" v-show="dispMes">
							<p ref="displayMessage"></p>
							<button type="button" class="close" aria-label="Close" @click="dispMes = !dispMes">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</transition>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">Reset Password</div>

						<div class="card-body">
							<form @submit.prevent="passwordReset" autocomplete="off">
								<div class="form-group row">
									<label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

									<div class="col-md-6">
										<input
											id="email"
											type="email"
											class="form-control"
											:class="{'is-invalid': errors.email}"
											v-model="email"
											required
										/>
										<small class="invalid-feedback" role="alert" v-if="errors.email">
											<strong>{{ errors.email[0] }}</strong>
										</small>
									</div>
								</div>

								<div class="form-group row mb-0">
									<div class="col-md-6 offset-md-4">
										<button type="submit" class="btn btn-primary">Send Password Reset Link</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "password-reset-request",
	data() {
		return {
			dispMes: false,
			alertClass: "",
			email: [],
			errors: {}
		};
	},
	methods: {
		passwordReset() {
			let formData = new FormData();

			formData.append("email", this.email);

			axios
				.post("/password/email", formData)
				.then(response => {
					if (response.data.errors) {
						return (this.errors = { email: [response.data.errors] });
					}
					// console.log(response.data);

					// if (response.data.user_resp) {
					// 	return (this.errors = response.data.errors);
					// }

					if (response.data.emailSent) {
						this.errors = "";
						this.email = "";

						return this.displayMessageFunction(
							response.data.emailSent,
							"alert-success"
						);
					}
				})
				.catch(error => {
					console.log(error);

					// if (error.response.data.errors == undefined) {
					// 	this.errors = error.response.data;

					// 	if (error.response.data.message == "CSRF token mismatch.") {
					// 		return window.location.reload();
					// 	}

					// 	return false;
					// }

					// return (this.errors = error.response.data.errors);
				});
		},
		displayMessageFunction(message, color) {
			this.alertClass = color;
			this.$refs.displayMessage.innerText = message;
			this.dispMes = true;
		}
	}
};
</script>

