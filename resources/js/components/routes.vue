<script>
import notFound from "./not_found.vue";

//Customer pages
import allProducts from "./customer/products/all_products.vue";
import singleProduct from "./customer/products/single_product.vue";
import cart from "./customer/carts/cart.vue";
import checkout from "./customer/checkout/checkout.vue";
import customerLoginPage from "./customer/login/customer_login.vue";
import verifyEmail from "./customer/login/verify_email";
import verifiedEmail from "./customer/login/verified_email";
import passwordResetRequest from "./customer/login/password_reset_request";
import passwordReset from "./customer/login/password_reset";
import orderConfirmation from "./customer/checkout/order_confirmation.vue";
import CustomerAccount from "./customer/account/dashboard";

//Admin pages
import categories from "./admin/categories/categories.vue";
import adminLogin from "./admin/login/admin_login";
import adminPasswordResetRequest from "./admin/login/password_reset_request";
import adminPasswordReset from "./admin/login/password_reset";
import products from "./admin/products/products.vue";
import payments from "./admin/payments/payments.vue";
import orders from "./admin/orders/orders.vue";
import users from "./admin/users/users.vue";
import customers from "./admin/customers/customers.vue";
import dashboard from "./admin/dashboard.vue";

export default [
	{
		path: "/",
		name: "allProducts",
		component: allProducts
	},
	{
		path: "/view_product/:Pid",
		name: "singleProduct",
		component: singleProduct
	},
	{
		path: "/cart",
		name: "cart",
		component: cart
	},
	{
		path: "/checkout",
		name: "checkout",
		component: checkout,
		meta: {
			requiresAuth: true
		}
	},
	{
		path: "/customer-login",
		name: "customer-login",
		component: customerLoginPage
	},
	{
		path: "/email/verify",
		name: "verify_email",
		component: verifyEmail
	},
	{
		path: "email/verify/:email/:token",
		name: "verified_email",
		component: verifiedEmail
	},
	{
		path: "/password/reset",
		name: "password-reset-request",
		component: passwordResetRequest
	},
	{
		path: "/password/reset/:token",
		name: "password-reset",
		component: passwordReset
		// redirect: "/password/reset/:token"
	},
	{
		path: "/order_confirmation",
		name: "order_confirmation",
		component: orderConfirmation,
		meta: {
			requiresAuth: true
		}
	},
	{
		path: "/customer/myAccount",
		name: "customer_account",
		component: CustomerAccount,
		meta: {
			requiresAuth: true
		}
	},
	//Admin routes
	{
		path: "/admin-login",
		name: "admin-login",
		component: adminLogin
	},
	{
		path: "/admin/password/reset",
		name: "admin-password-reset-request",
		component: adminPasswordResetRequest
	},
	{
		path: "/admin/password/reset/:token",
		name: "admin-password-reset",
		component: adminPasswordReset
	},
	{
		path: "/account/admin/dashboard",
		name: "dashboard",
		component: dashboard,
		// meta: {
		// 	requiresAuth: true,
		// 	admin: true
		// }
	},
	{
		path: "/account/admin/categories",
		name: "categories",
		component: categories,
		// meta: {
		// 	requiresAuth: true,
		// 	admin: true
		// }
	},
	{
		path: "/account/admin/products",
		name: "products",
		component: products,
		// meta: {
		// 	requiresAuth: true,
		// 	admin: true
		// }
	},
	{
		path: "/account/admin/payments",
		name: "payments",
		component: payments,
		// meta: {
		// 	requiresAuth: true,
		// 	admin: true
		// }
	},
	{
		path: "/account/admin/orders",
		name: "orders",
		component: orders,
		// meta: {
		// 	requiresAuth: true,
		// 	admin: true
		// }
	},
	{
		path: "/account/admin/users",
		name: "users",
		component: users,
		// meta: {
		// 	requiresAuth: true,
		// 	admin: true
		// }
	},
	{
		path: "/account/admin/customers",
		name: "customers",
		component: customers,
		// meta: {
		// 	requiresAuth: true,
		// 	admin: true
		// }
	},
	{
		path: "*",
		name: "notFound",
		component: notFound
		// redirect: "/"
	}
];
</script>
