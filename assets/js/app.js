
$(function () {

  // ===================== Sidebar Active Link =====================
  const here = location.search;

  $('.sidebar .menu a').each(function () {
    if (here && this.search && here.indexOf(this.search) === 0) {
      $(this).addClass('active');
    }
  });

  // ===================== Sidebar Toggle =====================
  $('#sidebarToggle').on('click', function () {
    $('.sidebar').toggleClass('open');
  });

  // ===================== DataTables Init =====================
  $('.data-table').each(function () {
    $(this).DataTable({
      pageLength: 10,
      order: []
    });
  });

});


// ===================== SELLER AJAX ACTION =====================
function sellerAction(id, action) {

  Swal.fire({
    title: 'Are you sure?',
    text: 'You are about to ' + action + ' this seller.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, ' + action
  }).then(result => {

    if (!result.isConfirmed) return;

    $.ajax({
      url: window.BASE_URL + '/index.php?url=sellers/ajaxAction',
      method: 'POST',
      dataType: 'json',
      data: { id: id, action: action },

      success: function (res) {
        if (res.ok) {
          Swal.fire('Success', res.message, 'success')
            .then(() => location.reload());
        } else {
          Swal.fire('Error', res.message || 'Failed', 'error');
        }
      },

      error: function () {
        Swal.fire('Error', 'Network error', 'error');
      }

    });

  });
}


// ===================== USER AJAX ACTION (NEW) =====================
function userAction(id, action) {

  Swal.fire({
    title: 'Are you sure?',
    text: 'You are about to ' + action + ' this user.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, ' + action
  }).then(result => {

    if (!result.isConfirmed) return;

    $.ajax({
      url: window.BASE_URL + '/index.php?url=users/ajaxAction',
      method: 'POST',
      dataType: 'json',
      data: { id: id, action: action },

      success: function (res) {
        if (res.ok) {
          Swal.fire('Success', res.message, 'success')
            .then(() => location.reload());
        } else {
          Swal.fire('Error', res.message || 'Failed', 'error');
        }
      },

      error: function () {
        Swal.fire('Error', 'Network error', 'error');
      }

    });

  });
}


// ===================== CONFIRM REDIRECT ACTION =====================
function confirmGo(href, text) {

  Swal.fire({
    title: 'Confirm',
    text: text || 'Are you sure?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes'
  }).then(result => {

    if (result.isConfirmed) {
      window.location.href = href;
    }

  });

}