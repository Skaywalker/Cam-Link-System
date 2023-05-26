
const apiUrl='http://127.0.0.1:8000/api';
const myHeaders= new Headers();
myHeaders.append("Accept", "application/json");
myHeaders.append("Content-Type", "application/json");
myHeaders.append('X-CSRF-TOKEN',  document.head.querySelector('meta[name="csft_token"]').content);
// myHeaders.append('XSRF-TOKEN', getCookieValue(csrftoken))
/**
 * Api hivás
 *  reqData= Kérés adatok Json formátumba.
 *  method= Kérés metudusa
 *  route= Kérés utvonala pl: /login
 * */
async function api(reqData, method, route) {
    const requestOptions = {
        method: method,
        headers: myHeaders,
        body: JSON.stringify(reqData),
        redirect: 'follow'
    };
    return new Promise((resolve, reject) => {
        fetch(apiUrl+route,requestOptions)
            .then(response => {

                    return response.json();

            })
            .then(data=> {
                resolve(data)
            })
            .catch(error=>{
                reject(error);
            })
    })
}
export default api
