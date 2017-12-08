var mediaProperty = [];

var chunkingEndPointURL = document.location.origin+'/weafrican/public/media/post-chunks';
var mediaUploadEndPointURL = document.location.origin + '/weafrican/public/media/upload-media';
var mediaDeleteEndPointURL = document.location.origin+'/weafrican/public/media/destroy-media';

var allowedFormats = ['jpeg', 'jpg', 'gif', 'png'];

var fileObject = {};

var profileUploader = new qq.FineUploader({
    debug: true,
    multiple: false,
    element: document.getElementById('fine-uploader-profile-pic'),
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
        allowedExtensions: allowedFormats
    },
    callbacks:{
        onComplete:function(id,name,responseJSON)
        {
            fileObject[responseJSON['uuid']] = responseJSON['fileName'];
            $('#profile-image-url').val('{"'+responseJSON['uuid']+'":"'+responseJSON['fileName']+'"}');
        }
    }
});