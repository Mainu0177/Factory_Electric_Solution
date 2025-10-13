<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
                <div class="card w-90  p-4">
                    <form submit.prevent="submit">
                        <div class="card-body">
                            <h4>SIGN IN</h4>
                            <br/>
                            <input id="email" placeholder="User Email" class="form-control" type="email"/>
                            <br/>
                            <input id="password" placeholder="User Password" class="form-control" type="password"/>
                            <br/>
                            <button type="submit" class="btn w-100 btn-secondary">Login</button>
                            <hr/>
                            <div class="float-end mt-3">
                            <span>
                                <a class="text-center ms-3 h6" href="registrationForm.html">Sign Up </a>
                                <span class="ms-1">|</span>
                                <a class="text-center ms-3 h6" href="sendOTPForm.html">Forget Password</a>
                            </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, useForm, usePage, router } from '@inertiajs/vue3';
import { createToaster } from "@meforma/vue-toaster";

const toaster = createToaster({
    position: "top-right",
});

const form = useForm({
    email: '',
    password: '',
})

const page = usePage();
function submit(){
    if (form.email) {

    }
}


</script>

<style scoped>

</style>
