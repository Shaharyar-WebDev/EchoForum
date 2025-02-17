window.addEventListener("load", () => {

  console.log("index.php loaded");

  const threadContainer = document.querySelector("#thread-container");

  const loader = document.querySelector(".loading");

  const errorMessage = threadContainer.querySelector("#error-message");

  const threadHeading = document.querySelector("#thread-heading");


  let category_id;

  let categoryLink;

  if (document.querySelectorAll("#category-link")) {

    categoryLink = document.querySelectorAll("#category-link");
  }

  //LOADING INITIAL THREADS ON PAGE RELOAD
  const loadInitialThreads = async ()=>{

    threadContainer.querySelectorAll('#card').forEach(card=>{

      card.remove();

    });

    // sort = true;
    const url = `../app/controllers/threadController.php?sort=true`;

    let threadResponse;

      try {

        errorMessage.classList.add("hidden");

        loader.style.display = "block";

        let threadPromise = await ajax(url, "GET");

        threadResponse = await threadPromise.json();

        console.log(threadResponse);
        console.log(threadResponse.status);
        console.log(threadResponse.error);
        console.log(threadResponse.data);

        for (data of threadResponse.data) {
          threadContainer.appendChild(
            createCard(
              data.user_id,
              data.user_name,
              data.replies,
              data.views,
              data.cat_name,
              data.color,
              data.thread_title,
              data.thread_image,
              data.thread_id,
              data.likes,
              data.created_at,
              data.avatar
            )
          );
        }

        loader.style.display = "none";

      } catch (error) {
        loader.style.display = "none";
        console.log("An Error Occured While Loading Data");
         if(!threadResponse){
          errorMessage.querySelector("span").textContent = "An Error Ocurred While Loading Data";
   
        }else{
          errorMessage.querySelector("span").textContent = threadResponse.msg;
        }
        // errorMessage.querySelector("span").textContent =
        //   "An Error Occured While Loading Data! Please Reload and try Again : ",
        //   error;
        errorMessage.classList.remove("hidden");
      }
    

  };

//   setTimeout(()=>{

    loadInitialThreads();

//   }, 1000);

  //latest sorting

  if(document.querySelector("#latest")){

  
    const latestBtn = document.querySelector("#latest");

    console.log(latestBtn);

    latestBtn.addEventListener("click",()=>{
      //change threads container heading based omn selected tab
      threadHeading.textContent = latestBtn.innerText + " Discussions";
      
      document.querySelectorAll("#card").forEach((card) => {
        card.remove();
      })

      loadInitialThreads()
    
    });

  }

  //Category sorting

  categoryLink.forEach((link) => {
    link.addEventListener("click", async () => {
      document.querySelectorAll("#card").forEach((card) => {
        card.remove();
      });


      threadHeading.textContent = link.innerText + " Discusions";

      category_id = link.dataset.value;

      const url = `../app/controllers/threadController.php?category_id=${category_id}`;

      let response;
  
      try {
        errorMessage.classList.add("hidden");

        loader.style.display = "block";

        let promise = await ajax(url, "GET");

        response = await promise.json();

        console.log(response);
        console.log(response.status);
        console.log(response.error);
        console.log(response.data);

        for (data of response.data) {
          threadContainer.appendChild(
            createCard(
              data.user_id,
              data.user_name,
              data.replies,
              data.views,
              data.cat_name,
              data.color,
              data.thread_title,
              data.thread_image,
              data.thread_id,
              data.likes,
              data.created_at,
              data.avatar,
              data.avatar
            )
          );
        }

        loader.style.display = "none";

      } catch (error) {
        loader.style.display = "none";

        console.log("An Error Occured While Loading Data");
        
        if(!response){
          errorMessage.querySelector("span").textContent = "An Error Ocurred While Loading Data";
   
        }else{
          errorMessage.querySelector("span").textContent = response.msg;
        }
       
        errorMessage.classList.remove("hidden");
      }
    });
  });

   const search = document.querySelector("#search");

  search.addEventListener("input", async ()=>{

    console.log(search.value);

    let searchUrl = `../app/controllers/threadController.php?search=${search.value}`;

    let searchResponse;

    console.log(searchUrl);

    try {

      threadContainer.querySelectorAll("#card").forEach(card=>{
        card.remove();
      });

      errorMessage.classList.add("hidden");

      loader.style.display = "block";

      let searchPromise = await ajax(searchUrl, "GET");

      searchResponse = await searchPromise.json();

      console.log(searchResponse);
      console.log(searchResponse.status);
      console.log(searchResponse.error);
      console.log(searchResponse.data);

      for (data of searchResponse.data) {
        threadContainer.appendChild(
          createCard(
            data.user_id,
            data.user_name,
            data.replies,
            data.views,
            data.cat_name,
            data.color,
            data.thread_title,
            data.thread_image,
            data.thread_id,
            data.likes,
            data.created_at,
            data.avatar
          )
        );
        // console.log("apended");
      }

      loader.style.display = "none";

    } catch (error) {
      loader.style.display = "none";
      console.log("An Error Occured While Loading Data :" + error);

      if(!searchResponse){
 errorMessage.querySelector("span").textContent =
        "An Error Occured While Loading Data! Please Reload and try Again : ",
        error;
      }else{
           errorMessage.querySelector("span").textContent = searchResponse.msg;
      }
     
      errorMessage.classList.remove("hidden");
    }

  });
});
