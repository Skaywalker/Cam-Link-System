
const apiUrl='http://localhost:8000/api';
const myHeaders= new Headers();
myHeaders.append("Accept", "application/vnd.api+json");
myHeaders.append("Content-Type", "application/vnd.api+json");
/**
 * Api hivás
 *  reqData= Kérés adatok Json formátumba.
 *  method= Kérés metudusa
 *  route= Kérés utvonala pl: /login
 * */
function api(reqData, method,rout) {
    const formData = new FormData();
    reqData = JSON.parse(reqData)
    for (let key in reqData) {
        formData.append(key, reqData[key]);
    }
    const requestOptions = {
        method: method,
        headers: myHeaders,
        body: formData,
        redirect: 'follow'
    };
    fetch(apiUrl, rout)
        .then(response => response.json())
        .then(data => console.log(data))
        .catch(err => console.error('error', err));
}
export default api
