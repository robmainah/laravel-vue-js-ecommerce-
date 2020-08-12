import Vue from 'vue';
import Vuex from 'vuex';
import axios from "axios";

Vue.use(Vuex);

export const store = new Vuex.Store({
    strict: true,
    state: {
        // products: [],
        users: [],
        checkedBoxes: [],
        customers: [],
        searchField: "",
        selCustomerData: [],
        selectedUserData: [],
        errors: {},
        showNewUserModal: false,
        showModal: false,
        displayMessage: {
            status: false,
            text: "",
            alertClass: ""
        },
        newUser: null

        // filteredUsers: null
    },
    getters: {
        newUser() {
            var newUser = {
                name: "",
                email: "",
                phone_number: "",
                idNumber: "",
                gender: "",
                dateOfBirth: "",
                roles: "",
                active: ""
            };
            return newUser;
        },
        getUsers: state => {
            var filteredUser = state.users.filter(user => {
                return Object.keys(user).some(key => {
                    let string = String(user[key]);
                    return string.toLowerCase().match(state.searchField.toLowerCase());
                });
            });
            // getters.users = filteringUser;
            return filteredUser;
        },
        getCustomers: state => {
            var filteredCustomers = state.customers.filter(customer => {
                return Object.keys(customer).some(key => {
                    let string = String(customer[key]);
                    return string.toLowerCase().match(state.searchField.toLowerCase());
                });
            });
            // getters.users = filteringUser;
            return filteredCustomers;
        }
    },
    mutations: {
        SHOW_MODAL: (state, value) => {
            state.showModal = value;
        },
        SET_USERS: (state, payload) => {
            state.users = payload;
        },
        SET_CUSTOMERS: (state, customers) => {
            state.custLoaded = true;
            state.customers = customers;
        },
        SELECTED_CUSTOMER: (state, value) => {
            state.selCustomerData.image = state.customers[value].image;
            state.selCustomerData.name = state.customers[value].name;
            state.selCustomerData.id = state.customers[value].id;
            state.selCustomerData.customerId = state.customers[value].customerId;
            state.selCustomerData.email = state.customers[value].email;
            state.selCustomerData.phone_number = state.customers[value].phone_number;
            state.selCustomerData.idNumber = state.customers[value].idNumber
            state.selCustomerData.address = state.customers[value].address;
            state.selCustomerData.gender = state.customers[value].gender;
            state.selCustomerData.active = state.customers[value].active;
        },
        SELECTED_USER: (state, index) => {
            // state.selectedUserData.image = state.users[value].image;
            state.selectedUserData.name = state.users[index].name;
            state.selectedUserData.id = state.users[index].id;
            state.selectedUserData.employeeId = state.users[index].employeeId;
            state.selectedUserData.email = state.users[index].email;
            state.selectedUserData.phone_number = state.users[index].phone_number;
            state.selectedUserData.dateOfBirth = state.users[index].dateOfBirth;
            state.selectedUserData.idNumber = state.users[index].idNumber
            state.selectedUserData.address = state.users[index].address;
            state.selectedUserData.gender = state.users[index].gender;
            state.selectedUserData.active = state.users[index].active;
            state.selectedUserData.roles = state.users[index].roles;
        },
        EDIT_CUSTOMER_INPUT: (state, value) => {
            state.selCustomerData[value[0]] = value[1];
        },
        EDIT_USER_INPUT: (state, value) => {
            state.selectedUserData[value[0]] = value[1];
        },
        UPDATE_CUSTOMERS_STATE: (state, index) => {
            let content = state.selCustomerData;
            let oldCustomer = state.customers[index]

            oldCustomer.customer_id = content.customerId;
            oldCustomer.name = content.name;
            oldCustomer.email = content.email;
            oldCustomer.phone_number = content.phone_number;
            oldCustomer.idNumber = content.idNumber;
            oldCustomer.address = content.address;
            oldCustomer.gender = content.gender;
            oldCustomer.active = content.active;

            content = [];
            state.showModal = false;
        },
        ADD_NEW_USER: (state, data) => {
            // console.log(data);

            let newUser = {
                id: data.id,
                employee_id: data.userId,
                name: data.name,
                email: data.email,
                phone_number: data.phone_number,
                idNumber: data.idNumber,
                // address: data.address,
                gender: data.gender,
                active: data.active,
                roles: data.roles
            }

            state.users[state.users.length] = newUser;
            // content = [];
            state.showModal = false;
        },
        UPDATE_USERS_STATE: (state, index) => {
            let oldUser = state.users[index]
            let newContent = state.selectedUserData;

            oldUser.id = newContent.id;
            oldUser.employee_id = newContent.employeeId;
            oldUser.name = newContent.name;
            oldUser.email = newContent.email;
            oldUser.phone_number = newContent.phone_number;
            oldUser.idNumber = newContent.idNumber;
            oldUser.address = newContent.address;
            oldUser.gender = newContent.gender;
            oldUser.active = newContent.active;
            oldUser.roles = newContent.roles;

            // content = [];
            state.showModal = false;
        },
        CHECK_BOXES: (state, value) => {
            let element = document.getElementById("allboxes");
            if (element) {
                // element.prop("checked", false)
                element.checked = false;
            }

            if (state.checkedBoxes.includes(value)) {
                const position = state.checkedBoxes.indexOf(value);
                state.checkedBoxes.splice(position, 1);
                return
            }

            let oldcheckedBoxes = state.checkedBoxes;
            oldcheckedBoxes.push(value);
            state.checkedBoxes = oldcheckedBoxes;
            return
        },
        CHECK_ALL_BOXES: (state, value) => {
            /* if (state.checkedBoxes.includes(value)) {
                const position = state.checkedBoxes.indexOf(value);
                return state.checkedBoxes.splice(position, 1);
            }

            let oldcheckedBoxes = state.checkedBoxes;
            oldcheckedBoxes.push(value); */
            if (value.length === 0) {
                let checkboxes = document.querySelectorAll("input[type='checkbox']");
                for (const box of checkboxes) {
                    box.checked = false;
                }
                state.checkedBoxes = value;
                return
            }
            let checkboxes = document.querySelectorAll("input[type='checkbox']");
            for (const box of checkboxes) {
                box.checked = true;
            }
            state.checkedBoxes = value;
            return
        },
        DELETE_USERS: (state) => {
            let checkboxes = document.querySelectorAll("input[type='checkbox']");
            for (const box of checkboxes) {
                box.checked = false;
            }
            const sortedCheckBoxes = state.checkedBoxes.sort(function(a, b) {
                return b - a;
            })
            sortedCheckBoxes.forEach(element => {
                state.users.splice(element, 1);
            });

            return;

            // state.checkedBoxes = [];
            // }
        },
        DELETE_CUSTOMERS: (state) => {
            let checkboxes = document.querySelectorAll("input[type='checkbox']");
            for (const box of checkboxes) {
                box.checked = false;
            }
            // state.checkedBoxes.sort().reverse().forEach(element => {}
            const sortedCheckBoxes = state.checkedBoxes.sort((a, b) => b - a)

            sortedCheckBoxes.forEach(element => {
                state.customers.splice(element, 1);
            });

            // state.checkedBoxes = [];
            // }
        },
        CLEAR_CHECKBOX: (state) => {
            state.checkedBoxes = [];
        },
        SET_ERRORS: (state, error) => {
            // console.log(error.data.errors);
            if (error != undefined) {
                // context.commit('DISPLAY_MESSAGE', message);
                state.errors = error.data.errors;
            }
        },
        CLEAR_ERRORS: (state) => state.errors = {},
        DISPLAY_MESSAGE: (state, message) => {
            state.displayMessage.text = message.text;
            state.displayMessage.alertClass = message.alertClass;
            state.displayMessage.status = message.status;
        },
        /* showNewUserModal: (state, value) => {
            // console.log(value);
            if (value === true) {
                return state.showNewUserModal = true;
            }

            state.errors = {};
            return state.showNewUserModal = false;
        }, */
        SEARCH_STRING: (state, string) => {
            /* var filteringUser = getters.users.filter(user => {
                return Object.keys(user).some(key => {
                    let string = String(user[key]);
                    return string.toLowerCase().match(payload.toLowerCase());
                });
            });
            getters.users = filteringUser; */
            state.searchField = string
        }
    },
    actions: {
        loadUsers: (context) => {
            axios
                .get("/users")
                // .then(response => console.log(response.data))
                .then(response => context.commit('SET_USERS', response.data))
                .catch(error => {
                    // console.log("failed -- " + error.data)
                    adminError(error)
                });
        },
        loadCustomers: (context) => {
            axios
                .get("/customers")
                .then(response => context.commit('SET_CUSTOMERS', response.data))
                .catch(error => {
                    // console.log("failed -- " + error.data)
                    customerError(error)
                });
        },
        // filterUser: (context, payload) => {
        //     context.commit('FILTER_USERS', payload);
        // },
        addNewUser: (context, userData) => {
            axios.post("/users", userData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(response => {
                    var message = {
                        text: response.data.success,
                        alertClass: "alert-success",
                        status: true
                    }

                    context.commit('ADD_NEW_USER', response.data.addedUser);
                    context.commit('DISPLAY_MESSAGE', message);
                })
                .catch(error => {
                    if (error) {
                        var message = {
                            text: error,
                            alertClass: "alert-danger",
                            status: true
                        }
                    }

                    context.commit('DISPLAY_MESSAGE', message);
                    context.commit('SET_ERRORS', error.response);

                    if (error.data == undefined) {
                        context.commit('DISPLAY_MESSAGE', message);
                    }

                    return adminError(error)
                });
        },
        updateUser: ({
            state,
            commit
        }, index) => {
            //Get data for the selected user you want to update
            const content = state.selectedUserData;

            let formData = new FormData();
            formData.append("name", content.name);
            formData.append("email", content.email);
            formData.append("phone_number", content.phone_number);
            formData.append("idNumber", content.idNumber);
            formData.append("gender", content.gender);
            formData.append("roles", content.roles);
            formData.append("active", content.active);
            formData.append("id", content.id);
            formData.append("dateOfBirth", content.dateOfBirth);

            axios.post("/users/update", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(response => {
                    var message = {
                        text: response.data.success,
                        alertClass: "alert-success",
                        status: true
                    }

                    commit('UPDATE_USERS_STATE', index);
                    commit('DISPLAY_MESSAGE', message);

                    setTimeout(() => {
                        commit('DISPLAY_MESSAGE', {
                            text: "",
                            status: false
                        });
                    }, 3000);
                })
                .catch(error => {
                    var message = {
                        text: error.response.data.message,
                        alertClass: "alert-danger",
                        status: true
                    }

                    commit('DISPLAY_MESSAGE', message);
                    commit('SET_ERRORS', error.response);

                    if (error.data == undefined) {
                        return commit('DISPLAY_MESSAGE', message);
                    }
                    adminError(error)

                    return;
                });
        },
        deleteUser: ({
            commit,
            state
        }) => {
            // return console.log(state.checkedBoxes);
            let listArray = [];

            // if (state.checkedBoxes === true) {
            //     state.users.forEach(element => {
            //         listArray.push(element.id);
            //     });
            // } else {
            state.checkedBoxes.forEach(element => {
                listArray.push(state.users[element].id);
            });
            // console.log(listArray);
            // }

            if (listArray.length < 1) {
                return commit("DISPLAY_MESSAGE", {
                    status: true,
                    alertClass: "alert-danger",
                    text: "Please select at least one field to delete !!!!"
                });
            }

            axios
                .delete(`/users/${listArray}`)
                .then(response => {
                    var message = {
                        text: response.data.success,
                        alertClass: "alert-success",
                        status: true
                    }

                    commit('DISPLAY_MESSAGE', message);
                    commit('DELETE_USERS');

                    setTimeout(() => {
                        commit('DISPLAY_MESSAGE', {
                            text: "",
                            status: false
                        });
                    }, 3000);
                })
                .catch(error => {
                    // console.log("errors >> " + error);

                    var message = {
                        text: error,
                        alertClass: "alert-danger",
                        status: true
                    }

                    commit('DISPLAY_MESSAGE', message);
                    // if (error.data.errors == undefined) {
                    //     context.commit('SET_ERRORS', error.data);

                    //     return this.displayMessageFunction(
                    //         error.data.message,
                    //         "alert-danger"
                    //     );
                    // }

                    // // console.log(error.response.data.errors);
                    // return context.commit('SET_ERRORS', error.data);
                    adminError(error)
                    return;
                });
        },
        updateCustomer: ({
            commit,
            state
        }, index) => {
            // console.log("dd " + state.selCustomerData.address);
            const content = state.selCustomerData;
            // console.log(content);
            let formData = new FormData();

            formData.append("id", content.id);
            formData.append("customer_id", content.customerId);
            formData.append("name", content.name);
            formData.append("email", content.email);
            formData.append("phone_number", content.phone_number);
            formData.append("idNumber", content.idNumber);
            formData.append("address", content.address);
            formData.append("gender", content.gender);
            formData.append("active", content.active);

            axios
                .post('/customers/update', formData)
                // .then(response => console.log(response.data))
                .then(response => {
                    // console.log("response -> " + response.data.success);

                    var message = {
                        text: response.data.success,
                        alertClass: "alert-success",
                        status: true
                    }

                    commit('UPDATE_CUSTOMERS_STATE', index);
                    commit('DISPLAY_MESSAGE', message);
                    // console.log(state.customers[index]);

                    setTimeout(() => {
                        commit('DISPLAY_MESSAGE', {
                            text: "",
                            status: false
                        });
                    }, 3000);
                })
                .catch(error => {
                    var message = {
                        text: error,
                        alertClass: "alert-danger",
                        status: true
                    }

                    commit('DISPLAY_MESSAGE', message);
                    // if (error.data.errors == undefined) {
                    //     context.commit('SET_ERRORS', error.data);

                    //     return this.displayMessageFunction(
                    //         error.data.message,
                    //         "alert-danger"
                    //     );
                    // }

                    // // console.log(error.response.data.errors);
                    context.commit('SET_ERRORS', error.data);
                    customerError(error)
                    return;
                });
        },
        deleteCustomer: ({
            commit,
            state
        }) => {
            // return console.log(state.checkedBoxes);
            let listArray = [];

            // if (state.checkedBoxes === true) {
            //     state.customers.forEach(element => {
            //         listArray.push(element.id);
            //     });
            // } else {
            state.checkedBoxes.forEach(element => {
                listArray.push(state.customers[element].id);
            });
            // }

            axios
                .delete(`/customers/${listArray}`)
                .then(response => {

                    var message = {
                        text: response.data.success,
                        alertClass: "alert-success",
                        status: true
                    }

                    commit('DISPLAY_MESSAGE', message);
                    commit('DELETE_CUSTOMERS');
                    commit('CLEAR_CHECKBOX');

                    setTimeout(() => {
                        commit('DISPLAY_MESSAGE', {
                            text: "",
                            status: false
                        });
                    }, 3000);
                })
                .catch(error => {
                    console.log("errors >> " + error);

                    var message = {
                        text: error,
                        alertClass: "alert-danger",
                        status: true
                    }

                    commit('DISPLAY_MESSAGE', message);
                    // if (error.data.errors == undefined) {
                    //     context.commit('SET_ERRORS', error.data);

                    //     return this.displayMessageFunction(
                    //         error.data.message,
                    //         "alert-danger"
                    //     );
                    // }

                    // // console.log(error.response.data.errors);
                    // return context.commit('SET_ERRORS', error.data);
                    customerError(error)

                    return;
                });
        },
        /* reducePrice: (context, payload) => {
            setTimeout(() => {
                context.commit('reducePrice', payload);
            }, 2000);
        } */
    }
})

function customerError(error) {
    if (error.response.data.message == "CSRF token mismatch.") {
        return window.location.reload();
    }

    if (error.response.data.message == "Unauthenticated.") {
        localStorage.removeItem("userInfo");
        this.$emit("logged-in", false);
        return this.$router.push({
            name: "customer-login"
        });
    }
}

function adminError(error) {
    if (error.response.data.message == "CSRF token mismatch.") {
        return window.location.reload();
    }

    if (error.response.data.message == "Unauthenticated.") {
        localStorage.removeItem("userInfo");
        this.$emit("logged-in", false);
        // return this.$router.push({ name: "admin-login" });
        this.setCustomPaths();
        // window.location.href = "/admin-login";
        return;
    }
}

function setCustomPaths() {
    // const currentPath = this.$route.path;
    const currentPaths = {
        pathFrom: this.$route.path,
        next: this.$route.path
    };

    const setPaths = JSON.stringify([currentPaths]);
    localStorage.setItem("redirectPathsName", setPaths);
}