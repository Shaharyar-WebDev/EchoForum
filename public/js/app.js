//GLOBAL JS
// SAVED THEME
window.addEventListener("load", () => {
let theme = localStorage.getItem("theme");

console.log("this" , theme);
if(theme){
  document.querySelector("html").dataset.theme = theme;
};
});
// THEME PREFERENCE SWITCH BUTTON
if(document.querySelector("#settingsSubmenu").querySelectorAll("a")){

  let themeLinks = document
  .querySelector("#settingsSubmenu")
  .querySelectorAll("a");
let html = document.querySelector("html");

themeLinks.forEach((link) => {
  link.addEventListener("click", () => {
    html.dataset.theme = link.dataset.themename;
    localStorage.setItem("theme", link.dataset.themename);
  });
});
  
};

if(document.querySelector("#settingsSubmenu").querySelectorAll("input")){

  const themeToggle = document.querySelector("#settingsSubmenu").querySelectorAll("input");
  console.log(themeToggle);

  themeToggle.forEach(box => {

    box.addEventListener("click", ()=>{

      localStorage.setItem('box', box.value);

    console.log(box, "clicked", box.value, box.checked)

    });

    console.log(box.value);

  });

  window.addEventListener("load", ()=>{
 
    if(localStorage.getItem('box')){

    console.log(localStorage.getItem('box'));
    
    themeToggle.forEach(box => {

      if(localStorage.getItem('box') == box.value){

        box.checked = true;

      }

    });

    }

     
// 
    // }
    
});
    // let themeLinks = document
//   .querySelector("#settingsSubmenu")
//   .querySelectorAll("a");
// let html = document.querySelector("html");

// themeLinks.forEach((link) => {
//   link.addEventListener("click", () => {
//     html.dataset.theme = link.dataset.themename;
//     localStorage.setItem("theme", link.dataset.themename);
//   });
// });
  
};


// ACTIVE TABS
if(document.querySelectorAll(".tab")){

  let tabs = document.querySelectorAll(".tab");

  tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      tabs.forEach((t) => {
        t.classList.remove("tab-active");
      });
      tab.classList.add("tab-active");
    });
  });
  
  // console.log(html.dataset.theme);

};


// JavaScript Function to Show Toast
function showToast(message, type) {
  const toastContainer = document.querySelector("#toast-container");

  console.log(toastContainer);

  // Toast Colors based on Type
  const colors = {
    success: "bg-green-500",
    error: "bg-red-500",
    warning: "bg-yellow-500",
    info: "bg-blue-500",
  };
  // Toast icon based on Type
  const icons = {
    success: "fa-circle-check",
    error: "fa-circle-xmark",
    warning: "fa-triangle-exclamation",
    info: "fa-circle-exclamation",
  };

  // Create Toast Element
  const toast = document.createElement("div");
  toast.className = `p-3 text-white rounded-lg shadow-lg transition-all transform translate-x-10 opacity-0 ${colors[type]}`;
  toast.innerHTML = `
    <i class="fas ${icons[type]}"></i>
    <strong>${message}</strong>`;

  // Add to Toast Container
  toastContainer.appendChild(toast);

  // Smooth Slide-In Animation
  setTimeout(() => {
    // toast.classList.remove("translate-x-10", "opacity-0");
    toast.classList.add("translate-x-0", "opacity-100");
  }, 50);

  // Auto Remove with Fade-Out
  setTimeout(() => {
    toast.classList.remove("translate-x-0", "opacity-100"); // Fade-Out Duration
    setTimeout(() => {
      toast.remove();
    }, 100);
  }, 2500);
}

// Example Usage
// showToast("Thread created successfully!", "info");
