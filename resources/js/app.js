import './bootstrap';
import '../css/app.css';
import customAlert from './alert.js';
import api from './api.js';
// const api=require('./api.js')
const mainContent = document.getElementById('mainContent');

const token= localStorage.getItem('_token');
let logOut=(e)=>{
}
export default logOut
const mainPage=()=>{

    const navBar = document.getElementById('nav-bar')
        console.log(navBar.children[0])
    navBar.addEventListener('click',(e)=>{
        console.log(e.target.dataset.nav)
        if (e.target.dataset.nav==='logOut') {
            const reqData=""
            api(reqData,'POST','/logout')
                .then(data=>{
                    if (data.alert){
                        customAlert(data.alert.message, data.alert.type)
                    }
                    localStorage.removeItem('_token')
                    localStorage.removeItem('user')
                    loginPage()
                })
                .catch(err=>{
                    console.log(err)
                })

        }

    })
    const mainContent = document.getElementById('mainContent');
    mainContent.innerHTML=`H2`
}
const loginPage=()=>{
    const mainContent = document.getElementById('mainContent');

    mainContent.innerHTML =`
        <div id="login">
            <form class="card" id="loginForm">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email">
                <label for="password" class="form-label">Jelszó:</label>
                <input type="password" class="form-control" id="password">
                <button type="submit" class="btn btn-primary">Bejelntkezés</button>
            </form>
        </div>
    `
}
if (token===null){
    console.log('token')
    loginPage()
}else{
    mainPage();
}
//login form alat elérhető elemek
if (document.getElementById('loginForm')){
    const loginForm = document.getElementById('loginForm')
    loginForm.addEventListener('submit',(e)=>{
        e.preventDefault();
         const reqData={
             email: loginForm.email.value,
             password: loginForm.password.value
        }
        api(reqData,'POST','/login')
            .then(data=>{
                if (data.alert){

                    customAlert(data.alert.message, data.alert.type)
                }
                if (data.token&&data.user){
                    localStorage.setItem('_token',data.token)
                    console.log(data.user)
                    const user = JSON.stringify(data.user)
                    localStorage.setItem('user',user)
                    mainPage();
                }
            })
            .catch(error=>{
                console.log('error',error)
            })
    })
}


