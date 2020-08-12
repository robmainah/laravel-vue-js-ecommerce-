<template>
	<nav class="navbar navbar-expand-md navbar-light navbar-laravel sticky-top">
		<div class="container-fluid">
			<div class="brand">
				<div id="menu_toggle">
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
					</div>
				</li>
				<li class="nav-item">
					<router-link to="/cart" class="nav-link">
						<span>Cart</span>
					</router-link>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/login">Login</a>
					<!-- <router-link to="/login" class="nav-link">Login</router-link> -->
				</li>
			</ul>
		</div>
	</nav>
</template>

<script>
export default {
	props: {},
	data() {
		return {
			brand: "SpaceX"
		};
	},
	computed: {}
};
</script>

<style scoped>
</style>


