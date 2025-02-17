window.addEventListener("load", async () => {
  // GET THREAD_ID PARAMETER FROM URL
  const parameter = window.location.search;

  console.log(parameter);

  const urlParams = new URLSearchParams(parameter);

  let thread_id = urlParams.get("thread_id");

//  //  //  //  //  //  //  //  //  //  //  //  //

  // THREAD CONTAINER // SELECT ELEMENTS
  const threadContainer = document.querySelector("#thread-container");

  const tabs = document.querySelectorAll(".tab");

  const loader = document.querySelector(".loading");

  const errorMessage = threadContainer.querySelector("#error-message");

  const replyContainer = document.querySelector("#reply-container");

  const replyLoader = document.querySelector(".reply-loading");

  const replyErrorMessage = replyContainer.querySelector("#reply-error-message");

  const replyForm = document.querySelector("#reply-form");

  //  //  //  //  //  //  //  //  //  //  //  //  //

  // FETCHING IP ADDRESS FOR INCREMENTING THREAD VIEW
  try {
    const ipData = await fetchIp();

    console.log("my ip" , ipData);

    const formData = {
      user_ip: ipData,
      thread_id: thread_id,
      action: 2,
      type: 'view'
    };

    console.log(formData);

    const viewUrl = `../app/controllers/threadController.php`;

    let addViewPromise = await ajax(viewUrl, "PATCH", formData, {
      "Content-Type": "application/json",
    });

    let addViewResult = addViewPromise.json();

    console.log(addViewResult);
  } catch (error) {
    console.log("ERROR SOME PROBLEM OCCURED!, CAN BE SLOW NETWORK!!");
  }

  // FETCHING AND DISPLAYING THREAD
  const url = `../app/controllers/threadController.php?thread_id=${thread_id}`;

  const displayThread = async () => {

    let response;

    try {
      // hide error message if exist previously
      if (!errorMessage.classList.contains("hidden")) {

        errorMessage.classList.add("hidden");

      };

      loader.style.display = "block";

      let threadPromise = await ajax(url, "GET");

      let threadResponse = await threadPromise.json();

      console.log(threadResponse);
      console.log(threadResponse.status);
      console.log(threadResponse.data);

      for (data of threadResponse.data) {
        threadContainer.appendChild(
          createIndCard(
            data.user_id,
            data.user_name,
            data.replies,
            data.views,
            data.cat_name,
            data.color,
            data.thread_title,
            data.thread_description,
            data.thread_image,
            data.thread_id,
            data.likes,
            data.created_at,
            data.avatar
          )
        );
        console.log(data.avatar);
      }

      loader.style.display = "none";

    } catch (error) {
      loader.style.display = "none";
      console.log("An Error Occured While Loading Data");

      errorMessage.textContent =
        "An Error Occured While Loading Thread! Please Reload and try Again :",
        error;

      threadContainer.querySelector("#error-message").classList.remove("hidden");
    }

  };

  displayThread();


  // FETCHING AND DISPLAYING REPLIES

  const replyUrl = `../app/controllers/threadReplyController.php?thread_id=${thread_id}`;

  let replyResponse;

  const displayReplies = async (url) => {
    try {
      // hide error message if exist previously
      if (!replyErrorMessage.classList.contains("hidden")) {

        replyErrorMessage.classList.add("hidden");

      };

      document.querySelectorAll("#reply-card").forEach(card => {
        card.remove();
      });

      replyLoader.style.display = "block";

      let replyPromise = await ajax(url, "GET");

      replyResponse = await replyPromise.json();

      for (data of replyResponse.data) {
        replyContainer.appendChild(
          createReplyCard(
            data.user_id,
            data.user_name,
            data.reply_desc,
            data.thread_id,
            data.reply_id,
            data.likes,
            data.created_at,
            data.avatar
          )
        );
      }

      replyLoader.style.display = "none";
    } catch (error) {
      replyLoader.style.display = "none";

      console.log("An Error Occured While Loading Data:", error);

     
      if(!replyResponse){
      //ACTUAL ERROR
        replyErrorMessage.textContent =
        "An Error Occured While Loading Thread! Please Reload and try Again :",
        error;

      }else{
      //TEMP ERROR
        replyErrorMessage.textContent = replyResponse.msg ;
        console.log(error);
      }
      replyErrorMessage.classList.remove("hidden");
    }

  }

  displayReplies(replyUrl);


  //REPLY FORM

  replyForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    let replyInput = document.querySelector("#reply-input").value;

    const formData = new FormData();

    formData.append("thread_id", thread_id);
    formData.append("reply", replyInput);

    const url = `../app/controllers/threadReplyController.php`;

    let replyPromise = await ajax(url, "POST", formData);

    let response = await replyPromise.json();

    console.log(response);

    showToast(response.msg, response.status);

    if (response.status == "success") {

      replyContainer.querySelectorAll("#card").forEach(card => {

        card.remove();

      })
      threadContainer.querySelectorAll("#card").forEach(card => {

        card.remove();
      });
      replyForm.reset();

      tabs.forEach(tab => {

        if(tab.classList.contains("tab-active")){
        
          sort = tab.dataset.sort;
      
          const sortUrl = `../app/controllers/threadReplyController.php?thread_id=${thread_id}&sort=${sort}`;
    
          displayReplies(sortUrl);
  
         }
      
    
      });

      displayThread();

    }

  });


  tabs.forEach(tab => {

    tab.addEventListener("click", ()=>{

      console.log(tab.dataset.sort);

      sort = tab.dataset.sort;

      const sortUrl = `../app/controllers/threadReplyController.php?thread_id=${thread_id}&sort=${sort}`;

      displayReplies(sortUrl);

    });

  });

});