//Form Submition
function ajaxSubmit(e, form, callBackFunction, additionalData = null) {
    e.preventDefault();
    if(form.valid()) {
        e.preventDefault();

        var action = form.attr('action');
        var form2 = e.target;
        var data = new FormData(form2);

        if (additionalData != null) {
            Object.entries(additionalData).forEach(([key, value]) => {
                data.append(key, value);
            });
        }

        $.ajax({
            type: "POST",
            url: action,
            processData: false,
            contentType: false,
            dataType: 'json',
            data: data,
            success: function(response)
            {
                if (response.status) {
                    toastr.success(response.notification);
                    if(form.attr('class') === 'ajaxDeleteForm'){
                        $('#alert-modal').modal('toggle')
                    }else{
                        $('#scrollable-modal').modal('hide');
                    }
                    callBackFunction();
                }else{
                    toastr.error(response.notification);
                }
            }
        });
    }else {
        toastr.error('Please make sure to fill all the necessary fields');
    }
}
 