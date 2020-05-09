<template>
  <div class="form-group input-wrapper">
    <label v-if="label">
      {{label}}
    </label>
    <div class="input-group color-picker" ref="colorpicker">
      <input
        class="form-control border-input"
        v-bind="$attrs"
        :value="colorValue"
        @focus="showPicker()"
        @input="updateFromInput($event.target.value)"
        v-on:input="model=$event.target.value"
      />
      <span class="input-group-addon color-picker-container">
      <span class="current-color" :style="'background-color: ' + colorValue" @click="togglePicker()"></span>
        <chrome-picker :value="colors" @input="updateFromPicker" v-if="displayPicker" />
      </span>
    </div>
    <div v-for="(error, index) in errors" :key="index" :value="error" class="text-danger error">
      {{ error }}
    </div>
  </div>
</template>
<script>
  import {Chrome} from 'vue-color'

  export default {
    components: {
      'chrome-picker': Chrome,
    },
    inheritAttrs: false,
    props: {
      value: [String, Number],
      label: String,
      errors: Array,
    },
    data() {
      return {
        colors: {
          hex: this.value ? this.value : '#000000',
        },
        displayPicker: false,
        colorValue: this.value ? this.value : '#000000',
      }
    },
    mounted() {
      this.setColor(this.value ? this.value : '#000000');
    },
    methods: {
      setColor(color) {
        this.updateColors(color);
      },
      updateColors(color) {
        if(color.slice(0, 1) == '#') {
          this.colors = {
            hex: color
          };
        }
        else if(color.slice(0, 4) == 'rgba') {
          var rgba = color.replace(/^rgba?\(|\s+|\)$/g,'').split(','),
            hex = '#' + ((1 << 24) + (parseInt(rgba[0]) << 16) + (parseInt(rgba[1]) << 8) + parseInt(rgba[2])).toString(16).slice(1);
          this.colors = {
            hex: hex,
            a: rgba[3],
          }
        }
      },
      showPicker() {
        document.addEventListener('click', this.documentClick);
        this.displayPicker = true;
      },
      hidePicker() {
        document.removeEventListener('click', this.documentClick);
        this.displayPicker = false;
      },
      togglePicker() {
        this.displayPicker ? this.hidePicker() : this.showPicker();
      },
      updateFromInput(value) {
        this.updateColors(value);
        this.$emit('input', value);
      },
      updateFromPicker(color) {
        this.colors = color;
        if(color.rgba.a == 1) {
          this.colorValue = color.hex;
        }
        else {
          this.colorValue = 'rgba(' + color.rgba.r + ', ' + color.rgba.g + ', ' + color.rgba.b + ', ' + color.rgba.a + ')';
        }
        this.$emit('input', this.colorValue);
      },
      documentClick(e) {
        var el = this.$refs.colorpicker,
          target = e.target;
        if(el !== target && !el.contains(target)) {
          this.hidePicker()
        }
      }
    },
    // watch: {
    //   value(val) {
    //     if(val) {
    //       this.updateColors(val);
    //       this.$emit('input', val);
    //     }
    //   }
    // },
}
</script>
<style lang="scss" scoped>
  .input-wrapper {
    padding:0;
  }

  .error {
    padding-top: 5px;
  }

  .vc-chrome {
    position: absolute;
    top: 35px;
    right: 0;
    z-index: 9;
  }

  .current-color {
    display: inline-block;
    width: 16px;
    height: 16px;
    background-color: #000;
    cursor: pointer;
  }

  .border-input {
    border-right: 1px solid #CCC5B9 !important;
    border-top-right-radius: 4px !important;
    border-bottom-right-radius: 4px !important;
  }
</style>
