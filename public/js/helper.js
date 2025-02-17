const ajax = async (url, type, data, headers) => {
  try {
    let response;

    if (data) {
      if (headers) {
        response = await fetch(url, {
          method: type,
          body: JSON.stringify(data),
          headers: headers,
          // Set the content type
        });
        console.log("header present block");
        let result = await response;

        return result;
      } else {
        // const formData = new FormData(data);

        // for(const dkey in data){
        //     formData.append(dkey, data[dkey]);
        // }
        response = await fetch(url, {
          method: type,
          body: data,
        });
        console.log("header absent block");
        let result = await response;

        return result;
      }
    } else {
      response = await fetch(url, {
        method: type,
      });
      console.log("header and body absent block");

      let result = await response;

      return result;
    }
  } catch (error) {
    console.log("Response error:", error);
    return {
      status: "error",
      message: "Fetching Failed",
    };
  }
};

const fetchIp = async()=>{
  try{
      
    let ipPromise = await fetch ('https://api.ipify.org?format=json');
    ipData = await ipPromise.json();
    console.log("my ip is", ipData.ip);
    return ipData.ip;

    }catch(error){

      console.log("An Error Occured While Loading IP");

    };
  }

const createCard = (
  userId,
  userName,
  replies,
  views,
  categoryName,
  color,
  title,
  img,
  thread_id,
  likes,
  createdAt,
  avatar
) => {
  ////////////////////CARD///////////////////////
  const card = document.createElement("div");
  card.className =
    "bg-white dark:bg-light-800 p-4 rounded-lg shadow hover:shadow-lg transition border border-gray-300";
    card.id = "card";
    card.dataset.thread_id = thread_id;

  let cardHeader;
  let cardBody;
  let cardFooter;
  let imgSection;

  const createHeader = (
    userId,
    userName,
    replies,
    views,
    categoryName,
    color,
    avatar
  ) => {
    ////////////////Card Header////////////////
    cardHeader = document.createElement("div");
    cardHeader.className = "flex justify-between items-center";

    //////////////////Card summary///////////////////
    const summary = document.createElement("p");
    summary.className =
      "flex justify-center items-center gap-2 text-gray-600 dark:text-gray-400 text-sm mt-2";

    //////////////////Card summary items//////////////////

    const summaryUserImg = document.createElement("img"); //user img
    summaryUserImg.className = "h-10 w-10 rounded-full object-cover";
    summaryUserImg.src =
      `http://echoforum.free.nf/EchoForum/public/uploads/avatars/${avatar}`;
    summaryUserImg.loading = "lazy";

    const summaryUserName = document.createElement("a"); //username
    summaryUserName.className = "text-primary";
    summaryUserName.href = `.?page=profile&user=${parseInt(userId)}`;
    summaryUserName.textContent = userName;

    const repliesCount = document.createElement("span"); // replies
    repliesCount.textContent = `. ${parseInt(replies)} replies`;

    const viewsCount = document.createElement("span"); // views
    viewsCount.textContent = `. ${parseInt(views)} views`;

    //////////////////Card summary items END//////////////////
    //////////////////Card summary END //////////////////

    const badge = document.createElement("span");
    badge.className = "badge";
    badge.style.backgroundColor = color;
    badge.textContent = categoryName;

    //////////////////Card Header END ////////////////////

    summary.append(summaryUserImg, summaryUserName, repliesCount, viewsCount);
    cardHeader.append(summary, badge);

  };

  const createBody = (title) => {
    cardBody = document.createElement("h3"); // Card title
    cardBody.className = "text-lg font-semibold";
    cardBody.textContent = title;

  };

  const createImg = (img) => {
    imgSection = document.createElement("div");
    imgSection.className = "image-section";

    let imgLink = document.createElement("a");
    imgLink.id = "view-image-btn";
    imgLink.className = "text-primary";
    imgLink.style.textDecoration = "underline";
    imgLink.style.cursor = "pointer";
    imgLink.textContent = "View Image ↓";

    let postImg = document.createElement("img");
    postImg.id = "upload";
    postImg.className = "w-full h-auto object-cover mt-2 rounded-lg";
    postImg.src = `http://echoforum.free.nf/EchoForum/public/uploads/threadPosts/${img}`;
    postImg.style.display = "none";
    postImg.loading = "lazy";

    imgSection.append(imgLink, postImg);

    imgLink.addEventListener("click", () => {
      let image = postImg;
      image.style.display = image.style.display === "none" ? "block" : "none";
      imgLink.textContent =
        image.style.display === "none" ? "View Image ↓" : "View Image ↑";
    });
  };

  const createFooter = (thread_id, likes, createdAt) => {
    //////////////CARD FOOTER////////////////////
    cardFooter = document.createElement("div");
    cardFooter.className = "mt-3 flex justify-between items-center";

    /////////////////Card buttons////////////////////

    let buttons = document.createElement("div"); //buttons container
    buttons.className = "flex space-x-2";

    let viewThreadBtnLink = document.createElement("a"); //view thread button link
    viewThreadBtnLink.href = `.?page=thread&thread_id=${parseInt(thread_id)}`;

    //view thread button
    let viewThreadBtn = document.createElement("button");
    viewThreadBtn.className = "btn btn-outline btn-sm";
    viewThreadBtn.textContent = "👁️ View Thread";

    //apend view thread button to link
    viewThreadBtnLink.append(viewThreadBtn);

    let likesButton = document.createElement("button"); //likes button
    likesButton.className =
      "btn btn-outline btn-primary btn-sm flex items-center space-x-1";
      likesButton.dataset.thread_id = parseInt(thread_id);

    likesButtonIcon = document.createElement("i"); //likes button icon
    likesButtonIcon.className = "fas fa-thumbs-up";

    likesButtonSpan = document.createElement("span"); //likes button span
    likesButtonSpan.textContent = parseInt(likes);

    //append likes button icon and span to likes button
    likesButton.append(likesButtonIcon, likesButtonSpan);

    //append link and likes button to buttons container
    buttons.append(viewThreadBtnLink, likesButton);

    // //like event listener

    likesButton.addEventListener("click", async ()=>{

       console.log(likesButton.dataset.thread_id);

      let thread_id = likesButton.dataset.thread_id;

      const url = `../app/controllers/threadController.php`;

      const formData = {
        thread_id: thread_id,
        action: 1
      };

      console.log(formData);
      
      let promise = await ajax(url, 'PATCH', formData, {'Content-Type' : 'application/json'});

      let response = await promise.json();

      console.log(response);

      showToast(response.msg, response.status);

      if(response.status == 'success' || response.status == 'warning'){

      likesButton.querySelector('span').textContent = response.data;

      }


    });
    //created at Span

    let createdAtSpan = document.createElement("span");
    createdAtSpan.textContent = createdAt;

    cardFooter.append(buttons, createdAtSpan);

  };

  // call functions for creation
  createHeader(userId, userName, replies, views, categoryName, color, avatar);
  createBody(title);
  createImg(img);
  createFooter(thread_id, likes, createdAt);

  //append all to cards
  card.appendChild(cardHeader);
  card.appendChild(cardBody);
  if (typeof img !== "object") {
    card.appendChild(imgSection);
  }
  card.appendChild(cardFooter);

  return card;
};

const createIndCard = (
  userId,
  userName,
  replies,
  views,
  categoryName,
  color,
  title,
  description,
  img,
  thread_id,
  likes,
  createdAt,
  avatar
) => {
  ////////////////////CARD///////////////////////
  const card = document.createElement("div");
  card.className =
    "bg-white dark:bg-light-800 p-4 rounded-lg shadow hover:shadow-lg transition  border border-gray-300";
    card.id = "card";

  let cardHeader;
  let cardBody;
  let cardFooter;
  let imgSection;
  let cardBodyDesc;

  const createHeader = (
    userId,
    userName,
    replies,
    views,
    categoryName,
    color,
    avatar
  ) => {
    ////////////////Card Header////////////////
    cardHeader = document.createElement("div");
    cardHeader.className = "flex justify-between items-center";

    //////////////////Card summary///////////////////
    const summary = document.createElement("p");
    summary.className =
      "flex justify-center items-center gap-2 text-gray-600 dark:text-gray-400 text-sm mt-2";

    //////////////////Card summary items//////////////////

    const summaryUserImg = document.createElement("img"); //user img
    summaryUserImg.className = "h-10 w-10 rounded-full object-cover";
    summaryUserImg.src =
      `http://echoforum.free.nf/EchoForum/public/uploads/avatars/${avatar}`;
    summaryUserImg.loading = "lazy"
    const summaryUserName = document.createElement("a"); //username
    summaryUserName.className = "text-primary";
    summaryUserName.href = `.?page=profile&user=${parseInt(userId)}`;
    summaryUserName.textContent = userName;

    const repliesCount = document.createElement("span"); // replies
    repliesCount.textContent = `. ${parseInt(replies)} replies`;

    const viewsCount = document.createElement("span"); // views
    viewsCount.textContent = `. ${parseInt(views)} views`;

    //////////////////Card summary items END//////////////////
    //////////////////Card summary END //////////////////

    const badge = document.createElement("span");
    badge.className = "badge";
    badge.style.backgroundColor = color;
    badge.textContent = categoryName;

    //////////////////Card Header END ////////////////////

    summary.append(summaryUserImg, summaryUserName, repliesCount, viewsCount);
    cardHeader.append(summary, badge);

  };

  const createBody = (title) => {
    cardBody = document.createElement("h3"); // Card title
    cardBody.className = "text-3xl font-bold text-gray-800 dark:text-dark";
    cardBody.textContent = title;

  };

  const createImg = (img) => {
    imgSection = document.createElement("div");
    imgSection.className = "image-section";

    let imgLink = document.createElement("a");
    imgLink.id = "view-image-btn";
    imgLink.className = "text-primary";
    imgLink.style.textDecoration = "underline";
    imgLink.style.cursor = "pointer";
    imgLink.textContent = "View Image ↓";

    let postImg = document.createElement("img");
    postImg.id = "upload";
    postImg.className = "w-full h-auto object-cover mt-2 rounded-lg";
    postImg.src = `http://echoforum.free.nf/EchoForum/public/uploads/threadPosts/${img}`;
    postImg.style.display = "none";
    postImg.loading = "lazy";

    imgSection.append(imgLink, postImg);

    imgLink.addEventListener("click", () => {
      let image = postImg;
      image.style.display = image.style.display === "none" ? "block" : "none";
      imgLink.textContent =
        image.style.display === "none" ? "View Image ↓" : "View Image ↑";
    });
  };

  const createBodyDesc = (description) => {
    cardBodyDesc = document.createElement("p"); // Card desc
    cardBodyDesc.className = "text-gray-700 dark:text-dark-300 mt-2";
    cardBodyDesc.textContent = description;

  };

  const createFooter = (thread_id, likes, createdAt) => {
    //////////////CARD FOOTER////////////////////
    cardFooter = document.createElement("div");
    cardFooter.className = "mt-3 flex justify-between items-center";

    /////////////////Card buttons////////////////////

    let buttons = document.createElement("div"); //buttons container
    buttons.className = "flex space-x-2";

    let likesButton = document.createElement("button"); //likes button
    likesButton.className =
      "btn btn-outline btn-primary btn-sm flex items-center space-x-1";
    likesButton.dataset.thread_id = thread_id;

    likesButtonIcon = document.createElement("i"); //likes button icon
    likesButtonIcon.className = "fas fa-thumbs-up";

    likesButtonSpan = document.createElement("span"); //likes button span
    likesButtonSpan.textContent = parseInt(likes);

    
    likesButton.addEventListener("click", async ()=>{

      console.log(likesButton.dataset.thread_id);

      let thread_id = likesButton.dataset.thread_id;

      const url = `../app/controllers/threadController.php`;

      const formData = {
        thread_id: thread_id,
        action: 1
      };

      console.log(formData);
      
      let promise = await ajax(url, 'PATCH', formData, {'Content-Type' : 'application/json'});

      let response = await promise.json();

      console.log(response);

      showToast(response.msg, response.status);

      if(response.status == 'success' || response.status == 'warning'){

        likesButton.querySelector('span').textContent = response.data;
  
        }

    });

    //append likes button icon and span to likes button
    likesButton.append(likesButtonIcon, likesButtonSpan);

    //append link and likes button to buttons container
    buttons.append(likesButton);

    //created at Span

    let createdAtSpan = document.createElement("span");
    createdAtSpan.textContent = createdAt;

    cardFooter.append(buttons, createdAtSpan);

  };

  // call functions for creation
  createHeader(userId, userName, replies, views, categoryName, color, avatar);
  createBody(title);
  createImg(img);
  createBodyDesc(description);
  createFooter(thread_id, likes, createdAt);

  //append all to cards
  card.appendChild(cardHeader);
  card.appendChild(cardBody);
  if (typeof img !== "object") {
    card.appendChild(imgSection);
  }
  card.appendChild(cardBodyDesc);
  card.appendChild(cardFooter);

  return card;
};

const createReplyCard = (
  userId,
  userName,
  description,
  thread_id,
  reply_id,
  likes,
  createdAt,
  avatar
) => {
  ////////////////////CARD///////////////////////
  const card = document.createElement("div");
  card.className =
    "bg-white dark:bg-light-800 p-4 rounded-lg shadow hover:shadow-lg transition  border border-gray-300";
    card.id = "reply-card";

  let cardHeader;
  let cardBodyDesc;
  let cardFooter;

  const createHeader = (
    userId,
    userName,
    avatar
  ) => {
    ////////////////Card Header////////////////
    cardHeader = document.createElement("div");
    cardHeader.className = "flex justify-between items-center";

    //////////////////Card summary///////////////////
    const summary = document.createElement("p");
    summary.className =
      "flex justify-center items-center gap-2 text-gray-600 dark:text-gray-400 text-sm mt-2";

    //////////////////Card summary items//////////////////

    const summaryUserImg = document.createElement("img"); //user img
    summaryUserImg.className = "h-10 w-10 rounded-full object-cover";
    summaryUserImg.src =
      `http://echoforum.free.nf/EchoForum/public/uploads/avatars/${avatar}`;

      console.log(avatar);

    const summaryUserName = document.createElement("a"); //username
    summaryUserName.className = "text-primary font-bold";
    summaryUserName.href = `.?page=profile&user_id=${parseInt(userId)}`;
    summaryUserName.textContent = userName;

    // const repliesCount = document.createElement("span"); // replies
    // repliesCount.textContent = `. ${parseInt(replies)} replies`;

    // const viewsCount = document.createElement("span"); // views
    // viewsCount.textContent = `. ${parseInt(views)} views`;

    //////////////////Card summary items END//////////////////
    //////////////////Card summary END //////////////////

    // const badge = document.createElement("span");
    // badge.className = "badge";
    // badge.style.backgroundColor = color;
    // badge.textContent = categoryName;

    //////////////////Card Header END ////////////////////

    
    let createdAtSpan = document.createElement("span");
    createdAtSpan.textContent = createdAt;

    summary.append(summaryUserImg, summaryUserName);
    cardHeader.append(summary, createdAtSpan);

  };

  const createBodyDesc = (description) => {
    cardBodyDesc = document.createElement("p"); // Card desc
    cardBodyDesc.className = "text-gray-700 dark:text-dark-300 mt-2";
    cardBodyDesc.textContent = description;

  };

  const createFooter = (reply_id, likes, createdAt) => {
    //////////////CARD FOOTER////////////////////
    cardFooter = document.createElement("div");
    cardFooter.className = "mt-3 flex justify-between items-center";

    /////////////////Card buttons////////////////////

    let buttons = document.createElement("div"); //buttons container
    buttons.className = "flex space-x-2";

    let likesButton = document.createElement("button"); //likes button
    likesButton.className =
      "btn btn-outline btn-primary btn-sm flex items-center space-x-1";
    likesButton.dataset.reply_id = reply_id;

    likesButtonIcon = document.createElement("i"); //likes button icon
    likesButtonIcon.className = "fas fa-thumbs-up";

    likesButtonSpan = document.createElement("span"); //likes button span
    likesButtonSpan.textContent = parseInt(likes);

    
    likesButton.addEventListener("click", async ()=>{

      console.log(likesButton.dataset.reply_id);

      let reply_id = likesButton.dataset.reply_id;

      const url = `../app/controllers/threadReplyController.php`;

      const formData = {
        reply_id: reply_id,
      };

      console.log(formData);
      
      let promise = await ajax(url, 'PATCH', formData, {'Content-Type' : 'application/json'});

      let response = await promise.json(); 

      console.log(response);

      showToast(response.msg, response.status);

      if(response.status == 'success' || response.status == 'warning'){

        likesButton.querySelector('span').textContent = response.data;
  
        }

    });

    //append likes button icon and span to likes button
    likesButton.append(likesButtonIcon, likesButtonSpan);

    //append link and likes button to buttons container
    buttons.append(likesButton);

    //created at Span


    cardFooter.append(buttons);

  };

  // call functions for creation
  createHeader(userId, userName, avatar);
  createBodyDesc(description);
  createFooter(reply_id, likes, createdAt);

  //append all to cards
  card.appendChild(cardHeader);
  card.appendChild(cardBodyDesc);
  card.appendChild(cardFooter);

  return card;
};