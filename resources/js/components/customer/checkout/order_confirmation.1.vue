<template>
	<div class="container" style="margin-top: 5rem;">
		<div class="card text-center bg-success text-white">
			<div class="card-body">
				<p>Your order has been received successfully. You will receive an email confirming the purchase.</p>
			</div>
		</div>
	</div>
</template>

<script>
document.getElementById("ind-cont").style.minHeight = "354px";
// document.getElementsByTagName("footer").style.position = "fixed";
// console.log(document.getElementsByTagName("footer"));

export default {
	name: "order_confirmation",
	data() {
		return {};
	}
};
</script>

<style lang="scss" scoped>
</style>
