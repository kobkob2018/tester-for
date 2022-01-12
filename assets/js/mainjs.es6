//= require accessibility.js
//= require mycarusel.js

let windowHeight =  window.innerHeight,
    logoCurrentPos = "body";
    navScrollElements = document.querySelectorAll('.navScroll'),
    animateScrollElements = document.querySelectorAll('.animateScroll')
    galleryCarusels = {};


function initMain(){
    document.addEventListener("DOMContentLoaded",()=>{
        initMainScroll();
        prepareModalGallery();
    });
}

function initMainScroll(){
    window.addEventListener('scroll', () => {
        checkNavScrollPos();
        checkAnimateScrollPos();
    });
}

function checkNavScrollPos(){
    const sy = window.scrollY;
    if(logoCurrentPos == "body" && sy > 300){
        
        logoCurrentPos = "nav";
        navScrollElements.forEach(el=>{
            el.classList.add("scrolled");
        });
    }
    if(logoCurrentPos == "nav" && sy < 300){
        logoCurrentPos = "body";
        
        navScrollElements.forEach(el=>{
            el.classList.remove("scrolled");
        });
    }
}

function checkAnimateScrollPos(){}


function openDrawer(drawerId) {
    
    document.getElementById(drawerId + "_wrap").style.width = "300px";
    document.getElementById(drawerId + "_drawer_overlay").style.display = "block";
  }
  
  function closeDrawer(drawerId) {
    document.getElementById(drawerId + "_wrap").style.width = "0";
    document.getElementById(drawerId + "_drawer_overlay").style.display = "none";
  }


function prepareModalGallery(){
    const modals = document.querySelectorAll(".gallery-modal");
    const modals_placeholder = document.getElementById("modals_placeholder");
    
    modals.forEach(modal => {
        modals_placeholder.append(modal);
        const galleryCarusel = new Mycarusel({wrap: 'gallery-carusel',autoplay:false}); 
        if(modal.id){
            galleryCarusels[modal.id] = galleryCarusel;
        }
        galleryCarusel.init();
        const closebtn = modal.querySelector('.closebtn');
        closebtn.addEventListener('click',()=>{
            
            hideModalGallery(modal.id);
        });
    });
    const modalOpeners = document.querySelectorAll('.modal-gallery-a');
    modalOpeners.forEach(opener=>{
        opener.addEventListener('click',()=>{
            
            showModalGallery(opener.dataset.gallery_id,opener.dataset.img_index);
        });
    });
    
}

function showModalGallery(gal_id, selectedIndex = false){
    const gallerymodal = document.getElementById(gal_id);
    
    if(selectedIndex && galleryCarusels[gal_id]){
        galleryCarusels[gal_id].pickIndex(selectedIndex);
    }
    gallerymodal.classList.add('modal-on');
}
 
function hideModalGallery(gal_id){
    
    const gallerymodal = document.getElementById(gal_id);
    gallerymodal.classList.remove('modal-on');
}

function openContactModal(){
    document.querySelector(".contact-modal").classList.add("show-modal");
    document.querySelector(".contact-modal").classList.remove("hide-modal");
}

function closeContactModal(){
    document.querySelector(".contact-modal").classList.add("hide-modal");
    document.querySelector(".contact-modal").classList.remove("show-modal");
}

initMain();