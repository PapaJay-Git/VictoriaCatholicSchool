function logout() {
    Swal.fire({
        title: "Are you sure?",
        text: "Do you really want to log out?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Logout",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/Backend-routes/login/logout-router.php";
        }
    });
}


function submitRequest(formId, event, question = null) {
    event.preventDefault();

    Swal.fire({
        title: "Are you sure?",
        text: question ?? "Are you sure you want to submit this form?",
        showCancelButton: true,
        confirmButtonText: "CONFIRM",
        cancelButtonText: 'CANCEL',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}

function confirmDelete(url, type = 'User') {
    
    Swal.fire({
      title: 'Confirmation',
      text: 'Do you want to delete this '+type+'?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'CONFIRM',
      cancelButtonText: 'CANCEL',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }


function showPasswordTab(){
    var passTab = document.getElementById('password-tab');
    var infoTab = document.getElementById('info-tab');
    var checklistTab = document.getElementById('checklist-tab');

    passTab.style.display = 'block';
    infoTab.style.display = 'none';
    checklistTab.style.display = 'none';
}
function hidePasswordTab(){
    var passTab = document.getElementById('password-tab');
    var infoTab = document.getElementById('info-tab');
    var checklistTab = document.getElementById('checklist-tab');

    passTab.style.display = 'none';
    infoTab.style.display = 'block';
    checklistTab.style.display = 'none';
}

function showChecklist(){
    var passTab = document.getElementById('password-tab');
    var infoTab = document.getElementById('info-tab');
    var checklistTab = document.getElementById('checklist-tab');

    passTab.style.display = 'none';
    infoTab.style.display = 'none';
    checklistTab.style.display = 'block';
}

function showPasswordTab2(){
    var passTab = document.getElementById('password-tab');
    var infoTab = document.getElementById('info-tab');
    var guardianTab = document.getElementById('guardian-tab');

    passTab.style.display = 'block';
    infoTab.style.display = 'none';
    guardianTab.style.display = 'none';
}
function hidePasswordTab2(){
    var passTab = document.getElementById('password-tab');
    var infoTab = document.getElementById('info-tab');
    var guardianTab = document.getElementById('guardian-tab');

    passTab.style.display = 'none';
    infoTab.style.display = 'block';
    guardianTab.style.display = 'none';
}

function showGuadianTab2(){
    var passTab = document.getElementById('password-tab');
    var infoTab = document.getElementById('info-tab');
    var guardianTab = document.getElementById('guardian-tab');

    passTab.style.display = 'none';
    infoTab.style.display = 'none';
    guardianTab.style.display = 'block';
}
function changeBorderColor(selectElement) {
    console.log(1);
    // Get the selected value
    var selectedValue = selectElement.value;

    // Check if the selected value is 1
    // if (selectedValue === "1") {
    //     // Add the CSS class to change the border color to yellow
    //     selectElement.classList.add("selected");
    // } else {
    //     // Remove the CSS class if the value is not 1
    //     selectElement.classList.remove("selected");
    // }
}

function setActive(id) {
    var tab = document.getElementById(id);
    if (tab) {
        tab.classList.add('active-tab');
    }

    var elementsWithClass = document.getElementsByClassName(id);
    for (var i = 0; i < elementsWithClass.length; i++) {
        elementsWithClass[i].classList.add('active-tab');
    }
}

function showPassword() {
    var passwordInputs = document.getElementsByClassName("input-password");
    var checkBox = document.getElementById("checkBox");

    for (var i = 0; i < passwordInputs.length; i++) {
        if (checkBox.checked) {
            passwordInputs[i].type = "text";
        } else {
            passwordInputs[i].type = "password";
        }
    }
}