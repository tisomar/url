<template>
  <v-simple-table>
    <template>
      <tbody>
      <tr>
        <td>
          <div v-html="http_response"></div>
        </td>
      </tr>
      </tbody>
    </template>
  </v-simple-table>
</template>

<script>
import axios from 'axios'
import Cookie from "js-cookie";

export default {
  name: 'ShowView',
  props: { id: String },
  data() {
    return {
      http_response: '',
    }
  },
  mounted() {

    const token = Cookie.get('my_url_token');
    const data = {id: this.$route.params.id};
    const headers = {
      "Content-Type": "application/json",
      'Authorization': 'Bearer ' + token
    };
    axios.post("http://localhost:8000/api/url/show", data, {headers})
        .then(response => {
          // console.log(JSON.parse(JSON.stringify(response.data)));
          this.http_response = response.data
        })
        .catch(error => {
          console.log(error)
        });
  },
}
</script>

