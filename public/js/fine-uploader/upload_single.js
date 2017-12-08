var mediaProperty = [];

var chunkingEndPointURL = document.location.origin+'/weAfrican/public/media/post-chunks';
var mediaUploadEndPointURL = document.location.origin + '/weAfrican/public/media/upload-media';
var mediaDeleteEndPointURL = document.location.origin+'/weAfrican/public/media/destroy-media';

var allowedFormats = ['jpeg', 'jpg', 'gif', 'png'];

var fileObject = {};

var profileUploader = new qq.FineUploader({
    debug: true,
    multiple: false,
    element: document.getElementById('fine-uploader'),
    request: {
        endpoint: mediaUploadEndPointURL,
        method: "POST"
    },
    deleteFile: {
        enabled: true,
        forceConfirm: true,
        endpoint: mediaDeleteEndPointURL
    },
    chunking: {
        enabled: true,
        concurrent: {
            enabled: true
        },
        success: {
            endpoint: chunkingEndPointURL
        }
    },
    resume: {
        enabled: true
    },
    validation: {
        allowedExtensions: allowedFormats,
        itemLimit:1
    },
    callbacks:{
        onComplete:function(id,name,responseJSON)
        {
            fileObject[responseJSON['uuid']] = responseJSON['fileName'];
            if (JSON.stringify(fileObject).length > 2 && responseJSON['success'] == true) {
                $('#fileArray').val(JSON.stringify(fileObject));
                $('#featured_image').val(responseJSON['fileName']);
            }
        }
    }
});
