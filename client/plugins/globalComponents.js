import Vue from 'vue'
import fgInput from '~/components/UIComponents/Inputs/formGroupInput.vue'
import fgMultiSelect from '~/components/UIComponents/Inputs/formGroupMultiSelect.vue'
import fgSelect from '~/components/UIComponents/Inputs/formGroupSelect.vue'
import colorPickerInput from '~/components/UIComponents/Inputs/colorPickerInput.vue'
import DropDown from '~/components/UIComponents/Dropdown.vue'

/**
 * You can register global components here and use them as a plugin in your main Vue instance
 */
Vue.component('fg-input', fgInput)
Vue.component('fg-multi-select', fgMultiSelect)
Vue.component('fg-select', fgSelect)
Vue.component('color-picker-input', colorPickerInput)
Vue.component('drop-down', DropDown)
