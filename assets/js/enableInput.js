function enableChange(fileInput) {
  let changeButton = document.getElementById("avatarButton");
  if (fileInput.value) {
    changeButton.disabled = false;
  } else {
    changeButton.disabled = true;
  }
}
