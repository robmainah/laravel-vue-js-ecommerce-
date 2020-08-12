<template>
	<div>
		<!-- <div class="row">
		<div class="col-6">-->
		<horizontal-bar-chart v-if="loaded" :chart-data="datacollection" :options="options"></horizontal-bar-chart>
		<!-- </div>
		</div>-->
		<!-- <div class="smalle"> -->
		<!-- <line-chart></line-chart> -->
		<!-- </div> -->
	</div>
</template>

<script>
import HorizontalBarChart from "./horizontalBarChart";

export default {
	props: ["productData"],
	components: {
		HorizontalBarChart
	},
	data() {
		return {
			loaded: true,
			datacollection: null,
			options: {
				scales: {
					xAxes: [
						{
							scaleLabel: {
								display: true,
								labelString: "Values"
							}
							// barPercentage: 1,
							// barThickness: 6,
							// maxBarThickness: 8,
							// minBarLength: 2,
							// gridLines: {
							// 	offsetGridLines: true
							// }
						}
					],
					yAxes: [
						{
							scaleLabel: {
								display: true,
								labelString: "Products"
							}
						}
					]
				},
				responsive: true,
				maintainAspectRatio: false
			}
		};
	},
	mounted() {
		this.fillData();
	},
	methods: {
		fillData() {
			// console.log(this.productData);

			this.datacollection = {
				labels: this.productData.products,
				datasets: [
					{
						label: "Original Stock",
						data: this.productData.quantity,
						fill: false,
						backgroundColor: "#f87979"
						// borderColor: [
						// 	"rgba(255, 99, 132, 1)",
						// 	"rgba(54, 162, 235, 1)",
						// 	"rgba(255, 206, 86, 1)",
						// 	"rgba(75, 192, 192, 1)",
						// 	"rgba(153, 102, 255, 1)",
						// 	"rgba(255, 159, 64, 1)"
						// ]
					},
					{
						label: "Current Sales",
						data: this.productData.sales,
						fill: false
						// backgroundColor: ["transparent"],
						// borderColor: [
						// 	"rgba(255, 99, 132, 1)",
						// 	"rgba(54, 162, 235, 1)",
						// 	"rgba(255, 206, 86, 1)",
						// 	"rgba(75, 192, 192, 1)",
						// 	"rgba(153, 102, 255, 1)",
						// 	"rgba(255, 159, 64, 1)"
						// ]
					}
				]
			};
		}
	}
};
</script>

<style>
/* .smalle {
	max-width: 600px;
	margin: 0px auto;
} */
</style>
