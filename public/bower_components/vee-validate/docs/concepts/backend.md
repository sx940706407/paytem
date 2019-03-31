# Backend Validation

You might need to also use your Laravel/Express or whatever back-end as your validation provider for numerous reasons, like checking if an email is unique since it is hard to implement on the client-side, we can achieve this using a custom rule and the `reasoning` feature:

```js
import axios from 'axios'; // great ajax library.
import { Validator } from 'vee-validate';

const isUnique = (value) => {
  return axios.post('/api/validate/email', { email: value }).then((response) => {
    // Notice that we return an object containing both a valid property and a data property.
    return {
      valid: response.data.valid,
      data: {
        message: response.data.message
      }
    };
  });
};

// The messages getter may also accept a third parameter that includes the data we returned earlier.
Validator.extend('unique', {
  validate: isUnique,
  getMessage: (field, params, data) => {
    return data.message;
  }
});
```

The following demo shows how it would work in action, note that it will only trigger if the user entered a valid email since the validator early exits upon first failure.

* [Async Backend Validation Example](https://baianat.github.io/vee-validate/examples/async-backend-validation.html)

Since there is no real DB in this example, it's being simulated by a dynamic array.
