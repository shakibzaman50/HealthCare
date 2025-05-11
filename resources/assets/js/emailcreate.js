$('#select2Basic').change(function() {
    if (this.value == 2){
      $('.user_email').removeClass('d-none');
    }else {
      $('.user_email').addClass('d-none');
    }
    if (this.value == 3){
      $('.user_emails').removeClass('d-none');
    }else {
      $('.user_emails').addClass('d-none');
    }
  });
