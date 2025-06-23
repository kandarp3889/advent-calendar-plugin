(function($) {
    $('#userdata').DataTable( {
        dom: 'lBfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
		"lengthMenu": [[100, 500, 1000, 10000, -1], [100, 500, 1000, 10000, "All"]],
        "language": {
            "decimal":        "",
            "emptyTable":     "No data available in table",
            "info":           "Zeige _START_ bis _END_ von _TOTAL_ Einträgen",
            "infoEmpty":      "Zeige 0 bis 0 von 0 Einträgen",
            "infoFiltered":   "(filtered from _MAX_ total entries)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Show _MENU_ entries",
            "loadingRecords": "Loading...",
            "processing":     "Processing...",
            "search":         "Suche",
            "zeroRecords":    "No matching records found",
            "paginate": {
                "first":      "First",
                "last":       "Last",
                "next":       "Nächstes",
                "previous":   "Vorherige"
            },
            "aria": {
                "sortAscending":  ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        }
    });
    $(".editbox").click(function(){

     $(".promopopup").css("display","block");
     $(".dayid").val($(this).attr("data-id"));
     $(".promocode").val($(this).attr("data"));

     var day = $(this).attr("data-id");

    if ($('#boxcontent'+day).val() != undefined) 
    {
        tinymce.activeEditor.setContent($('#boxcontent'+day).val());
    }

    

     
    });
    $(".promoclose").click(function(){
     $(".promopopup").css("display","none");
     tinymce.activeEditor.setContent('');

    });

    $(".promoclose").click(function(){
     $(".propEditImage").css("display","none");
     tinymce.activeEditor.setContent('');

    });

    $(".editImage").click(function(){

     $(".propEditImage").css("display","block");
     $(".dayidIm").val($(this).attr("data-id"));
     
     $("#old_img").attr("src",$(this).attr("data-image"));

     // $(".promocode").val($(this).attr("data"));

     /*var day = $(this).attr("data-id");*/
     // console.log($('#boxcontent'+day).val());

     // tinymce.activeEditor.setContent($('#boxcontent'+day).val());

     
    });
    
})(jQuery);


/*jQuery(document).ready(function($) {
$("#save_data").on("click", function (event) {
   
    var title = $('#title').val();

    console.log(plugin_ajax_object.pva_ajax_url);


    
    var formData = new FormData($('#version_form')[0]);
    
    $.ajax({
            url: plugin_ajax_object.pva_ajax_url + '?action=savedataversion',
            type: "post",
            contentType: false,
            processData: false,
            data: formData,
            
        }).done(function (data) {
            location.reload(true);
        
        }).fail(function (jqXHR, textStatus, errorThrown) { 
    
        });


});
});*/
function toggle(source) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
    }
}

function check(source)
{
    var checkedNum = document.querySelectorAll('input[name="id[]"]:checked').length; 
    if (!checkedNum) {
        alert('Please select any one');
        event.preventDefault();
        return false;
    }
    else
    {
        return true;
    }
}