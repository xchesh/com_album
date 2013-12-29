var $u = jQuery.noConflict();

function Xloader(a){
    var self = this;
    
    this.option = {
        uploadUrl: '',
        idButtonUpload: 'uploadBut',
        classTempConteiner: 'tempContainer',
        idResultContainer: 'images'
    }
    
    this.init = function()
    {
        if(!self.fileAPISupport())
            return false;
        
        var input = $u('<input id="'+self.option.idButtonUpload+'" type="file" multiple />');
        $u('#'+a).append(input);
        self.setEvent();
        self.setUploadEvent();
        return true;
    }
    this.fileAPISupport = function()
    {
        if (window.File && window.FileReader && window.FileList && window.Blob) {
            return true;
        } else {
            self.showAlert('Your Brother not supported FileAPI, please update your device.', '1');
            return false;
        }
    }
    this.setUploadEvent = function()
    {
        $u('#'+a).on('change', '#'+self.option.idButtonUpload, function(ev){
           // change image function
            var files = ev.target.files;
            
            $u('.'+self.option.classTempConteiner).detach();
            
            for (var i = 0, f; f = files[i]; i++) {

                if (!f.type.match('image.*')) {
                  continue;
                }
                
                var reader = new FileReader();
                
                reader.onload = (function(theFile) {
                  
                  return function(e) {
                    var span = $u('<div class="'+self.option.classTempConteiner+
                                    '"><p><strong>'+escape(theFile.name)+
                                    '</strong> ('+(theFile.type || 'n/a')+') - '+theFile.size+
                                    ' bytes<br>Last modified: '+theFile.lastModifiedDate.toLocaleDateString()+'</p><div class="progress-bar"><div id="l'+theFile.size+'" class="progress-bar-inside"></div></div></div>');
                    
                    $u('#'+a).append(span);
                    if(self.uploadFiles(theFile))
                        return false;
                  };
                })(f);

                reader.readAsDataURL(f);
            }
        })
    }
    
    this.setEvent = function()
    {
        $u('#'+self.option.idResultContainer).on('click', '.overIMG', function(e){
            $u(this).parent().children('.attributs').fadeIn(300);
        });
        $u('#'+self.option.idResultContainer).on('click', '.attributs', function(e){
            if (e.target.nodeName=='DIV')
                $u(this).fadeOut(200);
        });
    }
    
    this.uploadFiles = function(f)
    {
        var data = new FormData();
        data.append("ajax", "1"); 
        data.append("file", f); 

        $u.ajax({
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            xhr: function() {  
                var ixhr = $u.ajaxSettings.xhr();
                if(ixhr.upload){
                    ixhr.upload.addEventListener('progress', function(e){self.progressHandling(e, f.size)}, false); 
                }
                return ixhr;
            },
            beforeSend: function() {
                self.beforeAjax();
            },
            success: function(data){
                self.successAjax(data, f.size);
            },
            error: function() {
                self.errorHandleAjax();
            }
        });
    }

    this.progressHandling = function(e, id)
    {
        var el = $u('#l'+id);
        if(e.lengthComputable){
            var width = Math.floor(e.loaded/(e.total/100));
            el.animate({'width':width+'%'}, 150);
        }
    }
    
    this.beforeAjax = function()
    {
        
    }
    
    this.successAjax = function(data, id)
    {
        var img = $u(data);
        
        $u('#l'+id).animate({'width':'100%'}, 150);
        $u('#'+self.option.idResultContainer).append(img);
        self.showAlert('Images loading!');
    }
    
    this.errorHandleAjax = function()
    {
        self.showAlert('Image not loading... Pleace, try again later.', '1');
    }
    
    this.showAlert = function(text, error)
    {
        var alertClass = 'alert alert-success';
        var message = $u('#system-message-container');
        if(error)
            alertClass = 'alert alert-error'

        message.fadeIn(300);
        message.html($u('<button type="button" class="close" data-dismiss="alert">×</button><div class="'+alertClass+'"><h4 class="alert-heading">Message</h4><p>'+text+'</p></div>'))
    }
    
}