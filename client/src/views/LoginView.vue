<template>
  <v-container>
    <v-form
        ref="form"
        v-model="valid"
        lazy-validation
        height="50%"
    >
      <v-text-field
          v-model="email"
          :rules="emailRules"
          label="E-mail"
          required
      ></v-text-field>

      <v-text-field
          v-model="password"
          :rules="passwordlRules"
          label="Password"
          required
          type="password"
      ></v-text-field>

      <v-btn
          :disabled="!valid"
          color="success"
          class="mr-4"
          @click="validate"
      >
        Sign In
      </v-btn>

      <v-btn
          color="error"
          class="mr-4"
          @click="signUp"
      >
        Sign Up
      </v-btn>
      <v-dialog
          v-model="dialog"
          width="500"
      >
        <v-card>
          <v-card-title class="text-h5 grey lighten-2">
            Alert
          </v-card-title>

          <v-card-text>
            {{ text }}
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
                color="primary"
                text
                @click="dialog = false"
            >
              OK
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-form>
  </v-container>
</template>

<script>
import Cookie from 'js-cookie';

export default {
  name: 'LoginView',

  data: () => ({
    valid: true,
    name: '',
    nameRules: [
      v => !!v || 'Name is required',
      v => (v && v.length <= 500) || 'Name must be less than 10 characters',
    ],
    email: '',
    emailRules: [
      v => !!v || 'Password is required',
      v => /.+@.+\..+/.test(v) || 'Password must be filled',
    ],
    passwordlRules: [
      v => !!v || 'Password is required',
      v => (v.length > 1) || 'Password must be filled',
    ],
    password: '',
    text: '',
    dialog: false,
  }),
  methods: {
    validate() {
      if (this.$refs.form.validate()) {
        this.submit();
      }
    },
    submit() {

      const payload = {
        email: this.email,
        password: this.password
      };

      fetch(`http://localhost:8000/api/auth/login`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
      }).then(response => response.json())
          .then(res => {
            if (res.access_token !== undefined) {
              Cookie.set('my_url_token', res.access_token);
              this.$router.push('/create');

            } else {
              this.dialog = true;
              this.text = 'Please, put a valid login';
            }
          })
    },
    signUp() {
      this.$router.push('/register');
    },
  },
  props: {
    msg: String
  }
}
</script>
