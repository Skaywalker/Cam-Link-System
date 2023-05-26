import './bootstrap';
import '../css/app.css';
import api from './api.js';
// const api=require('./api.js')
const mainContent = document.getElementById('mainContent');
const alert=document.getElementById('alert');
const token= localStorage.getItem('_token');
if (token===null){
    console.log('token')
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
if (document.getElementById('loginForm')){
    const loginForm = document.getElementById('loginForm')
    loginForm.addEventListener('submit',(e)=>{
        e.preventDefault();
        console.log(loginForm)
         const reqData={
             email: loginForm.email.value,
             password: loginForm.password.value
        }
        console.log('reqData',reqData)
        api(reqData,'POST','/login')
            .then(data=>{
                console.log('data',data)
            })
            .catch(error=>{
                console.log('error',error)
            })
    })
}

