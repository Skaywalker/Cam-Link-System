import './bootstrap';
import '../css/app.css';
import * as bootstrap from 'bootstrap';
import "bootstrap-icons/font/bootstrap-icons.css";
/*
*  todo:
*
* */

async function  logOutd(e){
    console.log('MÁMÁDAT')
}

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
        Object.values(pages).map(page=>{
            const item=document.createElement('li')
            item.innerText=page.name
            item.dataset.nav=page.dataNav
            item.classList=page.dataClass;
            navArea.append(item);
        })

}

const mainPage=()=>{
    if (localStorage.getItem('_token')) {
        const mainContent = document.getElementById('mainContent');
        /* bug: bejelentkezés után Failed to load resource: the server responded with a status of 401 (Unauthorized)
            ha frisited az oldalt akkor már megfelelő képpen belép.
        * */
        api('','GET','/recorders')
            .then(data=>{
                //todo: search
                mainContent.innerHTML=`<div class="row m-3">
                <table class="table table-responsive text-center  table-striped-columns">
                <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Név</th>
                <th scope="col">Sorozat szám</th>
                <th scope="col">Local IP</th>
                <th scope="col">Művelet</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
                </table>
                </div>`
                console.log(data.data)
              data.data.map((item)=> {
                    const tbody = document.querySelector('tbody')
                    const trElement = document.createElement('tr');
                    trElement.classList.add('align-middle')
                    trElement.innerHTML = `
                    <td>${item.id}</td>
                    <td>${item.name}</td>
                    <td>${item.serialNumber}</td>
                    <td><a href="https://${item.localIp}" target="_blank">${item.localIp}</a></td>
                    <td class="">
                    <div class="btn-group">
                    <button class="btn btn-primary bi bi-clipboard"   data-open="${item.id}"></button>
                    <button class="btn btn-danger bi bi-trash"   data-delete="${item.id}"></button>
                    </div>
                    </td>
                    `
                    tbody.append(trElement)
                })
            })//oldal adatok megjelenitése
            .catch(err=>{
                console.log(err)
            })
        const navFild=document.querySelector('nav')
        navFild.addEventListener('click',(e)=>{
            // todo: megoldás
                if (e.target.dataset.nav!==true){
                if (e.target.dataset.nav === 'logOut') {
                    logOut()
                }
                if (e.target.dataset.nav === "main") mainPage();
                if (e.target.dataset.nav ==='contact') contact();
            }
        })
        mainContent.addEventListener('click',(e)=>{
            console.log()
            if (e.target.dataset.open !==true){
                console.log(e.target.dataset)
            }
        })
    }else{
        loginPage()
    }
}

const loginPage=()=>{
    const mainContent = document.getElementById('mainContent');

    mainContent.innerHTML =`
        <div id="login" class="col-12 col-md-8" >
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

    loginPage()
}else{
   genNav();
    mainPage();
}
// asszinkron nem látja a fucsont

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
                    const user = JSON.stringify(data.user)
                    localStorage.setItem('user',user)
                    genNav();
                    setTimeout( ()=>{mainPage()}, 1500)

                }
            })
            .catch(error=>{
                console.log('error',error)
            })
    })
}
function genNav(){
    const navBar = document.getElementById('nav-bar')
    const navSideMenu = document.getElementById('nav-side-menu')
    genNavelEment(navBar);
    genNavelEment(navSideMenu);
    //Kijelentkezés gomb létrehozzása
    const logOutLi=document.createElement('li')
    logOutLi.classList.add('nav-item')
    logOutLi.classList.add('nav-link')
    logOutLi.dataset.nav='logOut';
    logOutLi.innerText='Kijelentkezés'
    navSideMenu.append(logOutLi)
}

