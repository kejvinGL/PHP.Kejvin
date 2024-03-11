function enableChange(fileInput) {
  let changeButton = document.getElementById("avatarButton");
  if (fileInput.value) {
    changeButton.disabled = false;
  } else {
    changeButton.disabled = true;
  }
}

function enableDelete() {
  let passInput = document.getElementById("enter_pass");
  passInput.oninput = () => {
    let deleteButton = document.getElementById("deleteButton");
    if (passInput.value.length > 7) {
      deleteButton.disabled = false;
    } else {
      deleteButton.disabled = true;
    }
  };
  let deleteButton = document.getElementById("deleteButton");
  if (fileInput.value) {
    deleteButton.disabled = false;
  } else {
    deleteButton.disabled = true;
  }
}
