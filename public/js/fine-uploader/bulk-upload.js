var mediaProperty = [];

var chunkingEndPointURL = document.location.origin+'/kickstarter/public/media/post-chunks';
var mediaUploadEndPointURL = document.location.origin + '/kickstarter/public/media/upload-media';
var mediaDeleteEndPointURL = document.location.origin+'/kickstarter/public/media/destroy-media';
var mediaPropertyURL = document.location.origin+'/kickstarter/public/media/get-media-properties';
var transcodeMediaURL = document.location.origin+'/kickstarter/public/media/transcode-media';
var thumbnailURL = document.location.origin+'/kickstarter/public/media/generate-media-thumbnail';
var clipURL = document.location.origin+'/kickstarter/public/media/generate-media-clip';

var allowedMedia = ['avi','mp4','m4v','mov','asf','avchd','flv','mpg','mpeg','wmv','m2v','3gp','mkv','divx'];
var allowedDocument = ['jpeg', 'jpg', 'gif', 'png'];

var fileObject = {};

var galleryUploader = new qq.FineUploader({
    debug: true,
    multiple: true,
    element: document.getElementById('fine-uploader-promotion'),
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
        allowedExtensions: allowedMedia
    },
    callbacks:{
        onStatusChange:function(id, oldStatus, newStatus)
        {
            if(newStatus == 'deleting' || newStatus == 'submitting') {
                $('.preview-thumbnail').html('');
                $('.image-previews').html('');
                $('.progress-message').html('');
            }
        },
        onComplete:function(id,name,responseJSON)
        {
            $.ajax({
                url: mediaPropertyURL,
                type: 'GET',
                data: {uniqueId: responseJSON['uuid'], fileName:responseJSON['fileName']},
                success: function (data) {
                    if(data['mediaType']=='video' || data['mediaType']=='audio') {
                        $.ajax({
                            url: transcodeMediaURL,
                            data: {uuid: responseJSON['uuid'], fileName: data['fileName'], uniqueId: data['uniqueId'], mediaType: data['mediaType']},
                            type: 'GET',
                            success: function(response) {
                                fileObject[responseJSON['uuid']] = response['fileName'];
                                $('#progress-section').addClass('hidden');
                            }
                        });
                    }
                }
            });
        }
    }
});

// var mediaUploader = new qq.FineUploader({
//     debug: true,
//     multiple: false,
//     element: document.getElementById('fine-uploader-media'),
//     request: {
//         endpoint: mediaUploadEndPointURL,
//         method: "POST"
//     },
//     deleteFile: {
//         enabled: true,
//         forceConfirm: true,
//         endpoint: mediaDeleteEndPointURL
//     },
//     chunking: {
//         enabled: true,
//         concurrent: {
//             enabled: true
//         },
//         success: {
//             endpoint: chunkingEndPointURL
//         }
//     },
//     resume: {
//         enabled: true
//     },
//     validation: {
//         allowedExtensions: allowedMedia
//     },
//     callbacks:{
//         onStatusChange:function(id, oldStatus, newStatus)
//         {
//             if(newStatus == 'deleting' || newStatus == 'submitting') {
//                 $('.preview-thumbnail').html('');
//                 $('.image-previews').html('');
//                 $('.progress-message').html('');
//             }
//         },
//         onComplete:function(id,name,responseJSON)
//         {
//             $.ajax({
//                 url: mediaPropertyURL,
//                 type: 'GET',
//                 data: {uniqueId: responseJSON['uuid'], fileName:responseJSON['fileName']},
//                 success: function (data) {
//                     mediaProperty = data;
//                     if(data['mediaType']=='video' || data['mediaType']=='audio') {
//                         transcodeMedia(responseJSON['uuid'], data);
//                     }
//                 }
//             });
//         }
//     }
// });

function transcodeMedia(uuid, mediaData)
{
    $('#media-submit').attr('disabled',true);
    $('#progress-section').removeClass('hidden');
    $('.progress-message').html('Transcoding Media ......');

    $.ajax({
        url: transcodeMediaURL,
        data: {uuid: uuid, fileName: mediaData['fileName'], uniqueId: mediaData['uniqueId'], mediaType: mediaData['mediaType']},
        type: 'GET',
        success: function(data) {
            mediaProperty['fileName'] = data['fileName'];
            if(mediaData['mediaType'] == 'video') {
                generateThumbnail(data['uniqueId']);
                // generateClips(data['uniqueId']);
            } else {
                $('#progress-section').addClass('hidden');
            }
        }
    });
}

function generateThumbnail(uuid)
{
    $('.progress-message').html('Generating Thumbnails...');

    var htmlData;
    $.ajax({
        url: thumbnailURL,
        type: 'GET',
        data: {uniqueId: uuid},
        success: function (data) {
            htmlData = data;
            $('.preview-thumbnail').html(htmlData);
            $('.progress-message').html('');
            $('#progress-section').addClass('hidden');
            $('#media-submit').attr('disabled',false);
        }
    });
}

// function generateClips(uuid)
// {
//     $('#progress-section').removeClass('hidden');
//     $('#media-submit').attr('disabled', true);
//     $('.progress-message').html('Generating Clips.....');

//     var htmlData;
//     $.ajax({
//         url: clipURL,
//         type: 'GET',
//         data: {uniqueId: uuid},
//         success: function(data) {
//             htmlData = data;
//             $('.preview-clip').html(htmlData);
//             $('.progress.message').html('');
//             $('#progress-section').addClass('hidden');
//             $('#media-submit').attr('disabled', false);
//         }
//     });

// }

function getValue(value) {

    if (value == 0) {
        $('#custom-thumbnail-image-section').removeClass('hidden');
        $('#cover-image-upload').prop('required', true);
    }
    else {
        $('#custom-thumbnail-image-section').addClass('hidden');
        $('#cover-image-upload').prop('required', false);
    }
}

function processPreviewImages()
{

    var formData = new FormData();

    $.each($('#thumbnail-file')[0].files, function(i, value)
    {
        formData.append("files", value);
    });

    $.ajax({

        url: $('#process-preview-url').attr('value'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        statusCode:
        {

            211: function(data) {
                loader.hide();
                uploadButton.show();
                $('.image-messages').append('<div class="alert alert-warning" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>'+ data.message + '</strong></div>');
            },
            500: function(data) {
                loader.hide();
                uploadButton.show();
                $('.image-messages').append('<div class="alert alert-warning" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>The image file size should be lower last than 2MB</strong></div>');
            },
            212: function(data) {
                loader.hide();
                uploadButton.show();
                $('.image-messages').append('<div class="alert alert-warning" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>'+ data.file + '</strong></div>');
            },
            413: function(data) {
                loader.hide();
                uploadButton.show();
                $('.image-messages').append('<div class="alert alert-warning" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>You have attempted to upload too many files at once, plase try a lower amount</strong></div>');
            },
            200: function(data) {
//                        loader.hide();
//                        uploadButton.show();
                $('.image-previews').html(data);
            }
        }
    });
}
