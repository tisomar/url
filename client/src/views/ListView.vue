<template>
  <v-simple-table>
    <template v-slot:default>
      <thead>
      <tr>
        <th class="text-left">
          URL
        </th>
        <th class="text-left">
          Status Code
        </th>
        <th class="text-left">
          Http Response
        </th>
      </tr>
      </thead>
      <tbody>
      <tr
          v-for="item in records"
          :key="item.id"
      >
        <td>{{ item.url }}</td>
        <td>{{ item.status_code }}</td>
        <td>
          <router-link
              :to="{ name: 'show', params: { id: item.http_response } }"
          >
            <v-btn color="primary" small class="mt-2">Http Response</v-btn>
          </router-link>
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
  name: 'ListView',
  data() {
    return {
      records: [],
    }
  },
  created() {
    const token = Cookie.get('my_url_token');
    const data = {};
    const headers = {
      "Content-Type": "application/json",
      'Authorization': 'Bearer ' + token
    };
    axios.get("http://localhost:8000/api/url/list", data, {headers})
        .then(response => {
          // console.log(JSON.parse(JSON.stringify(response.data)));
          this.records = response.data
        })
        .catch(error => {
          console.log(error)
        });
  },
}
</script>

