<template>
  <div class="page-form__padding">
    <div class="page-form__p-w">
      <h3 class="page-form__title">{{ title }}</h3>
      <div class="page-form__input-wrapper">
        <input type="text" v-model="data.name" placeholder="Name" class="page-form__input page-form__input-4">
        <input type="text" v-model="data.email" placeholder="Email" class="page-form__input page-form__input-4">
        <input type="text" v-model="data.phone" placeholder="Phone" class="page-form__input page-form__input-4">
        <button @click="onSubmit" class="page-form__btn page-form__nav-btn">Next</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import VueNotifications from "vue-notifications";

export default {
  name: 'index-form4',
  props: ['dataTitle'],
  data() {
    return {
      title: null,
      data: {
        name: null,
        email: null,
        phone: null
      }
    }
  },

  mounted() {
    this.title = this.dataTitle
  },

  methods: {
    onSubmit: function (e) {
      e.preventDefault()
      axios.post(location.origin + '/request', {form: 5, data: this.data}).then(response => {
        window.location.replace(response.data.redirect)
      }).catch(error => {
        if (typeof error.response !== 'undefined' && error.response.status === 422) {
          let data = error.response.data.errors
          this.showNotify({title: 'Error', message: data[Object.keys(data)[0]], type: 'error', timeout: 5000})
        }
      })
    }
  },

  notifications: {
    showNotify: {
      type: VueNotifications.types.error
    }
  }
}
</script>