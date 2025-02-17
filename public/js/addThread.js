let addThreadForm = document.querySelector(".add-thread-form");

addThreadForm.addEventListener("submit", async (e) => {
  e.preventDefault();

  //when sending form data via fetch, we need to use FormData object to get the form data

  // and we can append the form inside the formData class

  // let title = addThreadForm.querySelector("#title").value.trim();
  // let content = addThreadForm.querySelector("#content").value.trim();
  // let category = addThreadForm.querySelector("#category").value.trim();
  // let img = document.querySelector(".file-input").value;

  // // let threadData = {
  // //     title: title,
  // //     content: content,
  // //     category: category,
  // //     img: img
  // // };

  // const formData = new FormData(addThreadForm);

  // let promise = await fetch('../app/controllers/threadController.php', {
  //     method: 'POST',
  //     body: formData
  // });

  // console.log(addThreadForm);

  const formData = new FormData(addThreadForm);

  const url = "../app/controllers/threadController.php";

  let promise = await ajax(url, "post", formData);

  console.log(promise);

  let response = await promise.json();

  console.log(response);

  showToast(response.msg, response.status);

  if (response.status == "success") {
    setTimeout(() => {
      addThreadForm.reset();
    }, 500);
  }
});
