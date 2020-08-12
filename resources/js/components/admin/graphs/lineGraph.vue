<template>
	<div>
		<!-- <div class="small"> -->
		<!-- <line-chart></line-chart> -->
		<line-chart v-if="loaded" :chart-data="datacollection" :options="options"></line-chart>
		<!-- <button @click="fillData()">Randomize</button> -->
		<!-- </div> -->
	</div>
</template>

<script>
import LineChart from "./LineChart.js";

export default {
	props: ["productSales"],
	components: {
		LineChart
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
								labelString: "Months"
							}
						}
					],
					yAxes: [
						{
							scaleLabel: {
								display: true,
								labelString: "Values"
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
			// console.log(this.productSales);

			this.datacollection = {
				labels: this.productSales.months,
				datasets: [
					// {
					// 	label: "GitHub Commits",
					// 	// backgroundColor: "#f87979",
					// 	fill: false,
					// 	data: [70, 20, 70, 39, 10, 40, 12, 80, 80, 20, 12, 11]
					// },
					{
						label: "Monthly Sales",
						borderColor: "#3490dc",
						// backgroundColor: "#A5CC82",
						fill: false,
						data: this.productSales.totals
					}
				]
			};
		}
	}
};
</script>

<style>
/* .small {
	max-width: 600px;
	margin: 0px auto;
} */
</style>
