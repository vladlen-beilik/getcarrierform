<template>
  <div class="page-form__padding cal">
    <div class="page-form__p-w"><h3 class="page-form__title">{{ title }}</h3>
      <div class="page-form__calnd">
        <datepicker v-model="date" inline/>
      </div>
      <button @click="onSubmit" class="page-form__btn page-form__nav-btn">Next</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Datepicker from 'vuejs-datepicker'
import VueNotifications from "vue-notifications";

export default {
  name: 'index-form3',
  props: ['dataTitle'],
  data() {
    return {
      title: null,
      date: null
    }
  },

  components: {
    Datepicker
  },

  mounted() {
    this.title = this.dataTitle
  },

  methods: {
    onSubmit: function (e) {
      e.preventDefault()
      axios.post(location.origin + '/request', {form: 4, data: {date: this.date}}).then(response => {
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