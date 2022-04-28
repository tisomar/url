<template>

  <v-container>
    <v-form
        ref="form"
        v-model="valid"
        lazy-validation
        height="50%"
    >
      <v-text-field
          v-model="url"
          label="Type a URL"
          required
          :rules="urlRules"
      ></v-text-field>

      <v-btn
          :disabled="!valid"
          color="success"
          class="mr-4"
          @click="submit"
      >
        Send URL
      </v-btn>

      <v-btn
          color="error"
          class="mr-4"
          @click="forceRerender"
      >
        Refresh List
      </v-btn>
      <v-divider></v-divider>
      <show-view :key="componentKey"></show-view>
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
import ShowView from "@/views/ListView";
import axios from 'axios'
export default {
  name: 'CreateView',
  components: {ShowView},
  data: () => ({
    url: '',
    componentKey: 0,
    valid: true,
    name: '',
    urlRules: [
      v => !!v || 'URL is required',
    ],
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
      const token = Cookie.get('my_url_token');
      const data = { url: this.url };
      const headers = {
        "Content-Type": "application/json",
        'Authorization': 'Bearer '+token
      };
      axios.post("http://localhost:8000/api/url/create", data, { headers })
          .then(response => {

            if(response.data.success == undefined) {
              this.text = response.data.error;
            }else{
              this.text = response.data.success;
              this.forceRerender();
            }

            this.dialog = true;
          })
          .catch(error => {
            this.text = error
            this.dialog = true;
          });
    },
    forceRerender() {
      this.componentKey += 1
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.form-signin {
  width: 100%;
  max-width: 800px;
  padding: 15px;
  margin: auto;
}

.form-signin .checkbox {
  font-weight: 400;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>
