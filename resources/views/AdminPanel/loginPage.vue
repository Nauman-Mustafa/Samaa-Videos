<template>
    <div class="container">
        <div class="row justify-content-center vh-100 align-items-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-0">
                        <div class="row">
                            <!-- Left Side - Logo and Title -->
                            <div
                                class="col-lg-6 d-flex flex-column justify-content-center align-items-center p-5 bg-gradient-primary"
                            >
                                <img
                                    src="../../../public/images/App-logo.jpg"
                                    alt="SAMAA Logo"
                                    class="mb-4"
                                    style="width: 200px; height: auto"
                                />
                                <h1 class="text-white text-center mb-4">
                                    SAMAA Inventory Management System
                                </h1>
                                <p class="text-white-50 text-center">
                                    Manage your assets efficiently and
                                    effectively
                                </p>
                            </div>
                            <!-- Right Side - Login Form -->
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">
                                            Welcome Back!
                                        </h1>
                                    </div>
                                    <form
                                        class="user"
                                        @submit.prevent="submitLoginForm"
                                    >
                                        <div class="form-group">
                                            <input
                                                type="email"
                                                class="form-control form-control-user"
                                                :class="{
                                                    'is-invalid': errors.email,
                                                }"
                                                v-model="email"
                                                placeholder="Enter Email Address..."
                                            />
                                            <div
                                                class="invalid-feedback"
                                                v-if="errors.email"
                                            >
                                                {{ errors.email }}
                                            </div>
                                        </div>
                                        <div
                                            class="form-group position-relative"
                                        >
                                            <div class="input-group">
                                                <input
                                                    :type="
                                                        showPassword
                                                            ? 'text'
                                                            : 'password'
                                                    "
                                                    class="form-control form-control-user"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.password,
                                                    }"
                                                    v-model="password"
                                                    placeholder="Password"
                                                />
                                                <div class="password-toggle">
                                                    <i
                                                        class="fas"
                                                        :class="
                                                            showPassword
                                                                ? 'fa-eye-slash'
                                                                : 'fa-eye'
                                                        "
                                                        @click="togglePassword"
                                                    ></i>
                                                </div>
                                            </div>
                                            <div
                                                class="invalid-feedback"
                                                v-if="errors.password"
                                            >
                                                {{ errors.password }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div
                                                class="custom-control custom-checkbox small"
                                            >
                                                <input
                                                    type="checkbox"
                                                    class="custom-control-input"
                                                    id="customCheck"
                                                    v-model="rememberMe"
                                                />
                                                <label
                                                    class="custom-control-label"
                                                    for="customCheck"
                                                >
                                                    Remember Me
                                                </label>
                                            </div>
                                        </div>
                                        <button
                                            type="submit"
                                            class="btn btn-primary btn-user btn-block"
                                            :disabled="isLoggingIn"
                                        >
                                            {{
                                                isLoggingIn
                                                    ? "Logging in..."
                                                    : "Login"
                                            }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
    data() {
        return {
            email: "",
            password: "",
            rememberMe: false,
            errors: {},
            isLoggingIn: false,
            showPassword: false,
        };
    },
    methods: {
        ...mapActions(["login"]),
        async submitLoginForm() {
            if (this.isLoggingIn) return;

            // Reset errors
            this.errors = {};

            // Validate
            if (!this.email) this.errors.email = "Email is required";
            if (!this.password) this.errors.password = "Password is required";
            if (Object.keys(this.errors).length > 0) return;

            try {
                this.isLoggingIn = true;
                await this.login({
                    email: this.email,
                    password: this.password,
                });

                // Show success message
                this.$swal({
                    title: "Success!",
                    text: "Login successful",
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false,
                });

                // Redirect to dashboard
                this.$router.push("/");
            } catch (error) {
                // Show error message
                this.$swal({
                    title: "Error!",
                    text:
                        error.response?.data?.message || "Invalid credentials",
                    icon: "error",
                    confirmButtonText: "OK",
                });

                this.errors = {
                    email: "Invalid credentials",
                    password: "Invalid credentials",
                };
            } finally {
                this.isLoggingIn = false;
            }
        },
        togglePassword() {
            this.showPassword = !this.showPassword;
        },
    },
};
</script>

<style scoped>
.vh-100 {
    min-height: 100vh;
}

.bg-gradient-primary {
    background: linear-gradient(145deg, #4e73df 0%, #224abe 100%);
}

.form-control-user {
    border-radius: 10rem;
    padding: 1.5rem 1rem;
}

.btn-user {
    border-radius: 10rem;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
}

.card {
    border-radius: 1rem;
    overflow: hidden;
}

.invalid-feedback {
    margin-left: 1rem;
}

.password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    z-index: 10;
    color: #4e73df;
}

.password-toggle:hover {
    color: #224abe;
}

.input-group {
    position: relative;
}

/* Adjust the password input padding to prevent text from going under the icon */
.input-group input[type="password"],
.input-group input[type="text"] {
    padding-right: 3rem;
}
</style>
