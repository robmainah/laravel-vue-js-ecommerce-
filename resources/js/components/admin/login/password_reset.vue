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
						<div class="card-header">Admin Reset Password</div>

						<div class="card-body">
							<form @submit.prevent="resetPassword" autocomplete="off">
								<!-- <input type="hidden" name="token" value="{{ $token }}" /> -->

								<div class="form-group row">
									<label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

									<div class="col-md-6">
										<input
											id="email"
											type="email"
											class="form-control"
											:class="{'is-invalid': errors.email}"
											v-model="email"
											name="email"
											required
											autofocus
										/>
										<span class="invalid-feedback" role="alert" v-if="errors.email">
											<strong>{{ errors.email[0] }}</strong>
										</span>
									</div>
								</div>

								<div class="form-group row">
									<label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

									<div class="col-md-6">
										<input
											id="password"
											type="password"
											class="form-control"
											:class="{'is-invalid': errors.password}"
											v-model="password"
											name="password"
											required
										/>
										<span class="invalid-feedback" role="alert" v-if="errors.password">
											<strong>{{ errors.password[0] }}</strong>
										</span>
									</div>
								</div>

								<div class="form-group row">
									<label
										for="password-confirm"
										class="col-md-4 col-form-label text-md-right"
									>Confirm Password</label>

									<div class="col-md-6">
										<input
											id="password-confirm"
											type="password"
											class="form-control"
											:class="{'is-invalid': errors.password_confirmation}"
											v-model="password_confirmation"
											name="password_confirmation"
											required
										/>
									</div>
								</div>

								<div class="form-group row mb-0">
									<div class="col-md-6 offset-md-4">
										<button type="submit" class="btn btn-primary">Reset Password</button>
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
	name: "admin-password-reset",
	data() {
		return {
			dispMes: false,
			alertClass: "",
			errors: {},
			email: "",
			password: "",
			password_confirmation: ""
		};
	},
	methods: {
		//password.update
		resetPassword() {
			let formData = new FormData();

			formData.append("email", this.email);
			formData.append("password", this.password);
			formData.append("password_confirmation", this.password_confirmation);
			formData.append("token", this.$route.params.token);
			// console.log(this.$route.params.token);

			axios
				.post("/admin/password/update", formData)
				.then(response => {
					if (response.data.errors) {
						return (this.errors = response.data.errors);
					}

					/* if (response.data.loginFail) {
						this.errors = [];
						this.user.password = "";

						return this.displayMessageFunction(
							response.data.loginFail,
							"alert-danger"
						);
					} */

					if (response.data.updateSuccess) {
						return this.displayMessageFunction(
							response.data.updateSuccess,
							"alert-success"
						);
					}

					if (response.data.resetSuccess) {
						window.location.href = "/admin-login";
					}

					if (response.data.resetFailed) {
						// const pas = document.getElementById("password").classList.remove("is-invalid");

						this.password = "";
						this.errors = {};
						this.password_confirmation = "";

						return this.displayMessageFunction(
							response.data.resetFailed,
							"alert-danger"
						);
					}
				})
				.catch(error => {
					// console.log(error);

					if (error.response.data.errors == undefined) {
						this.errors = error.response.data;

						if (error.response.data.message == "CSRF token mismatch.") {
							return window.location.reload();
						}

						return false;
					}

					return (this.errors = error.response.data.errors);
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

