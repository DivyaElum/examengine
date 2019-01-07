var baseUrl = $('meta[name="base-path"]').attr('content');

var __PDF_DOC,
    __CANVAS = $('#pdf-canvas').get(0),
    __CANVAS_CTX = __CANVAS.getContext('2d');


function generatePreview(element)
{
    $('#myModal').find('embed').attr('');
	var resultId = $(element).attr('data-rd');
	var formData = new FormData();
	formData.append('result_id', resultId);

	var action = baseUrl+'/certificate/createCertificate'

	$.ajax(
    {
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: action,
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(data)
        {
            if (data.status == 'success') 
            {
                showPDF(data.pdf);
                $('#myModal').append('<input type="hidden" value="'+data.img+'" id="imgPath">');
                $('#myModal').modal('show');
            }
        }
    });
}

function showPDF(pdf_url) 
{
    PDFJS.getDocument({ url: pdf_url }).then(function(pdf_doc) 
    {
        pdf_doc.getPage(1).then(function(page) 
        {
            var scale_required = __CANVAS.width / page.getViewport(1).width;
            var viewport = page.getViewport(scale_required);

            var renderContext = {
                canvasContext: __CANVAS_CTX,
                viewport: viewport
            };
            
            page.render(renderContext);
        });

    });
}


function shareFacebook()
{     
    var title       = 'Certificate of completion'
    var url         = window.location.href;
    var imgPath     = $('#imgPath').val();
    var image       = __CANVAS.toDataURL();
    

    var facebook    = `http://www.facebook.com/sharer.php?s=100&p[title]=${title}&p[url]=${url}&p[images][0]=${image}`;
    
    window.location.href = facebook;
}

function shareTwitter()
{
    var facebook = `http://www.facebook.com/sharer.php?s=100&p[title]=YOUR_TITLE&p[summary]=YOUR_SUMMARY&p[url]=YOUR_URL&p[images][0]=YOUR_IMAGE_TO_SHARE_OBJECT`;
    window.location.href = facebook;
}

