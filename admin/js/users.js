window.addEventListener("load", async()=>{
    
    let active;

    const table = document.querySelector("#table");

    const pagination = document.querySelector("#pagination");
    
    const loader = document.querySelector("#table-loader");

    console.log(pagination);

   
    const loadUsersTable = async (page) =>{

        loader.style.display = "inline";

        pagination.querySelectorAll("input").forEach(input => {
            input.remove();
            console.log("removed");
        });

        if(active){
            console.log("active on load" , active);
        };
    
        let url;

        if(page){
    
        url = `../app/controllers/adminUserController.php?page=${page}`;
    
        }else{
    
        url = `../app/controllers/adminUserController.php`;
    
        }
    
        try{



            table.querySelectorAll("tr").forEach(row => {
                row.remove();
                
            });

    let getAllUsersPromise = await ajax(url, "GET");

    let getAllUsersResult = await getAllUsersPromise.json();

    console.log(getAllUsersResult);

    const users = getAllUsersResult.data

    let updateBtn;
    let deleteBtn;

    for(user of users){
   
        const tr = document.createElement("tr");

        tr.dataset.userid = user.user_id;
        tr.dataset.username = user.user_name;
        tr.dataset.email = user.email;
        tr.dataset.role = user.role;
        tr.dataset.bio = user.bio;
        tr.dataset.createdat = user.created_at;
        tr.dataset.avatar = "http://echoforum.free.nf/EchoForum/public/uploads/avatars/"+user.avatar;


            const tdUserId = document.createElement("td");
            tdUserId.textContent = user.user_id;
            
            const tdUserName = document.createElement("td");
            tdUserName.textContent = user.user_name;

            const tdUserEmail = document.createElement("td");
            tdUserEmail.textContent = user.email;

            const tdUserRole = document.createElement("td");
            tdUserRole.textContent = user.role;

            const tdUserBio = document.createElement("td");
            const bioArea = document.createElement("textarea");
            bioArea.class = "textarea";
            bioArea.value = user.bio;
            tdUserBio.appendChild(bioArea);

            const tdUserCreatedat = document.createElement("td");
            tdUserCreatedat.textContent = user.created_at;

            const tdUserAvatar = document.createElement("td");
            const avatarImgDiv = document.createElement("div");
            avatarImgDiv.classList = "w-10 h-10 rounded-full border border-gray-300 dark:border-gray-600 overflow-hidden";
            const avatarImg = document.createElement("img");
            avatarImg.classList = "w-full h-full object-cover";
            avatarImg.src = "http://echoforum.free.nf/EchoForum/public/uploads/avatars/"+user.avatar;
            avatarImgDiv.appendChild(avatarImg);
            tdUserAvatar.appendChild(avatarImgDiv);


            const actionBtns = document.createElement("td");
            actionBtns.classList = "flex gap-2";
            updateBtn = document.createElement("button");
            updateBtn.classList = "btn btn-primary btn-outline hover:bg-primary btn-md";
            updateBtn.id = "update-modal-button";
            updateBtn.innerHTML = '<i class="fas fa-upload" style="pointer-events: none"></i>Update';

            deleteBtn = document.createElement("button");
            deleteBtn.classList = "btn btn-error btn-outline hover:bg-error btn-md";
            deleteBtn.id = "delete-modal-button";
            deleteBtn.innerHTML = '<i class="fas fa-trash" style="pointer-events: none"></i>Delete';

            actionBtns.append(updateBtn, deleteBtn);


            tr.appendChild(tdUserId);
            tr.appendChild(tdUserAvatar);
            tr.appendChild(tdUserName);
            tr.appendChild(tdUserEmail);
            tr.appendChild(tdUserRole);
            tr.appendChild(tdUserBio);
            tr.appendChild(tdUserCreatedat);
            tr.appendChild(actionBtns);
            
            table.appendChild(tr);


    }

    for (let page = 1; page <= getAllUsersResult.pagination; page++) {
        console.log(`no of paginaton`);
        // You would typically fetch data for each page here
        const paginationInput = document.createElement("input");
        paginationInput.classList = "join-item btn btn-square";
        paginationInput.id = "pagination";
        paginationInput.type = "radio";
        paginationInput.name = "options";
        paginationInput.dataset.page = `${page}`;
        paginationInput.ariaLabel  = `${page}`;
        paginationInput.dataset.sno = `${page}`;

        pagination.appendChild(paginationInput);
      }

        if(active){
            
            pagination.querySelectorAll("input").forEach(btn=>{

                if(btn.dataset.page == active){
                    
                    btn.checked = true;

                }

            });

        }
    else{
    pagination.firstElementChild.checked = true;
    };

    loader.style.display = "none";

}catch(error){
    console.log("An Error Occured " + error);
}

};

loadUsersTable(1);

const updateModalButtons = document.querySelectorAll("#update-modal-button");

    const deleteModalButtons = document.querySelectorAll("#delete-modal-button");
    
    const updateModal = document.querySelector("#update-modal");

    const deleteModal = document.querySelector("#delete-modal");

    const updateForm = document.querySelector("#update-User-form");

    const confirmDeleteBtn = document.querySelector("#confirm-delete-button");


 // Event Delegations for populating modals
 table.addEventListener("click", async (e)=>{

    console.log(e.target);

    if(e.target.id == "update-modal-button"){

        updateBtn = e.target;

        console.log("OK");

        updateForm.reset();

       updateModal.checked = true;

    console.log(updateBtn.parentElement.parentElement);

    const row = updateBtn.parentElement.parentElement;

    console.log(row.dataset.bio);

    document.querySelector("#modal-user-id").value = row.dataset.userid;
    document.querySelector("#modal-user-name").value = row.dataset.username;
    document.querySelector("#modal-email").value = row.dataset.email;
    document.querySelector("#modal-role").value = row.dataset.role;
    document.querySelector("#modal-bio").value = row.dataset.bio;
    document.querySelector("#modal-created-at").value = row.dataset.createdat;
    document.querySelector("#modal-avatar-img").src = row.dataset.avatar;

    if(row.dataset.role == 1){
        
        document.querySelector("#modal-role").options[1].disabled = true;

    }else{
        document.querySelector("#modal-role").options[1].disabled = false;
    };
};
    if(e.target.id == "delete-modal-button"){

        deleteBtn = e.target;

        deleteModal.checked = true;

            const row = deleteBtn.parentElement.parentElement;
        
            const id = row.dataset.userid;
        
            deleteModal.nextElementSibling.querySelector("#confirm-delete-button").dataset.id = id;

    };
 

});

// Update button User Update
document.addEventListener("submit", async (e)=>{

    if(e.target.id == "update-User-form"){

        console.log(e.target);

        console.log("true confirmed");

        e.preventDefault();
        
        console.log("Form Submit preventDefault");

            const url = "../app/controllers/adminUserController.php";
        
            let formData = new FormData(updateForm);
        
            let updateUserPromise = await ajax(url, "POST", formData);
        
            let updateUserResult = await updateUserPromise.json();
        
            console.log(updateUserResult);
        
            showToast(updateUserResult.msg, updateUserResult.status);
        
            if(updateUserResult.status == "success"){
        
                
                updateModal.checked = false;
                updateForm.reset();
                
                let page1;
                let selected;
                pagination.querySelectorAll("input").forEach(input=>{
                    console.log(input, "these are them");
                    if(input.checked == true){
                        page1=input.dataset.page;
                        selected = input;
                    }
                });
                selected.checked = true;
                loadUsersTable(page1);
        
            }
            

    }

});

// Delete Button User Delete
confirmDeleteBtn.addEventListener("click", async ()=>{

    const UserId = confirmDeleteBtn.dataset.id;

    console.log(UserId);

    const deleteUrl = "../app/controllers/adminUserController.php"; 

    const formData = {
        userId : UserId
    };

    let deleteUserPromise = await ajax(deleteUrl, "PATCH", formData, {"Content-Type":"application/json"});

    let deleteUserResult = await deleteUserPromise.json();

    showToast(deleteUserResult.msg, deleteUserResult.status);

    if(deleteUserResult.status == "success"){

        let page1;
        let selected;
        pagination.querySelectorAll("input").forEach(input=>{
            console.log(input, "these are them");
            if(input.checked == true){
                page1=input.dataset.page;
                selected = input;
            }
        })
        selected.checked = true;
        loadUsersTable(page1);

    }

    deleteModal.checked = false;

    console.log(deleteUserResult);

});

//Pagination Event delegation
document.addEventListener("click", (e)=>{

    if(e.target.id == "pagination"){
        console.log("yes");
        console.log(e.target);
        console.log(e.target.dataset.page);

        active = e.target.dataset.page;
        console.log(active);

        loadUsersTable(e.target.dataset.page);
    }

});

pagination.querySelectorAll("input").forEach(btn=>{

 btn.addEventListener("click", ()=>{

  btn.checked = true;

 });

});

// updateForm.addEventListener("submit", async (e)=>{

//     if(e.target.id == "confirm-update-btn"){

//         console.log("true confirmed");

//         e.preventDefault();

//     console.log("Form Submit preventDefault");

//     const url = "../app/controllers/adminUserController.php";

//     let formData = new FormData(updateForm);

//     let updateUserPromise = await ajax(url, "POST", formData);

//     let updateUserResult = await updateUserPromise.json();

//     console.log(updateUserResult);

//     showToast(updateUserResult.msg, updateUserResult.status);

//     if(updateUserResult.status == "success"){

        
//         updateModal.checked = false;
//         updateForm.reset();
        
//         loadUsersTable();

//     }
     

//     }

    

// });


// delete button event listener
// deleteBtn.addEventListener("click", ()=>{

//     deleteModal.checked = true;

//     const row = deleteBtn.parentElement.parentElement;

//     const id = row.dataset.userid;

//     console.log(id);


// });


    


});