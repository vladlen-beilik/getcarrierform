<template>
  <div class="page-form__p-w">
    <h3 class="page-form__title">{{ title }}</h3>
    <div class="page-form__form-wrapper">
      <div id="page-form__form-id" class="page-form__form-1 page-form__form">
        <div v-for="(vehicle, index) in vehicles" class="page-form__form-box">
          <div class="inputs">

            <multiselect
                v-model="vehicle.year"
                :options="year_options"
                :searchable="false"
                :close-on-select="true"
                :multiple="false"
                :show-labels="false"
                :allow-empty="false"
                placeholder="Year"
            />

            <multiselect
                id="ajax"
                v-model="vehicle.make"
                :options="vehicle.make_options"
                :searchable="true"
                :close-on-select="true"
                :multiple="false"
                :loading="vehicle.isMakeLoading"
                :show-labels="false"
                :allow-empty="false"
                :internal-search="false"
                track-by="model_id"
                placeholder="Make"
                @search-change="fetchMake(index, $event)"
                @select="selected('make', index, $event)"
            >
              <span slot="noOptions">Start typing to search.</span>
              <span slot="noResult">Nothing found.</span>
              <template slot="singleLabel" slot-scope="props">
                <span class="option__desc">{{ props.option.model_make_id | ucFirst }}</span>
              </template>
              <template slot="option" slot-scope="props">
                <span class="option__desc">{{ props.option.model_make_id | ucFirst }}</span>
              </template>
            </multiselect>

            <multiselect
                v-model="vehicle.model"
                :options="vehicle.model_options"
                :searchable="false"
                :close-on-select="true"
                :multiple="false"
                :show-labels="false"
                :allow-empty="false"
                :disabled="!vehicle.model_options.length"
                label="model_name"
                track-by="model_id"
                placeholder="Model"
            >
              <span slot="noOptions">Start typing to search.</span>
              <span slot="noResult">Nothing found.</span>
              <template slot="singleLabel" slot-scope="props">
                <span class="option__desc">{{ props.option.model_name }}</span>
              </template>
              <template slot="option" slot-scope="props">
                <span class="option__desc">{{ props.option.model_name }}</span>
              </template>
            </multiselect>
          </div>
          <div class="page-form__nav-cheks">
            <div class="page-form__nav-text">Does the vehicle run?</div>
            <div class="page-form__rad">
              <label :class="['radio', 'page-form__nav-label', vehicle.run ? 'checked' : null]">
                <input type="radio" :value="1" v-model="vehicle.run">
                <div class="radio__text page-form__nav-chek-text">Yes</div>
              </label>
              <label :class="['radio', 'page-form__nav-label', !vehicle.run ? 'checked' : null]">
                <input type="radio" :value="0" v-model="vehicle.run">
                <div class="radio__text page-form__nav-chek-text">No</div>
              </label>
            </div>
          </div>
          <button v-if="vehicles.length > 1" @click="remove(index, $event)" class="remove">remove vehicle</button>
        </div>
      </div>
    </div>
    <div class="page-form__nav">
      <button @click="addVehicle" class="add-number">Add vehicle</button>
      <div class="page-form__nav-info-text">I want to ship something else (ATV, RV, Heavy, Equipment)</div>
      <button @click="onSubmit" class="page-form__btn page-form__nav-btn">Next</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css'
import _ from 'lodash'
import VueNotifications from "vue-notifications";

export default {
  name: 'index-form1',
  props: ['dataTitle'],
  components: {
    Multiselect
  },
  data() {
    return {
      title: null,
      vehicles: [
        {year: new Date().getFullYear(), make: null, model: null, run: 1, isMakeLoading: false, make_options: [], model_options: []}
      ],
      year_options: _.range(new Date().getFullYear(), 1969)
    }
  },

  mounted() {
    this.title = this.dataTitle
  },

  methods: {
    toUcFirst(value) {
      return value[0].toUpperCase() + value.substr(1)
    },
    onSubmit(e) {
      e.preventDefault()
      let newVehicles = this.vehicles.map(el => {
        return {year: el.year, make: el.make ? this.toUcFirst(el.make.model_make_id) : null, model: el.model ? el.model.model_name : null, run: el.run ? 'Yes' : 'No'};
      })
      axios.post(location.origin + '/request', {form: 2, data: {vehicles: newVehicles}}).then(response => {
        window.location.replace(response.data.redirect)
      }).catch(error => {
        if (typeof error.response !== 'undefined' && error.response.status === 422) {
          let data = error.response.data.errors
          this.showNotify({title: 'Error', message: data[Object.keys(data)[0]], type: 'error', timeout: 5000})
        }
      })
    },
    addVehicle(e) {
      e.preventDefault()
      this.vehicles.push({year: new Date().getFullYear(), make: null, model: null, run: 1, isMakeLoading: false, make_options: [], model_options: []})
    },
    fetchMake(index, search) {
      let self = this.vehicles[index]
      if(search.length > 2) {
        self.isMakeLoading = true
        axios.post(location.origin + '/search-make', {search: search}).then(function (response) {
          self.make_options = response.data
          self.isMakeLoading = false
        })
      }
    },
    fetchModel(index, id) {
      let self = this.vehicles[index]
      axios.post(location.origin + '/search-model', {id: id}).then(function (response) {
        self.model_options = response.data
      })
    },
    selected(type, index, value) {
      if(type === 'make') {
        this.vehicles[index].make = value
        this.vehicles[index].model = null
        this.fetchModel(index, value.model_make_id)
      } else if (type === 'model') {
        this.vehicles[index].model = value
      }
    },
    remove(i, e) {
      e.preventDefault()
      this.vehicles.splice(i, 1);
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
  .page-form__form-box {
    flex-direction: column;
    position: relative;
    &:not(:last-child) {
      margin-bottom: 1.5rem;
    }
    .inputs {
      display: flex;
      @media (max-width: 1700px) {
        flex-direction: column;
      }
    }
    .page-form__nav-cheks {
      margin-top: 15px;
      .page-form__nav-text {
        font-size: 14px;
      }
      .page-form__rad {
        display: flex;
        font-size: 14px;
        margin-top: 5px;
        .page-form__nav-label {
          margin-right: 20px;
        }
        .radio__text {
          padding: 0 0 0 25px;
          user-select: none;
          &:before {
            top: -2px;
          }
          &:after {
            top: 3px;
          }
        }
      }
    }
    .remove {
      position: absolute;
      right: 0;
      top: 60px;
      border: 0;
      background: transparent;
      font-size: 13px;
      padding: 0;
      color: red;
      font-weight: 500;
      cursor: pointer;
      @media (max-width: 1700px) {
        top: 194px;
      }
      @media (max-width: 740px) {
        display: block;
        position: relative;
        top: 0;
        margin-top: 13px;
        margin-left: auto;
      }
    }
  }
  .multiselect {
    flex: 0 0 calc(33.33% - 11.3px);
    &:not(:last-child) {
      margin-right: 17px;
    }
  }
}

</style>