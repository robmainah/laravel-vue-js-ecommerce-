<template>
	<div>
		<!-- <div class="small"> -->
		<!-- <line-chart></line-chart> -->
		<bar-chart v-if="loaded" :chart-data="datacollection" :options="options"></bar-chart>
		<!-- </div> -->
	</div>
</template>

<script>
import BarChart from "./barChart";

export default {
	components: {
		BarChart
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
								labelString: "Colors"
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
			this.datacollection = {
				labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
				datasets: [
					{
						label: "Daily Visitors",
						data: [22, 29, 23, 15, 18, 20],
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
						label: "No of orders",
						data: [12, 19, 13, 6, 8, 10],
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
/* .small {
	max-width: 600px;
	margin: 0px auto;
} */
</style>
