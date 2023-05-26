import './bootstrap';
import '../css/app.css';
import customAlert from './alert.js';
import api from './api.js';
// const api=require('./api.js')
const mainContent = document.getElementById('mainContent');

const token= localStorage.getItem('_token');
let logOut=()=>{
    const reqData=""
    api(reqData,'POST','/logout')
        .then(data=>{
            if (data.alert){
                customAlert(data.alert.message, data.alert.type)
            }
            localStorage.removeItem('_token')
            localStorage.removeItem('user')
            const navBar = document.getElementById('nav-bar');
            //nav linkek vissza állitása a html kodban meghatározott ra.
            for (let i=navBar.children[0].children.length-1; i>1; i--){
                navBar.children[0].children[i].remove()
            }
            loginPage();
        })
        .catch(err=>{
            console.log(err)
        })
}
const mainPage=()=>{
    if (localStorage.getItem('_token')) {
        const navBar = document.getElementById('nav-bar')
        for (let i=0;2>i;i++){
            const navitem= document.createElement('li');
            if (i===0){
                navitem.dataset.nav='customers'
                navitem.innerText='Ügyfelek'
            } if (i===1){
                navitem.dataset.nav='admin'
                navitem.innerText='Admin'
            }

            navBar.children[0].append(navitem)
        }
        //log out gomb elkészitése
        const logOutLi=document.createElement('li')
        logOutLi.classList.add('logout-nav-item')
        logOutLi.dataset.nav='logOut';
        logOutLi.innerText='Kijelentkezés'



        navBar.children[0].append(logOutLi)
        console.log(navBar)
        navBar.addEventListener('click', (e) => {
            console.log(e.target.dataset.nav)
            if (e.target.dataset.nav === 'logOut') {
                logOut()
            }
            if (e.target.dataset.nav === "main") mainPage();
            if (e.target.dataset.nav ==='contact') contact();

        })
        const mainContent = document.getElementById('mainContent');
        mainContent.innerHTML = `H2`
    }else{
        loginPage()
    }
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


