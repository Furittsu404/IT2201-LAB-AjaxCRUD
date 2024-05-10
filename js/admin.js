let searchbar = document.querySelector("#search-bar");

document.querySelector("#search-icon").onclick = () => {
    searchbar.classList.toggle("drop");
}

function showHideRow(row) {
    $("#"+row).toggle();
}

function numberOnly(id) {
  var element = document.getElementById(id);
  element.value = element.value.replace(/[^0-9]/gi, "");
}

function letterOnly(id) {
  var element = document.getElementById(id);
  element.value = element.value.replace(/[^a-zA-Z0-9@-_.~ ]/g, "");
}
function validSymbol(id) {
  var element = document.getElementById(id);
  element.value = element.value.replace(/[^a-zA-Z0-9!@#$%^&*\-_=+,./?\\|`~ ]/g, "");
}

function showPassword(pass, confirm) {
  const passwordField = document.getElementById(pass);
  const confirmPasswordField = document.getElementById(confirm);

  if (passwordField.type === 'password') {
      passwordField.type = 'text';
      confirmPasswordField.type = 'text';
  } else {
      passwordField.type = 'password';
      confirmPasswordField.type = 'password';
  }
}

$(document).ready(function () {
  $('.edit').on('click', function (e) {
      e.preventDefault();
      let user_ID = $(this).data('id');
      $.ajax({
          url: 'EDIT.modal.php',
          type: 'POST',
          data: {user_ID: user_ID },
          success: function (response) {
              $('#actionModal').html(response);
          }
      });
  });
});
$(document).ready(function () {
  $('.delete').on('click', function (e) {
      e.preventDefault();
      let user_ID = $(this).data('id');
      $.ajax({
          url: 'DELETE.modal.php',
          type: 'POST',
          data: {user_ID: user_ID },
          success: function (response) {
              $('#actionModal').html(response);
          }
      });
  });
});
$(document).ready(function () {
  $('.create').on('click', function (e) {
      e.preventDefault();
      let user_ID = $(this).data('id');
      $.ajax({
          url: 'CREATE.modal.php',
          type: 'POST',
          data: {user_ID: user_ID },
          success: function (response) {
              $('#actionModal').html(response);
          }
      });
  });
});