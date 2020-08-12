<template>
	<div>
		<h5>
			<strong>Sales per Categories</strong>
		</h5>
		<div class="small">
			<!-- <line-chart></line-chart> -->
			<doughnut-chart v-if="loaded" :chart-data="datacollection" :options="options"></doughnut-chart>
		</div>
	</div>
</template>

<script>
import DoughnutChart from "./doughnutPieChart";

export default {
	components: {
		DoughnutChart
	},
	data() {
		return {
			loaded: true,
			datacollection: null,
			options: {
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
						// label: "Daily Visitors",
						data: [22, 29, 23, 15, 18, 20],
						// fill: false,
						backgroundColor: [
							"rgba(255, 99, 132, 1)",
							"rgba(54, 162, 235, 1)",
							"rgba(255, 206, 86, 1)",
							"#097309",
							"rgba(153, 102, 255, 1)",
							"rgba(255, 159, 64, 1)"
						]
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
.small {
	max-width: 600px;
	margin: 0px auto;
}
</style>
