<template>
	<div class="container-fluid adm">
		<div class="card">
			<div class="card-body" style="padding: 1rem 1rem 0;">
				<section class="row justify-content-between ad-dash">
					<div class="col-3 das-usr">
						<div class="float-left border-right pt-3 pb-3 text-white bg-success">
							<h4 class="float-left">
								<font-awesome-icon icon="trash" />
							</h4>
							<h4 class="float-left">Customers</h4>
						</div>
						<h3>{{ customers }}</h3>
					</div>
					<div class="col-3 das-usr">
						<div class="float-left border-right pt-3 pb-3 text-white">
							<h4 class="float-left">
								<font-awesome-icon icon="trash" />
							</h4>
							<h4 class="float-left">Daily visitors</h4>
						</div>
						<h3>{{ visitors }}</h3>
					</div>
					<div class="col-3 das-usr">
						<div class="float-left border-right pt-3 pb-3 text-white bg-info">
							<h4 class="float-left">
								<font-awesome-icon icon="trash" />
							</h4>
							<h4 class="float-left">Sales</h4>
						</div>
						<h3>{{ sales }}</h3>
					</div>
					<div class="col-3 das-usr">
						<div class="float-left border-right pt-3 pb-3 text-white">
							<h4 class="float-left pr-1">
								<font-awesome-icon icon="cart-plus" />
							</h4>
							<h4 class="float-left">Orders</h4>
						</div>
						<h3>{{ orders }}</h3>
					</div>
				</section>
			</div>
			<span style="padding-left: 1rem;padding-right: 1rem;">
				<hr />
			</span>

			<!-- <doughnutPieGraph></doughnutPieGraph> -->
			<!-- &nbsp; -->

			<div class="row">
				<div class="col-12">
					<div class="card card-body text-center">
						<h5>
							<strong>Sales</strong>
						</h5>
						<lineGraph v-if="salesloaded" :product-sales="productSales"></lineGraph>
					</div>
				</div>
			</div>
			<!-- horizontal graph showing sales of products -->
			&nbsp;
			<div class="row">
				<div class="col-6 text-center">
					<div class="card">
						<div class="card-body" style="padding: 1rem 0">
							<h5>
								<strong>Products Sales</strong>
							</h5>
							<horizontalBarGraph v-if="productsloaded" :product-data="productData"></horizontalBarGraph>
						</div>
					</div>
				</div>
				<div class="col-6 text-center">
					<div class="card">
						<div class="card-body" style="padding: 1rem 0">
							<h5>
								<strong>Daily Visitors vs Conversions</strong>
							</h5>
							<barGraph></barGraph>
						</div>
					</div>
				</div>
			</div>

			<!-- <hr /> -->
		</div>
	</div>
</template>

<script>
import barGraph from "./graphs/barGraph";
import lineGraph from "./graphs/lineGraph";
import horizontalBarGraph from "./graphs/horizontalBarGraph";
import doughnutPieGraph from "./graphs/doughnutPieGraph";

export default {
	name: "adminDashboard",
	data() {
		return {
			salesloaded: false,
			productsloaded: false,
			customers: null,
			orders: null,
			sales: null,
			visitors: null,
			productSales: [],
			productData: []
		};
	},
	components: {
		barGraph,
		lineGraph,
		doughnutPieGraph,
		horizontalBarGraph
	},
	mounted() {
		this.fillSumarries();
		// alert(document.cookie)
		// this.fillOrders();
		this.fillSales();
		this.fillProducts();
	},
	methods: {
		fillSumarries() {
			axios
				.get("/dashboard/summary")
				.then(response => {
					this.customers = response.data.customers;
					this.orders = response.data.orders;
					this.sales = response.data.sales;
				})
				.catch(error => console.log("error - " + error));
		},
		fillSales() {
			axios
				.get("/dashboard/sales")
				.then(response => {
					this.productSales = response.data;
					this.salesloaded = true;
				})
				.catch(error => console.log("error - " + error));
		},
		fillProducts() {
			axios
				.get("/dashboard/products")
				.then(response => {
					// console.log(response.data);

					this.productData = response.data;
					this.productsloaded = true;
					// this.orders = response.data.orders;
					// this.sales = response.data.sales;
				})
				.catch(error => console.log("error - " + error));
		}
	}
};
</script>

<style lang="scss" scoped>
</style>
