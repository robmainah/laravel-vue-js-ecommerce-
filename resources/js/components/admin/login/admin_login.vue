<template>
	<div>
		<div class="container" style="margin-top: 5rem;">
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
						<div class="card-header">Admin Login</div>
						<div class="card-body">
							<form @submit.prevent="authorizeLogin">
								<div class="form-group row">
									<label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
									<div class="col-md-6">
										<input
											id="logEmail"
											type="email"
											class="form-control"
											:class="{'is-invalid': errors.email}"
											name="email"
											v-model="user.email"
											autocomplete="user.email"
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
											id="logPassword"
											type="password"
											class="form-control"
											:class="{'is-invalid': errors.password}"
											v-model="user.password"
											autocomplete="current-password"
										/>
										<span class="invalid-feedback" role="alert" v-if="errors.password">
											<strong>{{ errors.password[0] }}</strong>
										</span>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-6 offset-md-4">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" v-model="user.remember" id="remember" />
											<label class="form-check-label" for="remember">Remember Me</label>
										</div>
									</div>
								</div>

								<div class="form-group row mb-0">
									<div class="col-md-8 offset-md-4">
										<button type="submit" class="btn btn-primary">Login</button>
										<router-link class="btn btn-link" to="admin/password/reset">Forgot Your Password?</router-link>
										<!-- <a class="btn btn-link" href="admin/password/request'">Forgot Your Password?</a> -->
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
import { log } from "util";
export default {
	name: "admin-login",
	data() {
		return {
			dispMes: false,
			alertClass: "",
			user: {
				email: "",
				password: "",
				remember: ""
			},
			// dispForms: false,
			errors: []
		};
	},
	beforeRouteEnter(to, from, next) {
		if (sessionStorage.getItem("urlTo") == null) {
			sessionStorage.setItem("urlTo", from.path);
		}

		next();
	},
	mounted() {
		// return this.$router.push("/cart");
	},
	methods: {
		authorizeLogin() {
			let formData = new FormData();

			formData.append("email", this.user.email);
			formData.append("password", this.user.password);
			formData.append("remember", this.user.remember);

			axios
				.post("/admin-login", formData)
				.then(response => {
					if (response.data.errors) {
						return (this.errors = response.data.errors);
					}

					if (response.data.loginFail) {
						this.errors = [];
						this.user.password = "";

						return this.displayMessageFunction(
							response.data.loginFail,
							"alert-danger"
						);
					}


					if (response.data.user.loginSuccess === true) {
						const parsed = JSON.stringify(response.data.user);

						localStorage.setItem("userInfo", parsed);
						this.$emit("logged-in", true);

						
						return this.routesRedirection();
					}

					console.log('passed user');
					
				})
				.catch(error => {
					// if (error.response.data.errors == undefined) {
					// 	this.errors = error.response.data;

					// 	if (error.response.data.message == "CSRF token mismatch.") {
					// 		return window.location.reload();
					// 	}
					// }

					// this.errorMessages(error);
					// return (this.errors = error.response.data.errors);
					console.log(error);
					
				});
		},
		displayMessageFunction(message, color) {
			this.alertClass = color;
			this.$refs.displayMessage.innerText = message;
			this.dispMes = true;

			//if (color !== "alert-danger") {
			// setTimeout(() => {
			// 	this.dispMes = false;
			// 	this.$refs.displayMessage.innerText = "";
			// 	this.alertClass = "";
			// }, 3000);
			//}
		},
		routesRedirection() {
			try {
				const pathsName = JSON.parse(localStorage.getItem("redirectPathsName"));
				if (pathsName == null) {
					// console.log("nextPath");
					return (window.location.href = "/account/admin/dashboard");
					// return [];
				}

				let redirectPath = "/account/admin/dashboard";
				//window.location.href = "/account/admin/dashboard";

				let nextPath = pathsName[0]["next"];
				if (nextPath == "/admin-login") {
					nextPath = "/account/admin/dashboard";
				}

				redirectPath = nextPath;

				window.location.href = redirectPath;
				// this.$router.push({ name: nextPath });
				localStorage.removeItem("redirectPathsName");
				return;
				// window.location.reload();
			} catch (error) {
				localStorage.removeItem("redirectPathsName");
			}
		},
		errorMessages(error) {
			if (error.response.data.message == "CSRF token mismatch.") {
				return window.location.reload();
			}

			if (error.response.data.message == "Unauthenticated.") {
				localStorage.removeItem("userInfo");
				this.$emit("logged-in", false);

				return this.$router.push({ name: "admin-login" });
			}

			// return this.$router.push({ name: "admin-login" });
			this.setCustomPaths();
			// window.location.href = "/admin-login";
			return;
		},
		setCustomPaths() {
			// const currentPath = this.$route.path;
			const currentPaths = {
				pathFrom: this.$route.path,
				next: this.$route.path
			};

			const setPaths = JSON.stringify([currentPaths]);
			localStorage.setItem("redirectPathsName", setPaths);
		}
	}
};
</script>

<style lang="scss" scoped>
</style>
