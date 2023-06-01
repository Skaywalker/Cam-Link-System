
const apiUrl='http://127.0.0.1:8000/api';
const mainContent=document.getElementById('mainContent')
const myHeaders= new Headers();
if (localStorage.getItem('_token')){

    myHeaders.append('Authorization', 'Bearer '+ localStorage.getItem('_token'));
}
myHeaders.append('X-CSRF-TOKEN',  document.head.querySelector('meta[name="csrf_token"]').content);
myHeaders.append("Accept", "application/json");
myHeaders.append("Content-Type", "application/json");
/**
 * Api hivás
 *  reqData= Kérés adatok Json formátumba.
 *  method= Kérés metudusa
 *  route= Kérés utvonala pl: /login
 * */
async function api(reqData, method, route) {
    mainContent.innerHTML=`
    <div class="spinner-border text-primary  fs-1" role="status" style="position: fixed; top: 45%; left: 50%; width: 150px; height: 150px;">
  <span class="visually-hidden">Loading...</span>
</div>
    `
    console.log(reqData,method,route);
    let requestOptions = {
        method: method,
        redirect: 'follow'
    };

    if (method!=='GET'){
        (reqData==='')? reqData='': reqData=JSON.stringify(reqData);
        requestOptions.body=reqData;
    }
    requestOptions.headers=myHeaders;
    console.log(requestOptions)
    return new Promise((resolve, reject) => {
        fetch(apiUrl+route,requestOptions)
            .then(response => {
                    console.log('api call response',response)
                    return response.json();

            })
            .then(data=> {
                console.log('api call data:',data);
                resolve(data)
            })
            .catch(error=>{
                reject(error);
            })
    })
}
export default api
