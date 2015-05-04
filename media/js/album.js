jQuery.noConflict();
jQuery(document).ready(function ($) {
    var imgContainer = $('#images'),
        media2 = $('#media2');

    imgContainer.on('focus', 'input, textarea', function () {
        if ($(this).val() == 'Заголовок изображения' || $(this).val() == 'Альтернативный текст изображения' || $(this).val() == 'Подпись к изображению') {
            $(this).val('');
        }
    });
    imgContainer.on('blur', 'input, textarea', function () {
        if ($(this).val() == '') {
            $(this).val($(this).attr('title'));
        }
    });
    explode();
    media2.prepend($("<span id='add_video' class='btn btn-small btn-success'>Добавить</span>"));
    media2.on('click', 'span#add_video', function () {
        media2.append($('<div class="input_wrapper"><input type="text" name="jform[video][]" id="jform_video" value="" class="" aria-invalid="false"><span class="icon-delete btn btn-small" id="delete_video"></span></div>'));
    });
    media2.on('click', 'span#delete_video', function () {
        $(this).parent().detach();
    });
    $('#view-panel').on('click', 'span.btn', function () {
        var elem = $(this),
            siblings = elem.siblings();
        siblings.removeClass('btn-success');
        elem.addClass('btn-success');
        imgContainer.removeClass().addClass(elem.attr('data-value'));
    });
    var i = new Xloader('upload-panel');
    i.init();
})

function deleteImg(vol) {
    vol.parentNode.parentNode.removeChild(vol.parentNode);
}

function explode() {
    var srr = document.body.getElementById('jform_video').value.split('||');
    var wrap = document.getElementById('media2');
    for (var i = 0; i < srr.length; i++) {
        var input = document.createElement('input');
        var div = document.createElement('div');
        var del = document.createElement('span');
        div.className = 'input_wrapper';
        del.className = 'icon-delete btn';
        del.id = 'delete_video';
        input.name = 'jform[video][]';
        input.type = 'text';
        input.value = srr[i];
        div.appendChild(input);
        div.appendChild(del);
        wrap.appendChild(div);
    }
}