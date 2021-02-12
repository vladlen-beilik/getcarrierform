<template>
  <div class="page-form__form-box">

    <multiselect
        id="ajax"
        v-model="from.value"
        :options="from.options"
        :searchable="true"
        :close-on-select="true"
        :multiple="false"
        :limit="5"
        :loading="from.isLoading"
        :show-labels="false"
        :allow-empty="false"
        :internal-search="false"
        track-by="zip"
        placeholder="Delivery From Zip or City"
        @search-change="fetchOptions('from', $event)"
        @select="selected('from', $event)"
    >
      <span slot="noOptions">Start typing to search.</span>
      <span slot="noResult">Nothing found.</span>
      <template slot="singleLabel" slot-scope="props">
        <span class="option__desc">{{ `${props.option.city}, ${props.option.state_id} ${props.option.zip}` }}</span>
      </template>
      <template slot="option" slot-scope="props">
        <span class="option__desc">{{ `${props.option.city}, ${props.option.state_id} ${props.option.zip}` }}</span>
      </template>
    </multiselect>

    <multiselect
        id="ajax"
        v-model="to.value"
        :options="to.options"
        :searchable="true"
        :close-on-select="true"
        :multiple="false"
        :limit="5"
        :loading="to.isLoading"
        :show-labels="false"
        :allow-empty="false"
        :internal-search="false"
        track-by="zip"
        placeholder="Delivery To Zip or City"
        @search-change="fetchOptions('to', $event)"
        @select="selected('to', $event)"
    >
      <span slot="noOptions">Start typing to search.</span>
      <span slot="noResult">Nothing found.</span>
      <template slot="singleLabel" slot-scope="props">
        <span class="option__desc">{{ `${props.option.city}, ${props.option.state_id} ${props.option.zip}` }}</span>
      </template>
      <template slot="option" slot-scope="props">
        <span class="option__desc">{{ `${props.option.city}, ${props.option.state_id} ${props.option.zip}` }}</span>
      </template>
    </multiselect>

    <button @click="onSubmit" class="page-form__btn page-form__btn-1 btn-home">Get My Quotes Now!</button>
  </div>
</template>

<script>
import axios from 'axios'
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css'
import VueNotifications from "vue-notifications";

export default {
  name: 'index-form',
  components: {
    Multiselect
  },
  data() {
    return {
      name: '',
      from: {
        options: [],
        value: null,
        isLoading: false
      },
      to: {
        options: [],
        value: null,
        isLoading: false
      }
    }
  },

  computed: {
    customLabel ({ city, state_id, zip }) {
      if(city && state_id && zip) {
        return `${city}, ${state_id} ${zip}`
      }
      return null
    },
    toValue: function () {
      return this.to.value
    }
  },

  methods: {
    onSubmit(e) {
      e.preventDefault()
      let newFrom = this.from.value
      let newTo = this.to.value
      if(this.from.value) {
        newFrom = (({ zip, city, state_id }) => ({ zip, city, state_id }))(this.from.value)
      }
      if(this.to.value) {
        newTo = (({ zip, city, state_id }) => ({ zip, city, state_id }))(this.to.value)
      }

      axios.post(location.origin + '/request', {form: 1, data: {from: newFrom, to: newTo}}).then(response => {
        window.location.replace(response.data.redirect)
      }).catch(error => {
        if (typeof error.response !== 'undefined' && error.response.status === 422) {
          let data = error.response.data.errors
          this.showNotify({title: 'Error', message: data[Object.keys(data)[0]], type: 'error', timeout: 5000})
        }
      })
    },

    fetchOptions(type, search) {
      let self = this[type]
      if(search.length > 2) {
        self.isLoading = true
        axios.post(location.origin + '/search-zip', {search: search}).then(function (response) {
          self.options = response.data
          self.isLoading = false
        })
      }
    },

    selected(type, value) {
      this[type].value = value
    },
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
  .multiselect {
    flex: 0 0 calc(35.5% - 17px);
    margin-right: 17px;
  }
  button {
    flex: 0 0 29%;
    width: auto;
    @media (max-width: 740px) {
      width: 100%;
    }
  }
}
</style>