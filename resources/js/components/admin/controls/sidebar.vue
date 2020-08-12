<template>
	<div id="sidebar-wrapper" class="admin-sidebar">
		<div class="dash" style="background: #000">
			<a href="javascript:void(0)">
				<i class="menu-icon fa fa-tachometer-alt"></i> dashboard
			</a>
		</div>
		<ul class="sidebar-nav">
			<li>
				<router-link to="/account/admin/customers">
					<span>Customers</span>
				</router-link>
			</li>
			<li>
				<router-link to="/account/admin/categories">
					<span>Categories</span>
				</router-link>
			</li>
			<li>
				<router-link to="/account/admin/products">
					<span>
						<i class="fa fa-cart-arrow-down"></i>
					</span>
					<span>Products</span>
				</router-link>
			</li>
			<li>
				<router-link to="/account/admin/orders">
					<span>
						<i class="fa fa-money"></i>
					</span>
					<span>Orders</span>
				</router-link>
			</li>
			<li>
				<router-link to="/account/admin/payments">
					<span>
						<i class="fa fa-money"></i>
					</span>
					<span>Payments</span>
				</router-link>
			</li>
			<li>
				<router-link to="/account/admin/users">
					<span>
						<i class="fa fa-user"></i>
					</span>
					<span>Users</span>
				</router-link>
			</li>
			<li>
				<router-link to="/account/admin/dashboard">
					<span>
						<i class="fa fa-cogs"></i>
					</span>
					<span>Analytics</span>
				</router-link>
			</li>
		</ul>
	</div>
</template>

<script>
export default {
	name: "admin-sidebar",
	data() {
		return {
			// products: true
		};
	},
	methods: {
		// filterCategory(value) {
		// 	this.$emit("active-category", value);
		// }
	}
};
</script>
<style scoped>
.active > a {
	background-color: #ffc107;
}
</style>


