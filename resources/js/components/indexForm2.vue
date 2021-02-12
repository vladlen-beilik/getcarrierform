<template>
  <div class="page-form__padding">
    <div class="page-form__p-w">
      <h3 class="page-form__title">{{ title }}</h3>
      <div class="page-form__rad-2">
        <div class="page-form__rad page-form__rad-flex">
          <label class="radio page-form__nav-label">
            <input :value="'Open'" type="radio" value="1" v-model="value">
            <div class="radio__text page-form__nav-chek-text">
              <div class="page-form__rad-2-text page-form__rad-2-text-fw">Open Trailer</div>
              <div class="page-form__rad-2-text">Height Availability</div>
              <div class="page-form__rad-2-text">Cost Less</div>
            </div>
          </label>
          <label class="radio page-form__nav-label">
            <input :value="'Enclosed'" type="radio" value="2" v-model="value">
            <div class="radio__text page-form__nav-chek-text">
              <div class="page-form__rad-2-text page-form__rad-2-text-fw">Enclosed Trailer</div>
              <div class="page-form__rad-2-text">Height Availability</div>
              <div class="page-form__rad-2-text">Cost Less</div>
            </div>
          </label>
        </div>
        <div class="page-form__nav-btn-padding">
          <button @click="onSubmit" class="page-form__btn page-form__nav-btn">Next</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import VueNotifications from "vue-notifications";

export default {
  name: 'index-form2',
  props: ['dataTitle'],
  data() {
    return {
      title: null,
      value: 'Open'
    }
  },

  mounted() {
    this.title = this.dataTitle
  },

  methods: {
    onSubmit: function (e) {
      e.preventDefault()
      axios.post(location.origin + '/request', {form: 3, data: {trailer_type: this.value}}).then(response => {
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

<style lang="scss" scoped>
::v-deep {
  .radio__text {
    user-select: none;
  }
}

</style>