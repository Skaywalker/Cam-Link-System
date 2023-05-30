import './bootstrap';
import '../css/app.css';
import * as bootstrap from 'bootstrap';
// console.log(bootstrap)
window.bootstrap = bootstrap;
let pages={
    0:{
        name:'Ügyfelek',
        dataNav:'customer',
        dataClass:'nav-item nav-link'
    },
    1:{
        // main
        name:'Rögzitők',
        dataNav:'recorders',
        dataClass:'nav-item nav-link'
    },
    2:{
        name:'Admin',
        dataNav:'admin',
        dataClass:'nav-item nav-link'
    },
}
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
            const navSideBar = document.getElementById('nav-side-menu');
            const navBar=document.getElementById('nav-bar')
            // Menűpontok tőrlése!
            Object.values(navBar.children).map(child=>{
                child.remove()
            })
            Object.values(navSideBar.children).map(child=>{
                child.remove()
            })
            loginPage();
        })
        .catch(err=>{
            console.log(err)
        })
}
/**
   navArea= Ahova be szeretnéd arkni a nav elemeket.
 */
let genNavelEment=(navArea)=>{
    console.log(pages)
        Object.values(pages).map(page=>{
            const item=document.createElement('li')
            console.log(page.name,'|',page.dataNav,'|', page.dataClass)
            item.innerText=page.name
            item.dataset.nav=page.dataNav
            item.classList=page.dataClass;
            navArea.append(item);
        })
}
const mainPage=()=>{
    if (localStorage.getItem('_token')) {
        const navBar = document.getElementById('nav-bar')
        const navSideMenu = document.getElementById('nav-side-menu')
        const navFild=document.querySelector('nav')
        console.log(pages)
        genNavelEment(navBar);
        genNavelEment(navSideMenu);
        //Kijelentkezés gomb létrehozzása
        const logOutLi=document.createElement('li')
        logOutLi.classList.add('nav-item')
        logOutLi.classList.add('nav-link')
        logOutLi.dataset.nav='logOut';
        logOutLi.innerText='Kijelentkezés'
        navSideMenu.append(logOutLi)
        console.log(navBar)
        navFild.addEventListener('click',(e)=>{
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
        <div id="login" class="col-8" >
            <form class="card" id="loginForm" style="margin: auto; max-width: 600px;">
            <div class="card-header text-center"><h2>Bejeletketés</h2></div>
            <div class="card-body">
            <div class="mb-3">
                 <label for="email" >Email:</label>
                <input type="email" class="form-control" id="email">
            </div>
             <div class="mb-3">
                <label for="password" class="form-label">Jelszó:</label>
                <input type="password" class="form-control" id="password">
              </div>
              <div class="d-flex flex-row-reverse">
                <button type="submit" class="btn btn-primary">Bejelntkezés</button>
              </div>
            </div>
            <div class="card-footer">
            <a class="nav-link" data-nav="passwordReset"> Eljeleftet jelszó!</a>
            </div>
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
    //todo Password keírás utáán entterrel lehesen submitolni.

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


