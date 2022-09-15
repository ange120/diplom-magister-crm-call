$(document).ready(function () {
    $(".nav-treeview .nav-link, .nav-link").each(function () {
        let location2 = window.location.protocol + '//' + window.location.host + window.location.pathname;
        let link = this.href;
        if(link == location2){
            $(this).addClass('active');
            $(this).parent().parent().parent().addClass('menu-is-opening menu-open');

        }
    });

    $('.delete-btn').click(function () {
        let res = confirm('Подтвердите действия');
        if(!res){
            return false;
        }
    });

})


tinymce.init({
    selector: '.editor',
    plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    toolbar_mode: 'floating',
    relative_urls : false,
    file_picker_callback : elFinderBrowser
});

    function getSelected (id){
        let selected = document.querySelector("#selected_"+id)
        let voice = document.querySelector("#select_voice").value

        if(voice == ''){
            return  alert('Выберете запись голоса для звонка');
        }

        selected.disabled = false
        $.ajax({
            url: '/user-call/' + id+'/'+voice,
            type: 'get',
            data: {},
            success: function(data) {
                if (data.status == true) {
                    alert('Звонок на номер '+data.phone+' выполняется!');
                } else {
                    alert(data.info);
                }
            }
        });
    }

    function updateStatus(id){
        let selected = document.querySelector("#selected_"+id)
        selected.disabled = false
    }

    function deleteUsers()
    {
        let count_start =  $('#in_form_count_start').val()
        let count_end =  $('#in_form_count_end').val()
        if(count_start === ''){
            alert('Введите значение поля "Отобрать от:"');
            return  false;
        }
        if(count_end === ''){
            count_end = 0
        }
        let form = {
            count_start: count_start,
            count_end: count_end,
        };

        $.ajax({
            type: "GET",
            url: '/admin_panel/admin-delete-many/'+ count_start+ '/'+ count_end,
            data: form,
            dataType: "json",
            encode: true,
            success: function(data) {
                console.log(data)
                if (data.status == true) {
                    alert(data.info);
                    location.reload()
                } else {
                    alert(data.info);
                }
            }
        });
    }

    function setVoice(){
        let voice = document.querySelector("#select_voice").value
        if(voice == ''){
            alert('Выберете запись голоса для звонка');
            return  false;
        }

        let lang = document.querySelector("#set_value_language")

        lang.value = voice;
        return true;
    }
    function adminCall(id){
        let voice = document.querySelector("#select_voice").value
        if(voice == ''){
            return  alert('Выберете запись голоса для звонка');
        }
        $.ajax({
            url: '/admin_panel/admin-call/' + id + '/'+voice,
            type: 'get',
            data: {},
            success: function(data) {
                if (data.status == true) {
                    alert('Звонок на номер '+data.phone+' выполняется!');
                } else {
                    alert(data.info);
                }
            }
        });
    }

   function elFinderBrowser (callback, value, meta) {
    tinymce.activeEditor.windowManager.openUrl({
        title: 'File Manager',
        url: '/elfinder/tinymce5',
        /**
         * On message will be triggered by the child window
         *
         * @param dialogApi
         * @param details
         * @see https://www.tiny.cloud/docs/ui-components/urldialog/#configurationoptions
         */
        onMessage: function (dialogApi, details) {
            if (details.mceAction === 'fileSelected') {
                const file = details.data.file;

                // Make file info
                const info = file.name;

                // Provide file and text for the link dialog
                if (meta.filetype === 'file') {
                    callback(file.url, {text: info, title: info});
                }

                // Provide image and alt text for the image dialog
                if (meta.filetype === 'image') {
                    callback(file.url, {alt: info});
                }

                // Provide alternative source and posted for the media dialog
                if (meta.filetype === 'media') {
                    callback(file.url);
                }

                dialogApi.close();
            }
        }
    });
}
