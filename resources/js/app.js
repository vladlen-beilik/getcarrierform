import Vue from 'vue'
import VueNotifications from 'vue-notifications'
import iziToast from 'izitoast'
import 'izitoast/dist/css/iziToast.min.css'
let indexForm = document.getElementById('indexForm')
let indexForm1 = document.getElementById('indexForm1')
let indexForm2 = document.getElementById('indexForm2')
let indexForm3 = document.getElementById('indexForm3')
let indexForm4 = document.getElementById('indexForm4')

document.querySelector('#burger').onclick = function() {
    this.classList.toggle('active')
    document.querySelector('#load').classList.toggle('active')
    document.querySelector('#mobileImg').classList.toggle('active')
}

function toast({title, message, type, timeout, cb}) {
    if (type === VueNotifications.types.warn) type = 'warning'
    return iziToast[type]({title, message, timeout, position: 'topRight', close: false, theme: 'light'})
}

Vue.use(VueNotifications, {
    success: toast,
    error: toast,
    info: toast,
    warn: toast
})

Vue.filter('ucFirst', function (value) {
    return value[0].toUpperCase() + value.substr(1)
})

if(indexForm) {
    Vue.component('indexForm', require('./components/indexForm').default)
    new Vue({el: '#indexForm'})
}
if(indexForm1) {
    Vue.component('indexForm1', require('./components/indexForm1').default)
    new Vue({el: '#indexForm1'})
}
if(indexForm2) {
    Vue.component('indexForm2', require('./components/indexForm2').default)
    new Vue({el: '#indexForm2'})
}
if(indexForm3) {
    Vue.component('indexForm3', require('./components/indexForm3').default)
    new Vue({el: '#indexForm3'})
}
if(indexForm4) {
    Vue.component('indexForm4', require('./components/indexForm4').default)
    new Vue({el: '#indexForm4'})
}
