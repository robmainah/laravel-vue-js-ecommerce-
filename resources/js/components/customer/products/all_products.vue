<template>
	<div>
		<div id="sidebar-wrapper">
			<div class="dash">
				<a href="javascript:void(0)">
					<i class="menu-icon fa fa-tachometer-alt"></i> Categories
				</a>
			</div>
			<ul class="sidebar-nav">
				<li>
					<a href="javascript:void(0)" @click="$emit('active-category','all')">All Products</a>
				</li>
				<li v-for="(category, index) in categories" :key="index">
					<a
						href="javascript:void(0)"
						@click="$emit('active-category',category.category_name)"
					>{{ category.category_name }}</a>
				</li>
			</ul>
		</div>
		<div id="page-content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-4 col-md-3 col-sm-4 prods" v-for="(product,index) in products" :key="index">
						<div
							class="card pr-cd"
							@mouseover="hover(product, 1)"
							@mouseout="hover(product, 0)"
							:class="{ hovered:product.hovered }"
						>
							<div class="pr-det text-center" @click="viewSingleProduct(index)">
								<div class="image">
									<img
										class="card-img-top"
										:src="'../storage/' + product.productImage"
										:alt="product.productAlt"
									/>
								</div>
								<p class="card-text">{{ product.productTitle }}</p>
								<p class="price">Ksh. {{ product.productPrice | threeDigitsCoversion }}</p>
							</div>
							<!-- <div class="card-body">
								<span class="price">Ksh. {{ product.productPrice }}</span>
								<a
									href="javascript:;"
									class="cart btn btn-warning"
									@click.prevent="add_cart(index)"
								>Add cart</a>
							</div>-->
							<div class="card-body text-center">
								<p class="cart btn btn-warning" @click.prevent="add_cart(index)">Add cart</p>
								<!-- <p class="cart btn btn-warning" @click="reducePrice(4)">Reduce price</p> -->
							</div>
						</div>
					</div>
					<!-- </div> -->
					<!-- </div> -->
				</div>
			</div>
		</div>
	</div>
</template>

<script>
// import { mapGetters } from "vuex";
// import { mapActions } from "vuex";
// import { mapState } from "vuex";

export default {
	name: "allProducts",
	props: {
		products: {
			type: Array,
			required: true
		},
		categories: {
			type: Array,
			required: true
		}
	},
	// beforeRouteEnter(to, from, next) {
	// 	next(vm => {
	// 		console.log(vm.$route);
	// 	});
	// },
	data() {
		return {
			hovers: "",
			btnColor: false,
			base_location: window.location
		};
	},
	mounted() {
		this.$emit("hide-cat", false);
		// console.log(window.location);
	},
	methods: {
		viewSingleProduct(index) {
			// console.log(slug);

			this.$router.push({ name: "singleProduct", params: { Pid: index } });
			// this.$router.push({ name: "singleProduct", params: { slug: slug } });
		},
		add_cart(index) {
			this.$emit("add-to-cart", index);
		},
		hover(product, v) {
			product.hovered = v;
		}
	},
	computed: {
		//
	}
};
</script>


<style scoped>
/* @media (min-width: 767px) { */
/* .pr-cd:hover {
    background-color: #e8d52d82;
    box-shadow: lightgray 3px 3px;
    border: 1px solid #c2bdbd;
} */
.btn-warning:hover {
	background-color: #3490dc;
	color: #fff;
	border-color: #3490dc;
	cursor: pointer;
}
/* } */

/* .hovered {
	border: 1px solid #c2bdbd;
	 box-shadow: lightgray 3px 3px;
} */

.pr-det:hover {
	cursor: pointer;
}

.pr-det .card-text {
	margin-bottom: 5px;
}

.pr-cd > .card-body {
	padding: 0rem 0em 0em 0em;
}
.card-img-top {
	/* margin-bottom: 0.5em; */
	max-height: 205px;
}
</style>
