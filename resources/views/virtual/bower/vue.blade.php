<script src="http://cdn.staticfile.org/vue/2.5.17/vue.min.js"></script>
{{-- <script src="{{asset('bower_components/vue/dist/vue.min.js')}}"></script> --}}
<script src="{{asset('vendor/vee-validate.2.0.5.js')}}"></script>
<script src="{{asset('bower_components/axios/dist/axios.min.js')}}"></script>
<script src="{{asset('bower_components/layer/dist//layer.js')}}"></script>

<script>
const config = {
  errorBagName: 'errors', // change if property conflicts
  fieldsBagName: 'fields',
  delay: 0,
  locale: 'en',
  dictionary: null,
  strict: true,
  classes: false,
  classNames: {
    touched: 'touched', // the control has been blurred
    untouched: 'untouched', // the control hasn't been blurred
    valid: 'valid', // model is valid
    invalid: 'invalid', // model is invalid
    pristine: 'pristine', // control has not been interacted with
    dirty: 'dirty' // control has been interacted with
  },
  events: 'input|blur',
  inject: true,
  validity: false,
  aria: true,
  i18n: null, // the vue-i18n plugin instance
  i18nRootKey: 'validations' // the nested key under which the validation messsages will be located
};


Vue.use(VeeValidate, config, axios);

</script>