<template>
	<nav class="navbar navbar-expand-md navbar-light navbar-laravel sticky-top">
		<div class="container-fluid">
			<div class="brand">
				<div id="menu_toggle" :class="{hideCats: hideCats}">
					<span></span>
					<span></span>
					<span></span>
				</div>
				<a class="navbar-brand" href="/">{{ brand }}</a>
			</div>

			<!-- Right Side Of Navbar -->
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<div class="nav-link totals">
						<span>Total: Ksh.</span>
						<span>{{ totals | threeDigitsCoversion }}</span>
					</div>
				</li>
				<li class="nav-item">
					<router-link to="/cart" class="nav-link ca-cart">
						<!-- <span>
							<i class="fa fa-cart-plus" :class="{changeStyle: !changeStyle}"></i>
						</span>-->
						<div class="icon">
							<font-awesome-icon icon="cart-plus" />
							<!-- <span>4</span> -->
							<span>{{ carts.length }}</span>
						</div>
					</router-link>
				</li>
				<!-- <li class="nav-item">
					<a class="nav-link" ref="login" @click="login" :style="loginMes">Login</a>
					<a class="nav-link" ref="logout" @click="logout" :style="logoutMes">Log Out</a>
					<span>{{ loginMessageFunction }}</span>
				</li>-->
				<li class="login">
					<a class="nav-link" ref="login" @click="login" :style="loginMes">Login</a>
				</li>
				<li class="dropdown" :style="logoutMes">
					<a class="dropdown-toggle d-block" data-toggle="dropdown" href="#">
						Dashboard
						<!-- <img
							src="/storage/Laptops/YZi0bzCckZfZiGFOgUb9SXYaaeKbXbmtMfPluZey.jpeg"
							alt
							class="img-circle img-fluid"
							width="50px"
						/> -->
					</a>
					<ul class="dropdown-menu dropdown-user dropdown-menu-right">
						<li class="nav-item">
							<router-link class="nav-link" to="/customer/myAccount">My Account</router-link>
							<!-- <a class="nav-link">My Account</a> -->
						</li>
						<li class="dropdown-divider"></li>
						<li class="nav-item">
							<a class="nav-link" ref="login" @click="login" :style="loginMes">Login</a>
							<a class="nav-link" ref="logout" @click="logout" :style="logoutMes">Log Out</a>
							<span>{{ loginMessageFunction }}</span>
						</li>
					</ul>
					<!-- /.dropdown-user -->
				</li>
				<!-- /.dropdown -->
			</ul>
		</div>
	</nav>
</template>

<script>
import { isNull } from "util";

export default {
	name: "customer-header",
	props: {
		totals: {
			type: Number,
			required: true
		},
		carts: {
			type: Array,
			required: true
		},
		brand: {
			type: String,
			required: true
		},
		hideCats: {
			type: Boolean,
			required: true
		},
		userLoggedIn: {
			type: Boolean,
			required: true
		}
	},
	data() {
		return {
			loginMes: "display: block",
			logoutMes: "display: none"
			// changeStyle: false
		};
	},
	methods: {
		login() {
			try {
				// const newFrom = from == null ? "/" : from;
				// const newTo = to == null ? "/" : to;

				const currentPaths = {
					pathFrom: this.$route.path,
					pathTo: "/customer-login",
					next: this.$route.path
				};

				const setPaths = JSON.stringify([currentPaths]);
				localStorage.setItem("redirectPathsName", setPaths);
				// console.log(this.$route.name);
				// localStorage.removeItem("redirectPathsName");
				this.$router.push({ name: "customer-login" });
				// alert(this.$route.name);
			} catch (e) {
				this.$emit("logged-in", true);

				return this.$router.push({ name: "customer-login" });
			}
		},
		logout() {
			// console.log(this.$route);

			if (this.$route.meta.requiresAuth) {
				const currentPaths = {
					pathFrom: this.$route.path,
					pathTo: "/customer-login",
					next: this.$route.path
				};

				const setPaths = JSON.stringify([currentPaths]);
				localStorage.setItem("redirectPathsName", setPaths);
			}

			axios
				.post("/customer-logout")
				.then(repsonse => {
					localStorage.removeItem("userInfo");
					this.$emit("logged-in", false);
					// localStorage.removeItem("redirectPathsName");
					window.location.reload();
				})
				.catch(error => {
					if (error.response.data.message == "CSRF token mismatch.") {
						return window.location.reload();
					}

					console.log("customer header " + error);
					console.log("customer header response " + error.response.data);
				});
			// console.log(this.$route.name);
		}
	},
	computed: {
		// sumTotal() {
		// 	// const arrSum = arr => arr.reduce((a, b) => a + b, 0);

		// 	return roundToTwoDecimals(this.totals).toLocaleString();
		// 	// return this.totals.reduce((a, b) => a + b, 0);
		// },
		loginMessageFunction() {
			// let userloggedIn = localStorage.getItem("userInfo");
			// console.log(this.userLoggedIn);

			// if (userloggedIn && !isNull(userloggedIn)) {
			if (this.userLoggedIn == true) {
				this.loginMes = "display: none";
				this.logoutMes = "display: block";
				// return this.$refs.loginMessage.innerHtml = '<a class="nav-link" href="/login">Login</a>';
				// console.log("-------" + localStorage.getItem("userInfo"));
			} else {
				if (localStorage.getItem("userInfo")) {
					this.loginMes = "display: none";
					this.logoutMes = "display: block";
				} else {
					this.loginMes = "display: block";
					this.logoutMes = "display: none";
				}
			}
		}
	}
};
</script>

<style scoped>
.img-circle {
	border-radius: 50%;
}
.hideCats {
	display: none;
}
.nav-link {
	padding: 0.4em;
}
.navbar-nav > li {
	margin-left: 0.3em;
	/* background: green; */
}
.navbar-nav > li:nth-child(1) > .nav-link > span:nth-child(1) {
	font-weight: 700;
}
.navbar-nav > li:nth-child(2) {
	margin-top: -4px;
}
.navbar-nav > li:nth-child(2) > a {
	padding: 3px 5px 5px 5px;
	/* background: red; */
}
/* .navbar-nav > li:nth-child(2) > a > i {
	padding: 0.3rem 0.5rem;
	color: #000;
} */
.navbar-nav > li:nth-child(2) > a > .icon > svg {
	vertical-align: bottom;
}
.navbar-nav > li:nth-child(2) > a > .icon > span {
	font-size: 14px;
	background: rgb(226, 54, 48);
	border-radius: 50%;
	color: #fff;
	padding: 2px 4px;
	vertical-align: super;
	margin-left: -4px;
}
.navbar-nav > li:nth-child(2) > a > i:hover,
.navbar-nav > li:nth-child(2) > a:nth-child(1):hover,
.login > .nav-link:hover {
	background-color: #000;
	color: #fff !important;
	/* border-radius: 10%; */
	cursor: pointer;
}
/*
.navbar-nav > li:nth-child(3) > a:nth-child(1):hover,
.navbar-nav > li:nth-child(3) > a:nth-child(2):hover { */
.dropdown-menu > .nav-item > .nav-link:hover {
	background-color: #3490dc;
	color: #fff !important;
	/* border-radius: 10%; */
	cursor: pointer;
}

@media (max-width: 767px) {
	.navbar-nav {
		flex-direction: initial;
	}
	.navbar-expand-md .navbar-nav .nav-link {
		padding-right: 0.5rem;
		padding-left: 0.5rem;
	}
}

@media (max-width: 500px) {
	.nav-item > .nav-link.totals {
		padding-right: 0.2rem;
		padding-left: 0.2rem;
	}
}
</style>


