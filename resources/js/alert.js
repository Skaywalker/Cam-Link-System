
 function customAlert(message,type){
    const alertFilde=document.getElementById('alert');
    switch(type){
        case 'success':
            alertFilde.classList.add('alert-success');
            break;
        case 'warning':
            alertFilde.classList.add('alert-warning');
            break;
        case 'danger':
            alertFilde.classList.add('alert-danger');
            break;
    }
    alertFilde.classList.add('alert-active')
    alertFilde.innerHTML =`<span>${message}</span>`;

    setTimeout(()=>{

        const alertFilde=document.getElementById('alert');
        alertFilde.classList.remove('alert-active');
        alertFilde.classList.remove('alert-success')
        alertFilde.classList.remove('alert-danger')
        alertFilde.classList.remove('alert-warning')
    },5750)
}
export default customAlert
