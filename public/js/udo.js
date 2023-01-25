var token;
var loadingGifOn = $("<img class='w-full h-auto' src='img/preload-elegant.gif?rand=" + Math.random() + "' />");

const init = {
    method: 'GET', cache: 'no-store', credentials: 'include',
    headers: {'X-CSRF-TOKEN': token, 'Accept': 'text/html,application/json'}
};

$(function() {
    token = $("meta[name='csrf-token']").attr('content');

    $('#contact-form').on('submit', addContact);
    $('#file-form').on('submit', upload);
    $("div[id^='download']").on('click', download);
    $("div[id^='delete']").on('click', destroy);
    $("div[id^='share']").on('click', share);
    $("div[id^='unshare']").on('click', unshare);
    $("div[id^='reverse_unshare']").on('click', unshare_reverse);
    setInterval(function () {
        getSharedFiles();
    }, 5000);
    decorateLinks();
});

function decorateLinks() {
    
}

function download() {
    $(this).closest("div[id^='ajax-file']").find($("form[class^='download']")).submit();
    return false;
}

function destroy() {
    const target = $(this).closest("div[id^='ajax-file']");
    const formData = new FormData();
    const key = $('#file-key').val();
    if(key == "") {
        alert('Your Private Key is required');
        return false;
    }
    if(!/^(0x)?[0-9a-fA-F]{64}$/.test(key)) {
        alert('Invalid private key!');
        return false;
    }
    formData.append('key', key);
    let init = {
        method: 'POST', credentials: 'include', body: formData,
        headers: {'X-CSRF-TOKEN': token, 'Accept': 'text/html,application/json'}
    };
    target.find('.loading-gif').html(loadingGifOn);
    disableLinks();
    uFetch(target.find($("form[class^='delete']")).prop('action'), init, {
        success: function(data) {
            if(data.success) target.remove();
            $('#ajax-status').html(data.status);
        },
        always: enableLinks
    });

    return false;
}

function upload() {
    const target = $(this).prop('action');
    const formData = new FormData();
    const myFile = $('#file-input').prop('files')[0];
    const key = $('#file-key').val();
    if(myFile.size > 2*1024*1024) {
        alert('Max file size is 2MB');
        return false;
    }
    if(key == "") {
        alert('Your Private Key is required');
        return false;
    }
    if(!/^(0x)?[0-9a-fA-F]{64}$/.test(key)) {
        alert('Invalid private key!');
        return false;
    }
    formData.append('file', myFile);
    formData.append('key', key);
    const init = {
        method: 'POST', credentials: 'include', body: formData,
        headers: {'X-CSRF-TOKEN': token, 'Accept': 'text/html,application/json'}
    };
    $('#loading-gif-upload').html(loadingGifOn);
    disableLinks();
    uFetch(target, init, {
        success: function(data) {
            if(data.success) {
                $('#file-panel').prepend(data.view);
                $("div[id^='ajax-file']:first-child").find("div[id^='download']").on('click', download);
                $("div[id^='ajax-file']:first-child").find("div[id^='delete']").on('click', destroy);
                $("div[id^='ajax-file']:first-child").find("div[id^='share']").on('click', share);
                $("div[id^='ajax-file']:first-child").find("div[id^='unshare']").on('click', unshare);
            }
            $('#ajax-status').html(data.status);
        },
        always: enableLinks
    });

    return false;
}

function addContact() {
    const target = $(this).prop('action');
    const formData = new FormData();
    const contact = $('#contact-input').val();
    if(!/^(0x)?[0-9a-fA-F]{40}$/.test(contact)) {
        alert('Invalid address format!');
        return false;
    } 
    formData.append('address', contact);
    const init = {
        method: 'POST', credentials: 'include', body: formData,
        headers: {'X-CSRF-TOKEN': token, 'Accept': 'text/html,application/json'}
    };
    $('#loading-gif-contact').html(loadingGifOn);
    disableLinks();
    uFetch(target, init, {
        success: function(data) {
            if(data.success) $('#contact-panel').prepend(data.view);
            $('#ajax-status').html(data.status);
        },
        always: enableLinks
    });

    return false;
}

function getContacts() {

}

function getSharedFiles() {
    uFetch($("#share-check").prop('href'), init, {
        success: function(data) {
            if(data.success) {
                $('#shared-panel').html(data.view);
                $('#ajax-status').html(data.status);
                $('#shared-panel').find("div[id^='download']").on('click', download);
                $('#shared-panel').find("div[id^='reverse_unshare']").on('click', unshare_reverse);
            }
        }
    });
}

function getFileUsers() {

}

function share() {
    const target = $(this).closest("div[id^='ajax-file']");
    const formData = new FormData();
    const contacts = $('#contact-panel').find('.contacts:checked').map(function() {return $(this).val()}).get();
    if(contacts.length < 1) {
        alert("No contact selected. Select one or more contacts to share with.");
        return false;
    }
    formData.append('contacts', JSON.stringify(contacts));
    let init = {
        method: 'POST', credentials: 'include', body: formData,
        headers: {'X-CSRF-TOKEN': token, 'Accept': 'text/html,application/json'}
    };
    target.find('.loading-gif').html(loadingGifOn);
    disableLinks();
    uFetch(target.find("form[class^='share']").prop('action'), init, {
        success: function(data) {
            if(data.success) target.find('.share-panel').append(data.view);
            $('#ajax-status').html(data.status);
            // console.log(data);
        },
        always: enableLinks
    });

    return false;
}

function unshare() {
    const target = $(this).closest("div[id^='ajax-file']");
    const formData = new FormData();
    const contacts = target.find('.contacts:checked').map(function() {return $(this).val()}).get();
    if(contacts.length < 1) {
        alert("No contact selected or you are not sharing this file with anyone.");
        return false;
    }
    formData.append('contacts', JSON.stringify(contacts));
    let init = {
        method: 'POST', credentials: 'include', body: formData,
        headers: {'X-CSRF-TOKEN': token, 'Accept': 'text/html,application/json'}
    };
    target.find('.loading-gif').html(loadingGifOn);
    disableLinks();
    uFetch(target.find("form[class^='unshare']").prop('action'), init, {
        success: function(data) {
            if(data.success) target.find('.share-panel').html(data.view);
            $('#ajax-status').html(data.status);
            // console.log(data);
        },
        always: enableLinks
    });

    return false;
}

function unshare_reverse() {
    const target = $(this).closest("div[id^='ajax-file']");
    const formData = new FormData();
    const contact = target.find('.contacts').val();
    formData.append('contact', contact);
    let init = {
        method: 'POST', credentials: 'include', body: formData,
        headers: {'X-CSRF-TOKEN': token, 'Accept': 'text/html,application/json'}
    };
    target.find('.loading-gif').html(loadingGifOn);
    disableLinks();
    uFetch(target.find("form[class^='reverse_unshare']").prop('action'), init, {
        success: function(data) {
            if(data.success) target.remove();
            $('#ajax-status').html(data.status);
            // console.log(data);
        },
        always: enableLinks
    });

    return false;
}

function uFetch(url, init, callbacks) {
    fetch(url, init).then(response => {
        if(!response.ok) throw new Error('invalid server response: ' + response.statusText);
        if(response.headers.get('content-type')?.includes("text/html")) return response.text();
        if(response.headers.get('content-type')?.includes("application/json")) return response.json();
    }).then(data => {
        if(callbacks.success) callbacks.success(data);
    }).catch(error => {
        console.log(error.message);
        if(callbacks.fail) callbacks.fail();
    }).finally(() => {
        if(callbacks.always) callbacks.always();
    });
}

function disableLinks() {
    $('#ajax-status').html("<p class='text-sm text-green-600'>sending request to blockchain...</p>");
    $('button, .ajax-btn').css('pointer-events', "none");
}

function enableLinks() {
    $('.preload-img').attr('src', '');
    $('.loading-gif').html("");
    $('button, .ajax-btn').css('pointer-events', "");
}
