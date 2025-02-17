window.addEventListener("load", async () => {

    // Extract URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const userId = urlParams.get("user");
    console.log("User ID:", userId);
  
    // Build URL for userProfileController
    const profileUrl = `../app/controllers/userProfileController.php?user_id=${userId}`;
  
    // Function to update user data on the profile page
    const updateUser = async () => {
      try {
        let promise = await ajax(profileUrl, "GET");
        let response = await promise.json();
        const user = response.data;
        if (user) {
          const usernameDisplay = document.querySelector("#usernameDisplay");
          const usernameInput = document.querySelector("#usernameInput");
          const bioDisplay = document.querySelector("#bioDisplay");
          const bioInput = document.querySelector("#bioInput");
          const threadsShow = document.querySelector("#threadsShow");
          const repliesShow = document.querySelector("#repliesShow");
          const treadLikesShow = document.querySelector("#treadLikesShow");
          const replyLikesShow = document.querySelector("#replyLikesShow");
          const userImg = document.querySelector(".userImg");
          const userProfileName = document.querySelector("#userProfileName");
          const userProfile = document.querySelector("#userProfile");
  
          if (userImg) userImg.src = "http://echoforum.free.nf/EchoForum/public/avatars/"+user.avatar;
          if (userProfile) userImg.src = "http://echoforum.free.nf/EchoForum/public/uploads/avatars/"+user.avatar;
          if (usernameDisplay) usernameDisplay.innerText = user.user_name;
          if (userProfileName) userProfileName.innerText = user.user_name;
          if (usernameInput) {
            usernameInput.innerText = user.user_name;
            usernameInput.value = user.user_name;
          }
          if (bioDisplay) bioDisplay.innerText = user.bio;
          if (bioInput) {
            bioInput.innerText = user.bio;
            bioInput.value = user.bio;
          }
          if (threadsShow) threadsShow.innerText = user.threads;
          if (repliesShow) repliesShow.innerText = user.replies;
          if (treadLikesShow) treadLikesShow.innerText = user.thread_likes;
          if (replyLikesShow) replyLikesShow.innerText = user.reply_likes;
        }
      } catch (error) {
        console.log("Error updating user profile:", error);
      }
    };

    try {
      // EDIT USERNAME
      const editButton = document.getElementById('editButton');
      if (editButton) {
        editButton.addEventListener('click', function() {
          const usernameDisplay = document.getElementById('usernameDisplay');
          const usernameInput = document.getElementById('usernameInput');
          const saveButton = document.getElementById('saveButton');
          if (usernameDisplay && usernameInput && saveButton) {
            usernameDisplay.style.display = 'none';
            usernameInput.style.display = 'block';
            editButton.style.display = 'none';
            saveButton.style.display = 'block';
          }
        });
      }
  
      const saveButton = document.getElementById('saveButton');
      if (saveButton) {
        saveButton.addEventListener('click', async function() {
          const usernameDisplay = document.getElementById('usernameDisplay');
          const usernameInput = document.getElementById('usernameInput');
          if (usernameDisplay && usernameInput) {
            const newUsername = usernameInput.value;
            

            const url = `../app/controllers/userProfileController.php`;

            try{
            let formData = new FormData();

            formData.append('user_name', newUsername);

            let editPromise = await ajax(url, "POST", formData);

            let editResponse = await editPromise.json();

            console.log(editResponse);

            showToast(editResponse.msg, editResponse.status);

            updateUser();

            if(editResponse.status == "success"){
            usernameDisplay.style.display = 'block';
            usernameInput.style.display = 'none';
            // Re-display the edit button if it exists
            const editButton = document.getElementById('editButton');
            if (editButton) {
              editButton.style.display = 'block';
            }
            saveButton.style.display = 'none';
          }


          }catch(error){

            console.log(error);
            showToast("An Error Occurred", "error");

          }
          }
        });
      }
  
      // EDIT BIO
      const editBioButton = document.getElementById('editBioButton');
      if (editBioButton) {
        editBioButton.addEventListener('click', function() {
          const bioDisplay = document.getElementById('bioDisplay');
          const bioInput = document.getElementById('bioInput');
          const saveBioButton = document.getElementById('saveBioButton');
          if (bioDisplay && bioInput && saveBioButton) {
            bioDisplay.style.display = 'none';
            bioInput.style.display = 'block';
            editBioButton.style.display = 'none';
            saveBioButton.style.display = 'block';
          }
        });
      }
  
      const saveBioButton = document.getElementById('saveBioButton');
      if (saveBioButton) {
        saveBioButton.addEventListener('click', async function() {
          const bioDisplay = document.getElementById('bioDisplay');

        

          const bioInput = document.getElementById('bioInput');
          if (bioDisplay && bioInput) {

            const newBio = bioInput.value;

            const url = `../app/controllers/userProfileController.php`;

            try{
            let formData = new FormData();

            formData.append('bio', newBio);
            // formData.append('bio', null);
            // formData.append('image', null );

            let editPromise = await ajax(url, "POST", formData);

            let editResponse = await editPromise.json();

            console.log(editResponse);

            showToast(editResponse.msg, editResponse.status);

            updateUser();

            if(editResponse.status == "success"){
              bioDisplay.style.display = 'block';
              bioInput.style.display = 'none';
              // Re-display the editBioButton if it exists
              const editBioButton = document.getElementById('editBioButton');
              if (editBioButton) {
                editBioButton.style.display = 'block';
              }
              saveBioButton.style.display = 'none';
          }


          }catch(error){

            console.log(error);
            showToast("An Error Occurred", "error");

          }
          }
        });
      }
    } catch (error) {
      console.log("Error in setting up edit/save event listeners:", error);
    }

    let avatar =  document.querySelector("#avatar");

    let profilePic=document.querySelector("#profilePic");

    avatar.addEventListener("click", ()=>{
      console.log("clicked");
      profilePic.classList.toggle("w-28");
    });
  
    if(document.querySelector(".profilePicInput")){
      const profilePicInput = document.querySelector(".profilePicInput")   
  

    profilePicInput.addEventListener("submit", async (e)=>{

    e.preventDefault();


    console.log(profilePic.value);

    
    const url = `../app/controllers/userProfileController.php`;

    try{
    let formData = new FormData(profilePicInput);

    let editPromise = await ajax(url, "POST", formData);

    let editResponse = await editPromise.json();

    showToast(editResponse.msg, editResponse.status);

    updateUser();

  }catch(error){

    console.log(error);
    showToast("An Error Occurred", "error");

  }


    });
   }

   updateUser();
   
  });
  