$(function() {

  $('#abuy1').click(function () {
    if ($('#promo1').val() == 'HQER9D7' || $('#promo1').val() == 'ALI9DSA' || $('#promo1').val() == 'MYT2F3')
      window.location.href = "http://www.free-kassa.ru/merchant/cash.php?oa=99&o=0&us_desc=1&s=ea3f5cea31ec6c5d6ab25040d52fd0ba&m=55345";
    else
      $('#error1').show();
  });

  $('#abuy2').click(function () {
    if ($('#promo2').val() == 'HQER9D7' || $('#promo2').val() == 'ALI9DSA' || $('#promo2').val() == 'MYT2F3')
      window.location.href = "http://www.free-kassa.ru/merchant/cash.php?oa=99&o=0&us_desc=1&s=ea3f5cea31ec6c5d6ab25040d52fd0ba&m=55345";
    else
      $('#error2').show();
  });

  $('#check1').click(function () {
    if (!$('#checkbox1').prop('checked'))
      alert('Согласитесь для начала с правилами!');
    else
      window.location.href = "http://www.free-kassa.ru/merchant/cash.php?oa=199&o=0&us_desc=1&s=1582b44559ebd83a5aa42601b401a01b&m=55345";
  });

});
