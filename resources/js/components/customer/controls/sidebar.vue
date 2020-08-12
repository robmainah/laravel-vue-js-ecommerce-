<template>
	<div id="sidebar-wrapper">
		<div class="dash">
			<a href="javascript:void(0)">
				<i class="menu-icon fa fa-tachometer-alt"></i> products
			</a>
		</div>
		<ul class="sidebar-nav">
			<li>
				<a href="javascript:void(0)" @click="$emit('active-category','all')">All Products</a>
			</li>
			<li v-for="(category, index) in categories" :key="index">
				<a
					href="javascript:void(0)"
					@click="$emit('active-category',category.category)"
				>{{ category.category }}</a>
			</li>
			<!-- <li v-for="(category, index) in categories" :key="index">
				<a href="javascript:void(0)" @click="filterCategory">{{ category.category }}</a>
			</li>-->
		</ul>
	</div>
</template>

<script>
export default {
	data() {
		return {
			categories: []
		};
	},
	mounted() {
		axios
			.get("/categories/get")
			.then(response => (this.categories = response.data))
			.catch(response => console.log(response.data.message));
	},
	methods: {
		filterCategory(val) {
			console.log("---------------------------");

			// this.$emit("active-category", val);
		}
	}
};
</script>
