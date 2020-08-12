require("./bootstrap");

window.Vue = require("vue");

import VueRouter from "vue-router";
import routes from "./components/routes";
import {
    store
} from "./store/store";

//customer components
import Myheader from "./components/customer/controls/header.vue";
import Myfooter from "./components/customer/controls/footer.vue";

// import Mysidebar from "./components/customer/controls/sidebar.vue";

//Admin components
// import dashboard from "./components/admin/dashboard.vue";
import Adminsidebar from "./components/admin/controls/sidebar.vue";
// import Admincontent from "./components/admin/controls/adminContent.vue";

// import { Store } from "vuex";

// import Axios from "axios";
// import Adminheader from "./components/admin/controls/header.vue";

import {
    library
} from '@fortawesome/fontawesome-svg-core';
import {
    faEdit,
    faTrash,
    faCartPlus,
    faPrint,
    faSearch,
    faEye
} from '@fortawesome/free-solid-svg-icons'
import {
    FontAwesomeIcon
} from '@fortawesome/vue-fontawesome'

library.add(faEye, faEdit, faTrash, faPrint, faSearch, faCartPlus)

Vue.use(VueRouter);

Vue.filter('threeDigitsCoversion', function(value) {
    return roundToTwoDecimals(value).toLocaleString();
})

Vue.filter('stringLengthShorten', function(value) {
    if (value == null) {
        return " ------- "
    }

    if (value.length > 30) {
        let trimmedString = value.slice(0, 30)
        trimmedString = trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" ")))

        return trimmedString + " ....."
    }

    return value
})

Vue.filter('changeDateFormat', function(value) {
    // const date = this.$store.state.users[this.selectedUser].dateOfBirth;
    const year = new Date(value).getFullYear();
    const month = ("0" + (new Date(value).getMonth() + 1)).slice(-2);
    const day = ("0" + new Date(value).getDate()).slice(-2);

    return day + "-" + month + "-" + year
})

const router = new VueRouter({
    routes,
    mode: "history"
});

router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some((record) => {
        return record.meta.requiresAuth;
    })


    const newFrom = from.path == null ? "/" : from.path
    const newTo = to.path == null ? "/" : to.path

    // console.log(from, to)
    const newRedirectPath = from.name == null ? "allProducts" : from.name
    if ((to.path == "/customer-login") && userAuthenticated()) {
        return next({
            name: newRedirectPath
        })
    }

    if ((requiresAuth && !userAuthenticated())) {
        const currentPaths = {
            pathFrom: newFrom,
            pathTo: newTo,
            next: newTo
        };

        // let redirectPaths = routesRedirection();
        // console.log("fr " + newFrom);
        // console.log("ne " + newTo);
        // console.log(newFrom);

        // if (redirectPaths[redirectPaths.length - 1] != undefined) {
        //     // console.log("to " + redirectPaths[redirectPaths.length - 1]['pathTo']);

        //     if (redirectPaths[redirectPaths.length - 1]['pathTo'] != newTo) {
        //         redirectPaths.push(currentPaths);
        //     }
        // } else {
        //     redirectPaths.push(currentPaths);
        // }
        // redirectPaths.push([currentPaths]);


        const setPaths = JSON.stringify([currentPaths]);
        localStorage.setItem("redirectPathsName", setPaths);

        // if (to.meta.admin) {
        //     return next({
        //         name: 'admin-login'
        //     });
        // }

        // return next({
        //     name: 'customer-login'
        // });
    }

    return next();
})


Vue.component('font-awesome-icon', FontAwesomeIcon)

const customerApp = new Vue({
    store,
    el: "#customerApp",
    router,
    data: {
        hideCats: true,
        activeCatTag: "",
        selectedProduct: -1,
        brand: "SpaceX",
        carts: [],
        productsLists: [],
        categories: [],
        userLoggedIn: false
            // products: items
    },
    components: {
        Myheader,
        // Mysidebar,
        Myfooter
    },
    mounted() {
        // userAuthenticated();
        // console.log(localStorage.getItem("userInfo"));

        if (localStorage.getItem("spacex")) {
            try {
                const getLocalData = JSON.parse(localStorage.getItem("spacex"));

                this.carts = getLocalData;
                //this.carts = getLocalData[1];
                // localStorage.removeItem("spacex");
            } catch (e) {
                localStorage.removeItem("spacex");
            }
        }

        axios.get("/customer/getProducts")
            .then(response => {
                this.productsLists = response.data.products
                    // for (const iterator of response.data) {
                    //     this.categories.push(iterator.category)
                    //     console.log(iterator.category);
                    // }
                this.categories = response.data.categories

            })
            .catch(error => console.log("mounted " + error));
    },
    methods: {
        //hides the menu toggle icons for pages other than the all products page
        hideCategory(value) {
            this.hideCats = value;
        },
        userLoginStatus(val) {
            // console.log("login " + val);

            this.userLoggedIn = val;
        },
        emptyCart() {
            this.carts = [];
            localStorage.removeItem("spacex");
        },
        updateQty(value) {
            let prod = value.split("-");

            this.carts.forEach(cart => {
                if (cart.id == prod[0]) {
                    if (prod[1] < 1) {
                        cart.qty = 1
                    } else {
                        cart.qty = prod[1];
                    }
                    this.saveDataLocal();
                }
            });
        },
        updateCart(index) {
            var found = false;
            this.carts.forEach(element => {
                if (element.id === this.products[index].productId) {
                    found = true;
                }
            });

            if (found == false) {
                let newItem = {
                    id: this.products[index].productId,
                    price: this.products[index].productPrice,
                    qty: 1,
                    index: index
                };
                this.carts.push(newItem);

                this.saveDataLocal();
            }
        },
        removeCart(id) {
            let i = 0;
            let newCartItems = [];
            this.carts.forEach(element => {
                if (element.id != id) {
                    newCartItems.push(element);
                }
            });

            this.carts = newCartItems;
            this.saveDataLocal();
        },
        saveDataLocal() {
            const parsed = JSON.stringify(this.carts);
            localStorage.setItem("spacex", parsed);
        },
        updateProdSelected(index) {
            this.selectedProduct = index;
        },
        activeCategory(value) {
            this.activeCatTag = value.toLowerCase();
        }
    },
    computed: {
        products() {
            let newProductsList = [];

            // for (let index = 0; index < this.productsLists.length; index++) {
            //     const element = this.productsLists[index];
            this.productsLists.forEach((element, index) => {
                let itemsLists = {
                    productId: element.productId,
                    productTitle: element.title,
                    productSlug: element.slug,
                    productImage: element.image,
                    productAlt: element.imageAlt,
                    productDescription: element.description,
                    productCategory: element.category,
                    productPrice: element.price,
                    hovered: false,
                    qty: 1
                }

                this.carts.forEach(cart => {
                    if (cart.id === element.productId) {
                        itemsLists.qty = cart.qty
                    }
                });
                newProductsList.push(itemsLists);
            });

            if (this.activeCatTag == "all") {
                return newProductsList;
            }

            return newProductsList.filter(product => {
                // return product.productCategory.match(this.activeCatTag);
                let output = product.productCategory.toLowerCase().match(this.activeCatTag);

                return output;
            });
        },
        totals() {
            let total = 0;

            this.carts.forEach(element => {
                total += (Number(element.price) * Number(element.qty))
            });

            return total;
        }
    },
    // mixins: [authenticationMixins]
});

const adminApp = new Vue({
    el: "#adminApp",
    store,
    data: {
        modalopen: "",
    },
    router,
    components: {
        // dashboard,
        Adminsidebar,
        // Admincontent,
        // ActivityGraph,
        // Adminheader
    },
    methods: {
        modalOpenControl(val) {
            this.modalopen = val;
        },
        closeModalControl(val) {
            this.modalopen = val;
        }
    }
})

function roundToTwoDecimals(num) {
    return +(Math.round(num + "e+2") + "e-2");
}

function userAuthenticated() {
    try {
        const user = localStorage.getItem('userInfo')
        if (user) {
            return true;
        }

        return false;
    } catch (error) {
        return false;
    }
}

function routesRedirection() {
    try {
        const pathsName = JSON.parse(localStorage.getItem("redirectPathsName"));
        if (pathsName == null) {
            return [];
        }
        return pathsName
    } catch (error) {
        localStorage.removeItem("redirectPathsName");
    }
}
