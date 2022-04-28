import Cookie from 'js-cookie';
import axios from "axios";
export default {
    auth(to, from, next) {
        const token = Cookie.get('my_url_token');
        const data = {};
        const headers = {
            "Content-Type": "application/json",
            'Authorization': 'Bearer ' + token
        };
        axios.post("http://localhost:8000/api/auth/user-profile", data, {headers})
            .then(response => {
                // console.log(JSON.parse(JSON.stringify(response.data)).id);
                if(JSON.parse(JSON.stringify(response.data)).id != undefined){
                    if (!token) {
                        next('/login');
                    }
                    next();
                }
            })
            .catch(error => {
                console.log(error);
                next('/login');
            });
    }
}