import './bootstrap';
import '../css/app.css';
import * as bootstrap from 'bootstrap';
import "bootstrap-icons/font/bootstrap-icons.css";
const mainContent = document.getElementById('mainContent');

/*
*  todo:
*
* */



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
        dataNav:'main',
        dataClass:'nav-item nav-link'
    },
    2:{
        name:'Kapcsolat',
        dataNav:'contact',
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

const mainPage=()=>{
    if (localStorage.getItem('_token')) {
        const mainContent = document.getElementById('mainContent');
        /* bug: bejelentkezés után Failed to load resource: the server responded with a status of 401 (Unauthorized)
            ha frisited az oldalt akkor már megfelelő képpen belép.
        * */
        api('','GET','/recorders')
            .then(data=>{
                //todo: ügyvél név átadása.
                mainContent.innerHTML=`<div class="row m-3">
                <table class="table table-responsive text-center  table-striped-columns">
                <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Ügyfél név</th>
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
                    <td>${item.customerName.name}</td>
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

    }else{
        loginPage()
    }
}

const contact=()=>{
    const mainContent = document.getElementById('mainContent');
     mainContent.innerHTML=`
     <div class="row">
        <img src="https://picsum.photos/id/237/300/300" alt="developer_img" class="m-2 col-1 col-sm-4" style="height: 250px;width: 250px; border-radius: 100%" >
        <div class="col-4 col-sm-9">

                    <h1 class=" row mb-3">Bihacsy László</h1>
                    <h2 class="row mb-3">Születései idő: 1996.04.03</h2>
                    <h3 class="row mb-3">Születései hely: Hódmezővásárhely</h3>
                    <h4 class="row mb-3">email: <a href="mailto:bihacsylaszlo@gmail.com">bihacsylaszlo@gmail.com</a></h4>
        </div>
        </div>
     <div class="row-cols m-3">
        <h5>Magamról</h5>
        <span class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aspernatur aut ducimus eligendi, error excepturi facilis incidunt ipsam iure iusto laudantium maxime nostrum obcaecati optio perspiciatis praesentium quas quasi rerum sequi ut. Ad adipisci aspernatur beatae consequatur cupiditate deleniti doloremque enim eos expedita impedit maiores modi mollitia, odio odit porro, possimus provident quaerat quasi quia rem repudiandae sapiente, sed sint tempora ullam ut vel voluptas. Ab accusantium alias amet distinctio esse expedita fuga inventore ipsum iste nam necessitatibus neque odio praesentium temporibus veritatis vero voluptatem, voluptatibus? Aspernatur aut autem distinctio dolores earum fugit illum incidunt iste labore laboriosam maiores necessitatibus nobis non nostrum omnis quidem, recusandae repellat sint suscipit voluptate. Ab aliquam aliquid, amet atque blanditiis cum cumque dicta dolor dolore dolorem eligendi, eos esse exercitationem facere iure molestiae necessitatibus neque nihil nulla numquam odio quae, quaerat qui quibusdam saepe similique tempore totam velit voluptas voluptates! Assumenda illum nisi numquam provident tenetur totam voluptate! Accusamus ad alias aliquam, aut autem, cum dolore dolorem error esse est facilis hic labore, officiis optio porro quisquam reprehenderit! Eaque error magnam, nostrum perspiciatis quo temporibus tenetur unde. Dicta esse est facere iste mollitia repellendus ut. Amet animi architecto autem beatae consequatur, cupiditate doloremque doloribus enim esse ex excepturi facilis harum inventore iure labore laboriosam laborum libero, magnam nam nesciunt nihil officiis quaerat quia quis repellat sed similique unde vel veniam voluptate. A alias aliquid animi beatae consequatur, delectus eligendi eos eum explicabo, fugit iusto similique totam voluptate? Dignissimos est explicabo ipsa quibusdam rerum sit.</span>
    </div>
     `;
}
const loginPage=()=>{

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

const recorderOpen=(recorderId)=>{
    api('','GET','/recorders/'+recorderId)
        .then(response=>{
            console.log(response)
        })
        .catch(error=>{
            console.log(error)
        })
    mainContent.innerHTML = `
            <div class="row">
                <h2 class="col m-3" >Rögzitő neve</h2>
                <h2 class="col m-3" data-openCostumer="openCostuemer">Ügyfél neve</h2>
            </div>
            <div class="row">
                         <div class="col m-3">
                        <img src="https://picsum.photos/250/250?random=1" alt="developer_img" class="" style="height: 250px;width: 250px; border-radius: 50%" >
                        </div>
                <div class="col">
                        <ul>
                        <li>Rőgzitő név:</li>
                        <li>Rőgzitő sorozatszám:</li>
                        <li>Local ip:</li>
                        <li>:</li>
                        </ul>
                </div>

            </div>
            .

    `
}

if (token===null){

    loginPage()
}else{
   genNav();
   // mainPage();
    recorderOpen(3)
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

const navFild=document.querySelector('nav')
navFild.addEventListener('click',(e)=>{
    console.log(e.target.dataset.nav)
    // todo: megoldás
    if (e.target.dataset.nav!==true){
        if (e.target.dataset.nav === 'logOut') logOut();
        if (e.target.dataset.nav === "main") mainPage();
        if (e.target.dataset.nav ==='contact') contact();
    }
})
mainContent.addEventListener('click',(e)=>{
    console.log(e.target)
    if (e.target.dataset.open !==true){
        console.log(e.target.dataset)
        recorderOpen(e.target.dataset.open)
    }
    if (e.target.dataset.delet !==true){
        console.log(e.target.dataset)
    }
})
