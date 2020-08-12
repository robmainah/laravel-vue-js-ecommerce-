<template>
	<div>
		<div class="container-fluid" style="margin-top: 0.2rem">
			<div class="row justify-content-center">
				<div class="col-12">
					<ul class="nav nav-pills nav-justified nav- border-bottom" id="myTab" role="tablist">
						<li class="nav-item border-right" v-for="tab in tabs" :key="tab" @click="selected = tab;">
							<a
								href="javascript:;"
								class="nav-link"
								role="tab"
								:class="['tab-btn', { active: selected === tab }]"
							>{{ tab }}</a>
							<!-- <a class="nav-link" href="register">Register</a> -->
						</li>
					</ul>
					<section style="margin-top: 0.05rem">
						<keep-alive>
							<component :is="selected" class="tab"></component>
						</keep-alive>
					</section>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import Profile from "./profile";
import CurrentBasket from "./current_basket";
import PreviousPurchases from "./previous_purchases";

export default {
	name: "customer_account",
	mounted() {
		// if (!localStorage.getItem("spacex")) {
		// 	return this.$router.push({ name: "allProducts" });
		// }
		// this.$emit("cart-empty");
		// localStorage.removeItem("spacex");
	},
	data: function() {
		return {
			tabs: ["Profile", "CurrentBasket", "PreviousPurchases"],
			selected: "CurrentBasket"
		};
	},
	components: {
		Profile,
		PreviousPurchases,
		CurrentBasket
	}
};
</script>

<style>
.tab-btn {
	padding-top: 0.6rem !important;
	padding-bottom: 0.6rem !important;
	background: #ffffff;
	cursor: pointer;
	/* margin-bottom: 1rem; */
	/* border: 1px solid #cccccc; */
	outline: none;
}

/* .active {
	border-bottom: 3px solid green;
	background: "#fcfcf";
} */
/* li a {
	padding-top: 5px;
	padding-bottom: 5px;
} */
/* .tab {
	border: 1px solid #ccc;
	padding: 10px;
} */
</style>
