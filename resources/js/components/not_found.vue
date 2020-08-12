<template>
	<div class="container">
		<div class="row">
			<div class="col-8 offset-1">
				<div class="card text-center">
					<div class="card-body">
						<h2 class="card-title">Not Found</h2>
						<p class="card-text">
							Please
							<a href="javascript:void(0)" @click="$router.go(-1)">click here</a> to go back
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<style scoped>
.card {
	margin-top: 3em;
	margin-bottom: 3em;
}
p {
	font-size: 15px;
}
</style>

<script>
export default {
	name: "notFound",
	mounted() {
		this.$emit("hide-cat", true);
	}
};
</script>

<style scoped>
</style>
