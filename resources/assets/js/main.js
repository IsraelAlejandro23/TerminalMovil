import Vue from 'vue'
import PaymentForm from './components/PaymentForm.vue'
import PayOrder from './components/PayOrder.vue'
// import VueRouter from 'vue-router'

// Vue.use(VueRouter);


// const routes = [
//   { path    : '/terminal/pay-order', name:'pay-order', component: PayOrder },
//   { path    : '/terminal/payment-form', name:'payment-form', component: PaymentForm}
// ]


// const router = new VueRouter({
//   mode: "history",
//   routes // short for routes: routes
// })


const app = new Vue({
    // router,
    components: {
      'payment-form': PaymentForm,
      'pay-order' : PayOrder
    },
    data: {
      test: false
    }
}).$mount('#content')
