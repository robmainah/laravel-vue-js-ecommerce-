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
						<div class="card-header">
							<ul class="nav nav-tabs" id="myTab" role="tablist">
								<li class="nav-item">
									<a
										class="nav-link active"
										id="login-tab"
										data-toggle="tab"
										href="#login"
										role="tab"
										aria-controls="login"
										aria-selected="true"
									>Login</a>
									<!-- <a class="nav-link active" href="/login">Login</a> -->
								</li>
								<li class="nav-item">
									<a
										class="nav-link"
										id="register-tab"
										data-toggle="tab"
										href="#register"
										role="tab"
										aria-controls="register"
										aria-selected="false"
									>Register</a>
									<!-- <a class="nav-link" href="register">Register</a> -->
								</li>
							</ul>
						</div>

						<div class="card-body tab-content" id="myTabContent">
							<div
								class="tab-pane fade show active custLogin"
								id="login"
								role="tabpanel"
								aria-labelledby="login-tab"
							>
								<form @submit.prevent="customerLogin" autocomplete="off">
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
											<router-link class="btn btn-link" to="password/reset">Forgot Your Password?</router-link>
											<!-- <a class="btn btn-link" href="password/reset">Forgot Your Password?</a> -->
										</div>
									</div>
								</form>
							</div>
							<div
								class="tab-pane fade custRegister"
								id="register"
								role="tabpanel"
								aria-labelledby="register-tab"
							>
								<form @submit.prevent="customerRegister" autocomplete="off">
									<div class="form-group row">
										<label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
										<div class="col-md-6">
											<input
												id="name"
												type="text"
												class="form-control"
												:class="{'is-invalid': errors.name}"
												v-model="newCustomer.name"
												autofocus
											/>
											<small class="invalid-feedback" v-if="errors.name">
												<strong>{{ errors.name[0] }}</strong>
											</small>
										</div>
									</div>
									<div class="form-group row">
										<label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
										<div class="col-md-6">
											<input
												id="email"
												type="email"
												class="form-control"
												:class="{'is-invalid': errors.email}"
												v-model="newCustomer.email"
											/>
											<small class="invalid-feedback" role="alert" v-if="errors.email">
												<strong>{{ errors.email[0] }}</strong>
											</small>
										</div>
									</div>
									<div class="form-group row">
										<label for="idNumber" class="col-md-4 col-form-label text-md-right">ID Number</label>
										<div class="col-md-6">
											<input
												id="idNumber"
												type="text"
												class="form-control"
												:class="{'is-invalid': errors.idNumber}"
												v-model="newCustomer.idNumber"
											/>
											<small class="invalid-feedback" role="alert" v-if="errors.idNumber">
												<strong>{{ errors.idNumber[0] }}</strong>
											</small>
										</div>
									</div>
									<div class="form-group row">
										<label for="phone_number" class="col-md-4 col-form-label text-md-right">Phone Number</label>
										<div class="col-md-6">
											<input
												id="phone_number"
												type="text"
												class="form-control"
												:class="{'is-invalid': errors.phone_number}"
												v-model="newCustomer.phone_number"
											/>
											<small class="invalid-feedback" role="alert" v-if="errors.phone_number">
												<strong>{{ errors.phone_number[0] }}</strong>
											</small>
										</div>
									</div>
									<div class="form-group row">
										<label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
										<div class="col-md-6">
											<input
												id="text"
												type="text"
												class="form-control"
												:class="{'is-invalid': errors.address}"
												v-model="newCustomer.address"
											/>
											<small class="invalid-feedback" role="alert" v-if="errors.address">
												<strong>{{ errors.address[0] }}</strong>
											</small>
										</div>
									</div>
									<div class="form-group row">
										<label for="gender" class="col-md-4 col-form-label text-md-right">Gender</label>
										<div class="col-md-6">
											<select
												class="custom-select mr-sm-2"
												v-model="newCustomer.gender"
												:class="{'is-invalid': errors.gender}"
											>
												<option disabled value>Select Gender</option>
												<option value="male">Male</option>
												<option value="female">Female</option>
												<option value="none">Choose not to say</option>
											</select>
											<small class="invalid-feedback" role="alert" v-if="errors.gender">
												<strong>{{ errors.gender[0] }}</strong>
											</small>
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
												v-model="newCustomer.password"
											/>
											<small class="invalid-feedback" role="alert" v-if="errors.password">
												<strong>{{ errors.password[0] }}</strong>
											</small>
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
												v-model="newCustomer.password_confirmation"
											/>
											<small class="invalid-feedback" v-if="errors.password_confirmation">
												<strong>{{ errors.password_confirmation[0] }}</strong>
											</small>
										</div>
									</div>
									<div class="form-group row mb-0">
										<div class="col-md-6 offset-md-4">
											<button type="submit" class="btn btn-primary">Register</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { log } from "util";
// import loginMixin from "../../mixins/mixins";

export default {
	name: "customer-login",
	data() {
		return {
			dispMes: false,
			alertClass: "",
			user: {
				email: "",
				password: "",
				remember: ""
			},
			newCustomer: {
				name: "",
				email: "",
				idNumber: "",
				phone_number: "",
				address: "",
				gender: "",
				password: "",
				password_confirmation: ""
			},
			errors: []
		};
	},
	mounted() {
		const registered = sessionStorage.getItem("registered");
		if ((registered && registered != null) || registered != undefined) {
			this.displayMessageFunction(
				sessionStorage.getItem("registered"),
				"alert-success"
			);

			setTimeout(() => {
				this.dispMes = false;
				this.$refs.displayMessage.innerText = "";
				this.alertClass = "";
				sessionStorage.removeItem("registered");
			}, 5000);
			return;
		}
	},
	methods: {
		customerLogin() {
			let formData = new FormData();

			formData.append("email", this.user.email);
			formData.append("password", this.user.password);
			formData.append("remember", this.user.remember);

			axios
				.post("/customer-login", formData)
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

					if (response.data.user) {
						const parsed = JSON.stringify(response.data.user);
						// const parsed = response.data.user;
						console.log(parsed);
						localStorage.setItem("userInfo", parsed);
						this.$emit("logged-in", true);

						this.routesRedirection();
						return;
					}

					// return this.routesRedirection();
				})
				.catch(error => {
					// if (error.response.data.errors == undefined) {
					// 	this.errors = error.response.data;
					// }

					this.errorMessages(error);
					// console.log(error);
					

					return (this.errors = error.response.data.errors);
					return;
				});
		},
		customerRegister() {
			let formData = new FormData();

			formData.append("name", this.newCustomer.name);
			formData.append("email", this.newCustomer.email);
			formData.append("idNumber", this.newCustomer.idNumber);
			formData.append("phone_number", this.newCustomer.phone_number);
			formData.append("address", this.newCustomer.address);
			formData.append("gender", this.newCustomer.gender);
			formData.append("password", this.newCustomer.password);
			formData.append(
				"password_confirmation",
				this.newCustomer.password_confirmation
			);

			axios
				.post("/customer-register", formData)
				.then(response => {
					this.errors = [];
					this.newCustomer.name = "";
					this.newCustomer.email = "";
					this.newCustomer.idNumber = "";
					this.newCustomer.phone_number = "";
					this.newCustomer.gender = "";
					this.newCustomer.address = "";
					this.newCustomer.password = "";
					this.newCustomer.password_confirmation = "";

					if (response.data.user) {
						const parsed = JSON.stringify(response.data.user);
						// const parsed = response.data.user;
						// console.log(parsed);
						localStorage.setItem("userInfo", parsed);
						this.$emit("logged-in", true);

						this.routesRedirection();
						return;
					}

					this.$router.push({ name: "customer-login" });
				})
				.catch(error => {
					// if (error.response.data.errors == undefined) {
					// 	this.errors = error.response.data;
					// }
					// this.errorMessages(error);
					console.log(error);
					

					return (this.errors = error.response.data.errors);
				});
		},
		displayMessageFunction(message, color) {
			this.alertClass = color;
			this.$refs.displayMessage.innerText = message;
			this.dispMes = true;
		},
		routesRedirection() {
			try {
				const pathsName = JSON.parse(localStorage.getItem("redirectPathsName"));
				if (pathsName == null) {
					// return [];
					return (window.location.href = "/");
				}

				let redirectPath = "/";

				let nextPath = pathsName[0]["next"];
				if (nextPath == "/customer-login") {
					nextPath = "/";
				}

				redirectPath = nextPath;

				window.location.href = redirectPath;
				// this.$router.push({ name: nextPath });
				localStorage.removeItem("redirectPathsName");

				// window.location.reload();
			} catch (error) {
				localStorage.removeItem("redirectPathsName");
				// console.log(error);
			}
		},
		errorMessages(error) {
			if (error.response.data.message == "CSRF token mismatch.") {
				return window.location.reload();
			}

			if (error.response.data.message == "Unauthenticated.") {
				localStorage.removeItem("userInfo");
				this.$emit("logged-in", false);

				return this.$router.push({ name: "customer-login" });
			}

			// return this.$router.push({ name: "admin-login" });

			//
			return this.setCustomPaths();
		},
		setCustomPaths() {
			// const currentPath = this.$route.path;
			const currentPaths = {
				pathFrom: this.$route.path,
				next: this.$route.path
			};

			const setPaths = JSON.stringify([currentPaths]);
			localStorage.setItem("redirectPathsName", setPaths);
			return;
			// return (window.location.href = "/customer-login");
		}
	}
	// mixins: [loginMixin]
};
/*function  routesRedirection() {
	try {
		const pathsName = JSON.parse(localStorage.getItem("redirectPathsName"));
		if (pathsName == null) {
			return [];
		}
		// console.log(pathsName.reverse());

		for (const iterator of pathsName.reverse()) {
			console.log(iterator["pathTo"]);
			if (iterator["pathTo"] != "customer-login") {
				// window.location.href = pathTo[]
				// vm => {
				//     console.log(" rout" + vm.$route);
				// }
				vm.$router.push({ name: pathTo });
			}
		}
		// return pathsName;
	} catch (error) {
		// localStorage.removeItem("redirectPathsName");
		console.log(error);
	}
} */
// function modifyRoutesRedirection() {
// 	let oldPaths = routesRedirection();
//     // oldPaths.splice(-1);
//     console.log(oldpaths);

// }
</script>

<style lang="scss" scoped>
</style>
