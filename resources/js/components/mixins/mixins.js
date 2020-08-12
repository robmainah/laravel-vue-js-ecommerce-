export default {
    methods: {
        customerLogin() {
            let formData = new FormData();

            formData.append("email", this.user.email);
            formData.append("password", this.user.password);
            formData.append("remember", this.user.remember);

            axios
                .post("/customer-login", formData)
                .then(response => {
                    if (response.data.errors) {
                        return (this.errors = response.data.errors);
                    }

                    if (response.data.loginFail) {
                        this.errors = [];
                        this.user.password = "";

                        return this.displayMessageFunction(
                            response.data.loginFail,
                            "alert-danger"
                        );
                    }

                    if (response.data.loginSuccess == true) {
                        const parsed = JSON.stringify(response.data.user);
                        localStorage.setItem("userInfo", parsed);
                        this.$emit("logged-in", true);

                        return this.routesRedirection();
                    }
                    return this.routesRedirection();
                })
                .catch(error => {
                    // console.log(error.response.data);

                    if (error.response.data.errors == undefined) {
                        this.errors = error.response.data;

                        if (error.response.data.message == "CSRF token mismatch.") {
                            return window.location.reload();
                        }

                        return false;
                    }

                    return (this.errors = error.response.data.errors);
                });
        },
        /* unAuthenticatedError() {
            if (error.message == "Request failed with status code 401") {
                return window.location.reload();
            }
        } */
        // displayMessageFunction(message, color) {
        //     this.alertClass = color;
        //     this.$refs.displayMessage.innerText = message;
        //     this.dispMes = true;
        // },
        // routesRedirection() {
        //     try {
        //         const pathsName = JSON.parse(localStorage.getItem("redirectPathsName"));
        //         if (pathsName == null) {
        //             return [];
        //         }

        //         let nextPath = pathsName[0]["next"];
        //         if (nextPath == "/customer-login") {
        //             nextPath = "/";
        //         }

        //         window.location.href = nextPath;
        //         // this.$router.push({ name: nextPath });
        //         localStorage.removeItem("redirectPathsName");

        //         // window.location.reload();
        //     } catch (error) {
        //         localStorage.removeItem("redirectPathsName");
        //         // console.log(error);
        //     }
        // }
    }
}
